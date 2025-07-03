#controllers #DataBases #Eloquent #models #config #auth #Laravel 

Para configurar las autenticaciones en Laravel, se debe ir a la ruta ``Config/auth.php``. Dentro de esta ruta se agregarán las autenticaciones para manejo de sesiones. Dentro de este archivo se deben agregar tanto los ``guards`` como los ``providers`` en base al modelo y la tabla de la base de datos que se vaya a utilizar

```php
'guards' => [

        'web' => [

            'driver' => 'session',

            'provider' => 'users',

        ],

  
		// El agregado
        'artist' => [

            'driver' => 'session',

            'provider' => 'artists'

        ]

    ],


'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
		// El agregado
        'artists' => [
            'driver' => 'eloquent',
            'model' => App\Models\Artist::class
        ]
    ],
```

Ahora se debe crear un ``controlller``


