---
tags:
  - DataBases
  - Eloquent
  - Laravel
---

1. [[#¿Qué son?]]
2. [[#Función]]
	1. [[#Para comenzar.]]
3. [[#Creación de seeders.]]
# ¿Qué son?

Generalmente, cuando se hace una nueva migración, se utiliza la terminación `:fresh` para rehacer toda la base de datos y borrar los registros. Sin embargo, volver a crear registros una vez eliminada la base de datos es un poco tedioso, así que para eso existen los **seeders**.

# Función

Se tiene que ir a la ruta `database/seeders.php`, dentro de este archivo se verá la siguiente estructura:

```php
<?php
namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
```

## Para comenzar.

Para entender en que consiste, borraremos su contenido y usaremos el modelo ya existente de `User`. Ahora, dentro de la función `run()` se escribirá lo siguiente:

```php
// Estos datos son de ejemplo
$user = new User();
$user->name = 'admin';
$user->email = 'admin@email.com';
$user->password = bcrypt('123');
$user->save();
```

Ahora, una vez ya hecha la [[🐘Conexión a una base de datos|migración]], ejecutaremos el siguiente comando:

```shell
php artisan db:seed
```

De otro modo podemos ejecutar el comando:

```shell
php artisan migrate:fresh --seed
```

# Creación de seeders.

Para crear un nuevo `seeder` se debe ejecutar el siguiente comando (como ejemplo se usará el modelo `User` para crear un seeder):

```shell
php artisan make:seeder UserSeeder
```

El archivo creado y ya configurado podría verse de la siguiente manera:

```php
<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        //
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@email.com';
        $user->password = bcrypt('123');
        
        $user->save();
    }
}
```

Una vez creados los seeders que serán utilizados y configurados, antes de ejecutar el comando `db:seed` o `--seed` es importante entender que este comando solo ejecuta el método `run()` de el archivo `DatabaseSeeder.php`, por lo que en este archivo se ha de agregar las clases a ejecutar al momento de ejecutar los seeders.

En el archivo `DatabaseSeeder.php`:

```php
<?php
namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
	        User::class,
	        //... Demás Seeders aquí ...
        ])
    }
}
```

