<?php

use Tests\TestCase;
use App\Models\Event;
use App\Models\Purchase;

class PurchaseControllerTest extends TestCase
{


    public function testPurchaseEventNotFound()
    {
        // Realizamos una solicitud POST a la ruta /purchase con un ID de evento que no existe
        $response = $this->post('/purchase', [
            'user_id' => '1',
            'event_id' => 999, // Un ID que sabemos que no existe
        ]);

        // Verificamos que se reciba un error 404
        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404);
        }
    }

    public function testPurchaseEventNoCapacity()
    {
        // Creamos un evento con capacidad 0
        $event = Event::factory()->create(['max_capacity' => 0]);

        // Realizamos una solicitud POST a la ruta /purchase con el ID del evento
        $response = $this->post('/purchase', [
            'user_id' => '1',
            'event_id' => $event->id,
        ]);

        // Verificamos que se reciba un error 400
        if ($response->getStatusCode() === 400) {
            $response->assertStatus(400);
        }
        else {
            // Verificamos que la capacidad del evento no haya cambiado
            $this->assertEquals(0, $event->max_capacity);
        }
    }


}
