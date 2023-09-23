<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::orderBy('user_id', 'asc')->get();
        return TaskResource::collection($task);
    }

    public function store(StoreTaskRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $task = Task::create($data);

        return (new TaskResource($task))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Task $task)
    {
        return (new TaskResource($task))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $task->update($data);

        return (new TaskResource($task))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'successfully deleted date'
        ], 200);
    }
}