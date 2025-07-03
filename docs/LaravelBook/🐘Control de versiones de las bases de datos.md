---
tags:
  - DataBases
  - Laravel
date: 2025-06-22
topic: Bases de datos
---
# Contenido

1. [[#Migraciones]]
2. [[#Método `up()`.]]
3. [[#Método `down()`.]]
4. [[#Tabla Migrations]]
5. [[#Actualización de tablas (métodos destructivos).]]
6. [[#Actualización de Tablas (métodos no destructivos).]]

Cuando iniciamos una migración en nuestro proyecto Laravel, siempre se nos crean 3 migraciones por defecto, cada una de ellas cumple con un objetivo en específico.

<div align="center">
	<img src="Migraciones de Laravel 20250406131655.png" />
</div>

Estas viene por defecto en cada una de las migraciones que hacemos.

# Migraciones

- [[#0001_01_000000_create_users_table.|0001_01_000000_create_users_table.]]


## 0001_01_000000_create_users_table.

Esta clase contiene la siguiente estructura. Es importante destacar que esta clase anónima tiene dos métodos, uno llamado `up()` y el otro llamado `down()`:

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
  
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
  
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
```

# Método `up()`.

- [[#Profundizando en las funciones del objeto `Blueprint`.|Profundizando en las funciones del objeto `Blueprint`.]]


La sentencia `Schema` puede mandar a llamar algunos tipos de funciones, la primera es `create`:

```php
Schema::create('users', function (Blueprint $table) {
	...
});
```

- `'users'`: Esta sentencia determina como es que se va a llamar la tabla cuando se haya creado.
- `function ()`: Es la función calva que recibirá un objeto de tipo `Blueprint`
- `Blueprint $table`: Este será el parámetro que permitirá crear campos dentro de la tabla 

Para correr un método `up()` se ejecuta el siguiente comando:

```shell
php artisan migrate
```

### Profundizando en las funciones del objeto `Blueprint`.

Suponiendo que nuestro objeto `Blueprint` haya sido inicializado de la siguiente manera: `Blueprint $table` entonces las funciones se llevarían acabo de la siguiente manera: `$table->funcion()`

**Funciones:**

- `$table->id()`: Crea un campo en la tabla con nombre *"Id"*, de tipo `bigint(20)` que además tiene por cualidad de MySQL `Autoincrement`.
- `$table->string('table field')`: Un campo común con el nombre que se asigno en `table field` de tipo `string` (cadena).
- `$table->string('table field unique')->unique()`: Es un campo de la tabla común de tipo `string` pero que será único, esto quiere decir que sus valores serán irrepetibles. Por ejemplo, no habrá en la tabla dos emails repetidos, porque se supone que los emails son únicos.
- `$table->timestamp('time field')->nullable()`: Este campo de tipo `timestamp` es un campo de tipo fecha, lo que quiere decir es que registrará la fecha de algo. `nullable` quiere decir que este campo puede estar vacío y no siempre se le pasará información.
- `$table->remember_token()`: Este campo es de tipo `varchar(100)`, este generalmente se usa para recordar si la sesión del usuario sigue activa o no.
- `$table->timestamps()`: Este en realidad crea dos campos. `created_at` registra la fecha de cuando se creo dicho registro y `updated_at` de cuando se ha actualizado algo de ese registro.

Para más información visitar la documentación de **Laravel**.

# Método `down()`.

Este método en específico, revierte todos los cambios hechos en el método `up()`. Haciendo alguna analogía burda, es como dar a `CTRL + Z` para revertir cambios hechos en word:

```php
public function down(): void
{
	Schema::dropIfExists('users');
	Schema::dropIfExists('password_reset_tokens');
	Schema::dropIfExists('sessions');
}
```

Para ejecutar este tipo de funciones en las migraciones, se escribirá en la consola:

```shell
php artisan migrate:rollback
```

# Tabla Migrations

- [[#Columnas|Columnas]]
	- [[#Columnas#¿Qué significa `batch`?|¿Qué significa `batch`?]]


Al ejecutar el comando `php artisan migrate` junto con todas las migraciones también se crea una tabla llamada ``migrations``, esta tabla contiene las migraciones hechas.

<div align="center">
	<img src="Migraciones_hechas_20250406141606.png"/>
</div>

## Columnas

Las columnas son el `id` de la migración, la `migration` que contiene su nombre y `batch`.

### ¿Qué significa `batch`?

Primeramente deberemos crear una nueva [[🐘Conexión a una base de datos#Crear una nueva migración en Laravel.|migración]]. Una vez creada, aparecerá esta estructura:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
```

En esta estructura nosotros podemos definir los campos de las tablas que pertenecerán a las tablas de esta migración. Sin embargo, hay una mejor manera de hacer esto. Laravel tiene una estructura de diseño que nos ayuda a crear desde cero una plantilla de migraciones perfecta para trabajar, la clave es en agregar a la sentencia `make:migration` la frase `create_nombreMigración_table` quedando de la siguiente manera: (usando de ejemplo 'artist').

```shell
php artisan make:migration create_artist_table
```

Y la estructura final quedaría de forma más especializada para crear las respectivas tablas:

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artist', function (Blueprint $table) {
            $table->id();
            // ---------------------------------
            // Aqui se pueden agregar mas campos
            // ---------------------------------
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist');
    }
};
```

Al ejecutar nuevamente `php artisan migarte` creará la migración con las respectivas tablas, pero además, el batch que tendrán estas nuevas tablas será diferente a la de las primeras migraciones:

![[Tabla_de_ejemplo_migraciones_20250406154900.png]]

La tabla de ``migrations``:

![[Pasted image 20250406154952.png]]

El campo `batch` representa el lote en el que esa migración fue hecha, como es apreciable, las primeras tres se hicieron en el primer bloque de migración, al inicio del proyecto, por ejemplo, y la 4 se hizo en algún otro momento posterior.

# Actualización de tablas (métodos destructivos).

- [[#Diferencia entre `refresh` y `fresh`|Diferencia entre `refresh` y `fresh`]]


Cuando en un tabla hizo falta algún campo que por error se olvido, o no se agregó, Laravel nos permite hacer actualizaciones de nuestras migraciones con un solo comando:

```shell
php artisan migrate:refresh
```

Este comando lo que hace es ejecutar todas las funciones `down` de todas las migraciones y luego ejecuta todas las funciones `up`. Es como hacer un `rollback` y `migrate` al mismo tiempo en todas.

## Diferencia entre `refresh` y `fresh`

`refresh` borra y crea todas las tablas que hayan sido hechas por las migraciones de PHP, mientras que `fresh` borra y crea todas las tablas de la base de datos, haciendo que se resetee todo por completo. `refresh` y `fresh` es indiferente si todas tus tablas de la base de datos han sido hechas por migraciones, pero si tienes tablas que se hicieron por fuera o que ya existían en la base de datos, **lo mejor será evitar usar `fresh`**.

# Actualización de Tablas (métodos no destructivos).

Al actualizar los campos de una tabla con `refresh` o con `fresh` se destruyen los registros ya creados en esa tabla. Para evitar eso usaremos el siguiente ejemplo

Creamos la migración `artist`, a la cual ya le hemos registrado un usuario:
![[Ejemplo_metodo_no_destructivo_20250406161008.png]]

Se quiere agregar un nuevo campo a la tabla sin tener que eliminar los registros ya creados

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artist', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('alias')->nullable();
            // queremos agregar nuevo campo $table->string('genre');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist');
    }
};
```

Para realizar esta tarea, ejecutaremos el siguiente comando 

```shell
php artisan make:migration add_genre_to_artist_table
```

Este comando creará la siguiente migración:

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('artist', function (Blueprint $table) {
            //
        });
    }
    
    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('artist', function (Blueprint $table) {
            //
        });
    }
};
```

Si se observa bien, el método tanto `up` como `down` en lugar de utilizar las acciones `Schema::create` usan las acciones `Shcema::table` que fungen como actualizaciones para las tablas.

Agregaremos el nuevo campo en Método `up()`:

```php
public function up(): void
{
	Schema::table('artist', function (Blueprint $table) {
		//
		$table->string('genre')->nullable();
	});
}
```

Método `down()`:

```php
public function down(): void
{
	Schema::table('artist', function (Blueprint $table) {
		//
		$table->dropColumn('genre');
	});
}
```

Ahora ejecutamos:

```shell
php artisan migrate
```

Y esto actualizara los campos de la base de datos.

![[ActializaciónMigrate_1_20250406162454.png]]

Si se busca que este nuevo campo este agregado en otro espacio y no al final, primeramente haremos un `rollback` y en la función `up()` agregaremos al campo ``after``

```php
public function up(): void
{
	Schema::table('artist', function (Blueprint $table) {
		//
		$table->string('genre')->nullable()->after('alias');
	});
}
```

y lo pondrá después del campo `alias`.

