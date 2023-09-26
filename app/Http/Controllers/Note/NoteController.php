<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\Note\NoteResource;
use App\Models\Contact;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $note = Note::orderBy('contact_id', 'asc')->get();
        return NoteResource::collection($note);
    }

    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();
        $data['user'] = auth()->user()->id;
        $data['date'] = Carbon::now();

        // dd($data);
        $note = Note::create($data);

        return (new NoteResource($note))->additional([
            'status' => 'Successfully Create Date'
        ], 200);
    }

    function show(Note $note)
    {
        return (new NoteResource($note))->additional([
            'status' => true
        ], 200);
    }

    function update(StoreNoteRequest $request, Note $note)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $note->update($data);

        return (new NoteResource($note))->additional([
            'status' => 'Successfully Update Date'
        ], 200);
    }

    function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'status' => 'Seccessfully Delete Date'
        ], 200);
    }
}
