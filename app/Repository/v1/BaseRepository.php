<?php

namespace App\Repository\v1;

use App\Repository\v1\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Throwable;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    protected string $error;

    public function __construct(string $model)
    {
        $this->model = new $model;
    }

    public function getError(): string
    {
        return $this->error;
    }

    protected function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param callable $event
     * @return null|bool|Model
     */
    public function commit(callable $event): null|bool|Model
    {
        try {
            return $event();
        } catch (Throwable $exception) {
            $this->error = $exception instanceof QueryException
                ? $exception->errorInfo
                : $exception->getMessage();
        }

        return null;
    }

    /**
     * Safety publish changes
     *
     * @param Model $model
     * @return Model|null
     */
    public function save(Model $model): ?Model
    {
        return $this->commit(function () use ($model) {
            $model->saveOrFail();
            return $model->refresh();
        });
    }

    public function list(): Collection|array
    {
        return $this->query()->get();
    }

    public function getId($id): Model|Collection|Builder|array|null
    {
        return $this->query()->find($id);
    }

    public function create(array $data): ?Model
    {
        return $this->save($this->query()->make($data));
    }

    public function update($id, array $data, ?array $relations = null): ?Model
    {
        $model = $this->getId($id);
        $model->fill($data);

        /**
         * Update dynamically relationships
         * @see https://laravel.com/docs/9.x/eloquent-relationships#syncing-associations
         */
        if (is_array($relations) && !empty($relations)) {
            foreach ($relations as $relation => $keys) {
                $model->{$relation}()->sync($keys);
            }
        }

        return $this->save($model);
    }

    public function delete($id): bool
    {
        return $this->commit(fn () => $this->getId($id)->deleteOrFail());
    }
}
