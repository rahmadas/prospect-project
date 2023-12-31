<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\PhoneBook\StorePhoneBookRequest;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use App\Models\PhoneBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function importFromPhoneBook(StorePhoneBookRequest $request)
    {
        $data = $request->validated();
        $data = $request->input('phone_book_id');

        // Dapatkan data kontak dari buku telepon
        $phoneBook = PhoneBook::findOrFail($data);

        // Proses impor ke event
        $phoneBook = Event::create($data);

        return response()->json([
            'message' => 'Successfully imported from phone book',
            'status' => true
        ], 200);

        return EventResource::collection($phoneBook)->additional([
            'message' => 'Successfully imported from phone book',
            'status' => true
        ], 200);
    }


    public function index(Request $request)
    {
        $perPage = $request->Perpage;
        $query = $request->$perPage;
        $events = Event::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');

        $query = $request->input('query', '');

        if (!empty($query)) {
            $events->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('meeting_with', 'like', '%' . $query . '%')
                    ->orWhere('meeting_type', 'like', '%' . $query . '%')
                    ->orWhere('start_date', 'like', '%' . $query . '%')
                    ->orWhere('end_date', 'like', '%' . $query . '%')
                    ->orWhere('latitude', 'like', '%' . $query . '&')
                    ->orWhere('longitude', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('reminder', 'like', '%' . $query . '%')
                    ->orWhere('note', 'like', '%' . $query . '%');
            });
        }

        $events = $events->paginate($perPage);

        return EventResource::collection($events)->additional([
            'message' => 'Successfully Index Data',
            'status' => true
        ], 200);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        // $data['start_date'] = Carbon::now()->format('Y-m-d');
        // $data['end_date'] = Carbon::now()->format('Y-m-d');
        // $data['reminder'] = Carbon::parse($data['start_date'])
        //     ->subHour()
        //     ->setTimezone('Asia/Jakarta');
        $data['meeting_type'] = 4;

        $event = Event::create($data);

        return (new EventResource($event))->additional([
            'message' => 'Successfully Create Data',
            'status' => true
        ], 200);
    }

    function show(Event $event)
    {
        return (new EventResource($event))->additional([
            'message' => 'Successfully Show Data',
            'status' => true
        ], 200);
    }

    function update(StoreEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        // Tambahkan data latitude, longitude, dan location
        // $data['latitude'] = $request->input('latitude');
        // $data['longitude'] = $request->input('longitude');
        // $data['location'] = $request->input('location');

        $event->update($data);

        return (new EventResource($event))->additional([
            'message' => 'Successfully Update Data',
            'status' => true
        ], 200);
    }

    function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Successfully Delete Data',
            'status' => true
        ], 200);
    }
}
