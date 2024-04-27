<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class eventController extends Controller
{

    public function index()
    {
        // seleccionamos solo la informacion que queremos mostrar
        $events = Event::all(['name', 'date', 'max_capacity']);

        if ($events->isEmpty()) {
            return response()->json(['message' => 'No hay eventos'], 404);
        }

        return response()->json($events, 200);
    }

    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $id = $request->id;

        $event = Event::find($id);

        if ($event === null) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        return response()->json($event, 200);
    }
}
