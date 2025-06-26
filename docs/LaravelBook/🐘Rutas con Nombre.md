#routes #Laravel 

# ¿Qué son y qué problemática resuelven?

Las rutas con nombre surgieron en respuesta a una problemática. Imaginando que un desarrollador entrega el producto a un cliente, pero a este no le gusta que la URL, para acceder a un conjunto de usuarios, diga `/usuarios`, sino que diga `/users`.

El desarrollador cambia las ``routes`` por este nombre

```php
Routes::get('/usuarios', public function() {return "usuarios";})
//Nueva url
Routes::get('/users', public function() {return "usuarios";})
```

Pero para esto, hay varios problemas

1. Se tendría que reescribir una por una cada una de las rutas
2. Los links internos y acciones en formularios que trabajen con las antiguas URL tendrán que ser corregidos 1 por 1, lo cual resulta poco efectivo

Es aquí cuando Laravel introduce las rutas con nombre, que ahorran todo este trabajo de corregir cada una de las rutas y simplemente asignarles un nombre con el cual fungirán, y este se puede modificar en una sola línea de código.

# Codificación.

Para asignar el nombre a cada una de las rutas se usa el método `->name()`. Por convención, name utiliza de nombre el nombre de la ruta, seguido de un punto, y después el nombre del método del controlador que lo acompañá:

```php
// example
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
```

Ahora, en los links internos del HTML, por ejemplo una etiqueta `<a>` se utiliza un método llamado `route()` y dentro de este método se escribirá el nombre de la ruta a la que se hace referencia:

```html
<a href="{{ route('posts.index') }}">Back to Home</a>
```

Si la ruta requiere de algún parámetro se hace de la siguiente manera:

```html
<a href="{{ route('posts.index', ['id' => $post->id]) }}">Back to Home</a>
```

o pasamos directamente el parámetro

```html
<a href="{{ route('posts.index', $post->id) }}">Back to Home</a>
```

**Si se pasan mas parámetros, se hace lo siguiente**

```html
<a href="{{ route('posts.index', [$post->id, $post->name, ...]) }}">Back to Home</a>
```

# Convenciones.

Es importante que si a futuro, en el proyecto, se desean automatizar varios procesos, es bueno llevar los nombres de las rutas con las siguientes características:

1. Los nombres de las rutas deben ir en inglés.
2. Los nombres de las rutas comienzan en plural y sus rutas consecuentes llevan nombres en singular

Ejemplos:

```php
Route::get('artists', [ArtistController::class, 'index']);
Route::get('artists/{artist}', [ArtistController::class, 'show']);
```