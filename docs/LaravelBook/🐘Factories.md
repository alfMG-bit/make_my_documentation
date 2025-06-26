#DataBases #Eloquent #Laravel 

1. [[#¿Qué son las Factories?]]
2. [[#Funcionamiento]]
	1. [[#Función `definition()`]]
3. [[#Llamar a una fabrica.]]
	1. [[#Explicación del método]]
4. [[#Importancia de la escritura.]]
5. [[#Trabajo con seeders.]]
6. [[#Creación de Nuevas Factories]]
	1. [[#Llamar a Faker.]]
7. [[#Librerías en el Model.]]


# ¿Qué son las Factories?

Como lo dice su nombre, las `factories` funcionan como fabricas y trabajan junto con los seeders. En estas *fabricas* se estipula que se busca crear en cada campo/propiedad de un modelo.

# Funcionamiento

El proyecto Laravel por defecto ya tiene creada una ``factory`` que se encuentra en la ruta `database/factories/UserFactory.php`. Esta contiene el siguiente código:

```php
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
```

## Función `definition()`

La función `definition()` es la encargada de crear los campos de una tabla con información ya preestablecida.

```php
public function definition(): array
{
	return [
		'name' => fake()->name(),
		'email' => fake()->unique()->safeEmail(),
		'email_verified_at' => now(),
		'password' => static::$password ??= Hash::make('password'),
		'remember_token' => Str::random(10),
	];
}
```

La función en cuestión cuenta con funciones `fake()` que vienen de una librería llamada `Faker`, que en resumidas, crea registros aleatorios o con información creada o generada de forma "aleatoria" se pueden llenar campos

# Llamar a una fabrica.

Para llamar a una fabrica dentro de del [[🐘Seeders#¿Qué son?|seeder]], se debe ir al archivo `DatabaseSeeder.php` y dentro de la función `run()` escribir: 

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
        // .. Demás configuraciones del seed ...
        User::factory(3)->create();
    }
}
```

## Explicación del método

Al momento de llamar una `factory`, esta recibe un parámetro, que en este ejemplo es `3`, es un número, que se traduce como ==el numero de registros que va a hacer== (en este caso 3 registros).

# Importancia de la escritura.

Al momento de crear factories, es importante respetar el nombre, cada `factory` debe tener un modelo, por lo tanto, si tengo un modelo llamado `Sheet.php`, el nombre de su Factoría debe de ser `SheetFacotry.php`.

Al finalizar solamente se ejecuta:

```shell
php artisan migrate:fresh --seed
```

# Trabajo con seeders.

Las `Factories` al trabajar en conjunto con los seeders (en este caso de ejemplo) sería mas apropiado poner la `factory` `UserFactory.php` dentro del seeder `UserSeeder.php` y mandarla a llamar desde ahí.

```php
<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@email.com';
        $user->password = bcrypt('123');
        
        $user->save();
        // Uso de factorias AQUI
        User::factory(3)->create();
    }
}
```

# Creación de Nuevas Factories

Si se busca crear una nueva factoría, se debe recordar que se debe seguir una convención, para ello, haremos lo siguiente:

Suponiendo que el nombre de nuestra factoría va atender a un modelo llamado `Artist.php`, entonces el comando a ejecutar será:

```shell
php artisan make:factory ArtistFactory
```

Dentro del archivo se podrá comenzar a configurar la `factory`.

## Llamar a Faker.

Hay dos formas de llamar a la librería de `Faker`, la primera es hacer uso del helper `fake()`, la segunda es llamarlo por `$this->faker-><algunaFuncionFaker>()`. La función a llamar dependerá del campo que se busque llenar con [Faker](https://fakerphp.org/).

# Librerías en el Model.

Es importante verificar que en el modelo se contengan las siguientes librerías:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends Model
{
    use HasFactory;
    //...
}
```
