#routes #Laravel 
# Introducción.

## Lectura de rutas

Para comenzar sería bueno saber cuantas rutas se han creado en el proyecto Laravel, para ello, se puede ejecutar el siguiente comando:

```shell
php artisan r:l
```

Este comando mostrará cuantas `Routes` se han creado en el proyecto

# Codificación.

Para comenzar con la definición de una `Rout::resources` se debe escribir la siguiente línea de código:

```php
Route::resource('routes', RouteController::class)
```

>[!WARNING] Importante
>Es importante verificar las [[🐘Rutas con Nombre#Convenciones.|convenciones]] de rutas y las [[🐘Creación de un Crud#Convenciones.|convenciones de un crud]] que permiten un mejor flujo y automatización del trabajo al momento de usar los comandos.

La estructura se compone de las palabras clave, para generar un ``Route::resources`` de una ruta que, por ejemplo, se llama `artists` todas las rutas desplegadas se verían así:

```php
Route::get('/artists/createArtist', [ArtistController::class, 'create'])->name('artists.create');

Route::post('/artists/createArtist', [ArtistController::class, 'store'])->name('artists.store');

Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');

Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');

Route::get('/artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit');

Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');

Route::delete('/artists/{artist}/delete', [ArtistController::class, 'destroy'])->name('artists.destroy');
```

Si se usa `Route::resources` se vería de la siguiente manera:

```php
Route::resource('artists', ArtistController::class);
```

Esta sola línea de código creará con todas las [[🐘Creación de un Crud#Convenciones.|convenciones]] las rutas de la página web. 

## Excepciones.

Si se quiere excluir alguno de los métodos, por ejemplo, el método `destroy`, sería de la siguiente manera:

```php
Route::resource('artists', ArtistController::class)->except('destroy');
```

Si se quiere exceptuar más de una ruta, se puede meter todo en una lista:

```php
Route::resource('artists', ArtistController::class)->except(['destroy', 'edit', 'update']);
```

## Creación específica.

Si solo se busca crear algunos métodos, además de `except` existe el método `only`, que crea los métodos especificados dentro de el método:

```php
Route::resource('artists', ArtistController::class)->only(['create', 'store']);
```

Esta línea de código solo creara las rutas para ese controlador con solo los métodos `create` y `store`.

# Cambios de nombre.

Si por alguna razón, en algún momento se cambia la URL, por ejemplo, de `artists` a `artistas`, toda la página se caerá debido a que las urls mantienen los nombre de tipo `artists.<method>`.

Para evitar que se caigan, Laravel nos deja asignar los nombres a las rutas, independientemente de si se cambia el nombre de las URL's:

```php
// Cambia 'artists' por 'artistas'
Route::resource('artistas', ArtistController::class)->names('artists');
```

Este comando incluso cambiará el nombre de las URL's de tipo parámetro (en este ejemplo se verían como `artistas/artista`).

## Sin cambiar el parámetro.

Pero en dado caso que no se desee cambiar el parámetro de la URL, se puede usar el siguiente método:

```php
Route::resource('artistas', ArtistController::class)
->parameters(["artista" => "artist"])
->names("artists");
```

# Resource para API's.

En las API's, generalmente, no se usan vistas. Además de poder usar ``except`` para omitirlas, Laravel nos ofrece el método de `Route` `Route::apiResource()`, para crear apis.