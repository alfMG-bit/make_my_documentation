#routes #Laravel 

# Contenido
1. [[#Contenido]]
2. [[#¿Qué es?]]
3. [[#En la vista]]
4. [[#En el controlador]]
5. [[#Encontrar un registro por medio de otra propiedad.]]
6. 


# ¿Qué es?

Se trabaja con este concepto desde el momento que en una vista se trabaja con las propiedades de un modelo, En un ``foreach``, cada que recuperamos un usuario individual, se recupera por el `id`. Por ejemplo:

```php
public function index() 
{
	$users = User::orderBy('id', 'desc')->paginate();
	return view('home', compact('users'));
}
```

En la vista:

```html
@foreach($users as $user)
	<a href={{ route('users.show', $user->id) }}>Ver usuario {{ $user->name }}</a>
@endforeach
```

Sin embargo, el``Route Model Binding`` ahorra líneas de código y escritura.

# En la vista

Para ahorrar escritura en las ``vista.blade.php``:

```html
{{-- Omitimos llamar al id con '->id' y solamente llamamos al objeto en concreto --}}
@foreach($users as $user)
	<a href={{ route('users.show', $user) }}>Ver usuario {{ $user->name }}</a>
@endforeach
```

En este caso, en la vista reemplazamos `$user->id` por solamente `$user`, blade interpreta de inmediato que se va a capturar el id de ese usuario (en este ejemplo).

# En el controlador

En el controlador en lugar de solicitar la búsqueda con `::find()`, se puede hacer directamente desde el parámetro, referenciando al modelo en cuestión (en este caso a ``User``):

Forma convencional:

```php
public function show($user)
{
	$user = User::find($user);
	return view('user', compact('user'));
}
```

**Usando Route Binding**:

```php
public function show(User $user)
{
	return ('user', compact('user'));
}
```

# Encontrar un registro por medio de otra propiedad.

Es aquí donde se busca que en lugar de buscar elementos por el ``id`` lo haga por medio de otro campo y/o propiedad.

Para ello, dentro de cualquier lugar de la clase del `Model` en cuestión se agregará la siguiente función:

```php
public function getRouteKeyName()
{
	return 'propertyName';
}
```

En este ejemplo ``propertyName`` representaría el campo por el cuál se accederá a cada elemento, o se editaría o se eliminaría. Esto quiere decir que la ruta (por ejemplo) `users/user/1` donde `1` representa el id de algún `User` se mostraría como ``users/user/jaime%20altozano``.

# Problemas de Key Routes.

Sin embargo, encontrar elementos por el titulo es una mala practica, debido a que pueden contener caracteres especiales. Además, usar campos como el nombre o título de algún elemento, pueden ser repetidos y puede generarse un problema, o sea, que dos títulos o nombres sean el mismo pero los elementos sean distintas entidades.

Se puede usar el id, es optimo porque es una propiedad única del Modelo, sin embargo, a nivel de CEO es ineficiente porque ver el id en una URL no define bien que contenido se esta tratando en esta URL. Entonces ¿Qué se puede hacer?

# Solución trabajando con SLUG.

Slug permite trabajar con URL's únicas, que no solo arregla el problema de elementos con titulo o nombre duplicado, sino que también hace un trabajo de tratado de caracteres especiales y espaciado.

## Modificación en Migrations.

Para comenzar, se debe ir a la migración de alguna tabla, por ejemplo, `artists`. Posteriormente, en la tabla, en el método ``up()`` se debe agregar el campo `slug()->unique`, este campo será único, por eso se le agrega `unique()`:

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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Se agrega el campo slug
            $table->string('name');
            $table->string('email')->unique();
            $table->date('register_date')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
```

Ahora se modifican las factories, en este caso, de `ArtistFactory.php`, en la función ``definition`` se agrega la siguiente instrucción:

```php
[...
'slug' => $this->faker->slug(),
...]
```

Una vez hecho esto, se debe refrescar las migraciones:

```shell
php artisan migrate:fresh --seed
```

Una vez migrada la base de datos, se debe ir a el modelo en cuestión, en este caso, `Artist.php`, y dentro de la función ``getRouteKeyName()`` se pondrá que el retorno en lugar de ser, en este caso, el nombre del artista, debe ser el slug:

```php
public function getRouteKeyName()
{
	return "slug";
}
```

De esta manera, ahora si se ingresa a una URL de alguno de los artistas, se vera su slug en vez de su id, y además este ``slug`` será único.

>[!DANGER] Prevención de un error inherente.
>Antes de terminar, sería bueno saber que hacer con los formularios, pues si se observa bien, los formularios no tienen como llenar el campo **slug**, por lo tanto, es importante hacer algo al respecto con la generación del **slug**.

Para empezar, de deben modificar las redirecciones: [[🐘Redireccionamiento]]

Posteriormente a corregir el direccionamiento, se tiene que mejorar la creación de un slug

# Creación apropiada para un slug
