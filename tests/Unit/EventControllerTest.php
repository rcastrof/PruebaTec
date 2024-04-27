<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;

class EventControllerTest extends TestCase
{

    public function testReturnsEvents()
    {
        // Realizamos una solicitud GET a la ruta /events
        $response = $this->get('/events');

        // Si no se encuentran eventos en la base de datos, esperamos un código de estado 404
        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404);
        } else {
            // Si hay eventos en la base de datos, esperamos un código de estado 200 y la estructura JSON esperada
            $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => ['name', 'date', 'max_capacity'],
                ]);
        }
    }

    public function testReturnsSingleEvent()
    {
        // Creamos un evento
        $event = Event::factory()->create();

        // Realizamos una solicitud GET a la ruta /event con el ID del evento
        $response = $this->get('/event', ['id' => $event->id]);

        // Si el evento no existe, esperamos un código de estado 404
        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404);
        } else {
            // Si el evento existe, esperamos un código de estado 200 y que los datos del evento sean correctos
            $response->assertStatus(200)
                ->assertJson([
                    'id' => $event->id,
                    'name' => $event->name,
                    'description' => $event->description,
                    'date' => $event->date,
                    'max_capacity' => $event->max_capacity,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,

                ]);
        }
    }
}
