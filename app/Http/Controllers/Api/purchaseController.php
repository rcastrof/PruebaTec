<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use App\Models\Purchase;
use App\Models\Event;


class purchaseController extends Controller
{


    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Verifica si el evento existe antes de intentar crear la compra
        $event = Event::find($request->event_id);

        if (!$event) {
            return response()->json(['error' => 'No existe evento con esa ID'], 404);
        }

        // Verifica si hay capacidad disponible en el evento
        if ($event->max_capacity <= 0) {
            return response()->json(['error' => 'No quedan entradas disponibles para este evento'], 400);
        }

        DB::beginTransaction();

        try {
            // Crea la compra utilizando los datos proporcionados
            $purchase = Purchase::create([
                'user_id' => $request->user_id,
                'event_id' => $request->event_id,
            ]);

            // Verifica si la compra se creó correctamente
            if (!$purchase) {
                throw new \Exception('Error al crear la compra');
            }

            // Reduzca en 1 la capacidad máxima del evento
            $event->decrement('max_capacity');

            // Confirma la transacción si todo fue exitoso
            DB::commit();

            return response()->json([
                'message' => 'Compra realizada con éxito',
                'Evento' => $event->name,
                'Entradas disponibles' => $event->max_capacity

            ], 201);
        } catch (\Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Busca todas las compras del usuario con el user_id proporcionado
        $orders = Purchase::with(['event' => function ($query) {
            $query->select('id', 'name', 'date'); // Aquí seleccionamos los campos name y date del evento
        }])
        ->where('user_id', $request->user_id)
        ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Este usuario no tiene compras registradas'], 404);
        }

        return response()->json($orders, 200);
    }
}
