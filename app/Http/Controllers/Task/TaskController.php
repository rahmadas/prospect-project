<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
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
        $data['due_date'] = Carbon::now();
        $data['due_time'] = Carbon::now();
        $data['reminder'] = Carbon::parse($data['due_date'])
            ->subHour() // Mengurangkan satu jam dari waktu due_date
            ->setTimezone('Asia/Jakarta');
        $data['status'] = 1;

        // perulangan untuk status, akan di kerjakan nesok di kantor
        // if (condition) {
        //     # code...
        // }

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
