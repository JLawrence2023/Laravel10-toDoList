<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Contracts\TaskContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskContract $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->orderByPosition();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input('tasks');
        $newTask = new Task();
        $newTask->title = $data['title'];
        $newTask->tag = $data['tag'];
        $newTask->list = $data['list'];
        $maxPosition = Task::max('position');
        $newTask->position = $maxPosition + 1;


        $newTask->save();

        return $newTask;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $data = $request->input('tasks');
            $task->title = $data['title'];
            $task->tag = $data['tag'];
            $task->list = $data['list'];
            $task->save();

            return response()->json(['message' => 'Task updated successfully']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    public function reorder(Request $request)
    {
        $sourceItemId = $request->input('sourceItemId');
        $targetItemId = $request->input('targetItemId');

        $this->taskRepository->reorderTasks($sourceItemId, $targetItemId);

        return response()->json(['message' => 'Tasks reordered successfully']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

}
