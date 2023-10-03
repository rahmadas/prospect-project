<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->Perpage;
        $query = $request->$perPage;
        $events = Event::orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $events->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('meeting_with', 'like', '%' . $query . '%')
                    ->orWhere('meeting_type', 'like', '%' . $query . '%')
                    ->orWhere('start_date', 'like', '%' . $query . '%')
                    ->orWhere('end_date', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('reminder', 'like', '%' . $query . '%')
                    ->orWhere('note', 'like', '%' . $query . '%');
            });
        }

        $events = $events->paginate($perPage);

        return EventResource::collection($events)->additional([
            'status' => 'Successfully Index Date'
        ], 200);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['start_date'] = Carbon::now();
        $data['end_date'] = Carbon::now();
        $data['reminder'] = Carbon::parse($data['start_date'])
            ->subHour()
            ->setTimezone('Asia/Jakarta');
        $data['meeting_type'] = 2;

        $event = Event::create($data);

        return (new EventResource($event))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Event $event)
    {
        return (new EventResource($event))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $event->update($data);

        return (new EventResource($event))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'status' => 'Successfully Delelt Date'
        ], 200);
    }
}
