
## Prueba Técnica

evidencias en video:
https://www.youtube.com/watch?v=Tu5ISd9Hx_Q


***notas***

coleccion de Postman dentro del repo

DB_CONNECTION : sqlite

Laravel v11.5.0 (PHP v8.2.12)

Se concideran solo 2 modelos : event y purchase.

1) git clone
2) composer install
3) php artisan migrate:fresh --seed
4) aceptar crear base de datos
5) php artisan serve
6) IMPORTAR coleccion postman a postman
7) recorrer urls
8) kill terminal y test unitarios
9) php artisan test --testsuite=Unit

***Factorys***

php artisan migrate:fresh --seed

Los ***eventos*** estan cargados como seeders, son 10 aprox, asi no tenemos que crear ni editar.

***Event***
- /events GET Obtiene el listado de eventos disponibles, con la información más relevante del evento ()
- /event GET Obtiene la información completo del evento

***Purchase***

- /purchase POST Crea la compra de un un ticket para un cliente

- /orders GET Lista todas las compras de un cliente

***Test Unitarios***

php artisan test --testsuite=Unit


Hay un test por cada ruta, siendo estos

- Realizamos una solicitud GET a la ruta /events y esperamos un código de estado 200 y la estructura JSON esperada.
- Realizamos una solicitud GET a la ruta /event con el ID del evento y si el evento existe, esperamos un código de estado 200 y que los datos del evento sean correctos

- Realizamos una solicitud POST a la ruta /purchase con un ID de evento que no existe y verificamos que se reciba un error 404

- Creamos un evento con capacidad 0, realizamos una solicitud POST a la ruta /purchase con el ID del evento y verificamos que la capacidad del evento no haya cambiado



