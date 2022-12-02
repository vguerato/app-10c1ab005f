<?php

namespace App\Repository\v1\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function save(Model $model);

    public function list();

    public function getId($id);

    public function create(array $data);

    public function update($id, array $data, ?array $relations = null);

    public function delete($id);
}
