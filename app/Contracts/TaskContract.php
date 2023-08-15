<?php

namespace App\Contracts;

interface TaskContract
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function orderByPosition();

    public function reorderTasks($sourceItemId, $targetItemId);

    public function delete($id);
}
