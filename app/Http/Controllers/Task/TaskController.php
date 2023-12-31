<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage;
        $query = $request->$perPage;
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $tasks->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('note', 'like', '%' . $query . '%')
                    ->orWhere('due_date', 'like', '%' . $query . '%')
                    ->orWhere('due_time', 'like', '%' . $query . '%')
                    ->orWhere('priority', 'like', '%' . $query . '%')
                    ->orWhere('reminder', 'like', '%' . $query . '%')
                    ->orWhere('status', 'like', '%' . $query . '%')
                    ->orWhere('relate_to', 'like', '%' . $query . '%');
            });
        }

        $tasks = $tasks->paginate($perPage);

        return TaskResource::collection($tasks)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        // $data['due_date'] = Carbon::now()->format('Y-m-d');
        // $data['due_time'] = Carbon::now()->format('H:i:s');
        // $data['reminder'] = Carbon::parse($data['due_date'])
        //     ->subHour() // Mengurangkan satu jam dari waktu due_date
        //     ->setTimezone('Asia/Jakarta');
        $data['status'] = 1;

        // if (condition) {
        //     # code...
        // }

        $task = Task::create($data);

        return (new TaskResource($task))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Task $task)
    {
        return (new TaskResource($task))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 1;
        $task->update($data);

        return (new TaskResource($task))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }
}
