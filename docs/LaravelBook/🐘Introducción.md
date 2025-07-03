---
tags:
  - routes
  - controllers
  - Laravel
---

# Contenido

- [[#Inicialización de un proyecto en Laravel.]]
- [[#Tipos de peticiones.]]
	- [[#GET.|GET.]]
	- [[#POST.|POST.]]
		- [[#POST.#POST|POST]]
		- [[#POST.#PUT Y PATCH|PUT Y PATCH]]
		- [[#POST.#DELETE|DELETE]]
- [[#Modelos y Controladores.]]
- [[#Vistas.]]
	- - [[#Mostrar Vistas|Mostrar Vistas]]
	- [[#Vistas con parámetros.|Vistas con parámetros.]]

# Inicialización de un proyecto en Laravel.

Para comenzar a usar Laravel, hay tres requisitos a cumplir.

- Tener Xampp y configurar el archivo `php.ini` quitando el comentario de la linea **zip.**
- Instalar composer
- Ejecutar en la ruta que deseamos el siguiente comando

```powershell
composer create-project laravel/laravel example-app
```

# Tipos de peticiones.

## GET.

Peticiones que se hacen a través de la url.

## POST.

De este tipo contamos con 3 tipos de peticiones.

### POST

Esta es usada usualmente para nuevos registros, mandar información a través de formularios y no queremos que esa información sea visible.

### PUT Y PATCH

Son un post para actualizar registros

### DELETE

Es una petición post que se encarga de eliminar registros.

# Sintaxis.

## GET

La sintaxis para una ruta normal con el método get (por lo tanto, veremos su contenido), sería de esta manera:

```php
Route::get('/posts', function() {
		return "Vista de posteos";
});
```

Si usaremos parámetros por la URL, sería de esta manera:

```php
Route::get('/posts/{post}', function($post) {
		return "Vista con parámetro de: {$post}";
});
```

Si vamos a recibir parámetros opcionales, sería de esta manera:

```php
Route::get('/posts/{post}/{other?}', function($post, $other=null) {
		if($other){
				return "Vista con parámetro de: {$post} con valor: {$other}";		
		}
		
		return "Vista con parámetro de: {$post} sin valor";
});
```

Es importante tener en cuenta el orden de las rutas. Laravel toma en cuenta las rutas de arriba hacia abajo (en el codigo)

# Modelos y Controladores.

Para crear controladores, debemos ejecutar el comando `php artisan make:archivo` . Un ejemplo:

```powershell
php artisan make:<tipo_de_archivo_aqui> HomeType
```

Por ejemplo, si se busca hacer un controlador:

```powershell
php artisan make:controller HomeController
```

Importante tener en cuenta el metodo __invoke, que funciona como index

# Vistas.

## Mostrar Vistas

Para mostrar vistas en PHP Laravel, debemos ir al controlador y usar la línea `return view(”vista”)`.

```php
public function controller() {
		return view('dir.view')
}
```

## Vistas con parámetros.

```php
public function home($param) {
		return view('home.index', compact($param))
}
```

Para mostrar estos parámetros, recordemos que en el archivo web debemos pasar los parámetros por la url:

```php
Route::get('usuarios/{user?}', [Controller::class, 'home']);
```

Y posteriormente mostrarlo en la vista. Por ejemplo: `Vista.blade.php`

```php
<h1>{{$param}}</h1
```
