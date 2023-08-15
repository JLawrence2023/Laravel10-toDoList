<?php

namespace App\Repositories;

use App\Contracts\TaskContract;
use App\Models\Task;

class TaskRepository implements TaskContract
{
    protected $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function orderByPosition()
    {
        return Task::orderBy('position')->get();
    }


    public function reorderTasks($sourceItemId, $targetItemId)
    {
        $sourceTask = Task::find($sourceItemId);
        $targetTask = Task::find($targetItemId);

        if ($sourceTask && $targetTask) {
            $sourcePosition = $sourceTask->position;
            $targetPosition = $targetTask->position;

            $sourceTask->position = $targetPosition;
            $targetTask->position = $sourcePosition;

            $sourceTask->save();
            $targetTask->save();
        }
    }


    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
