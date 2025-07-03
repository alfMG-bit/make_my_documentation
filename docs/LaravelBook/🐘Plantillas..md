---
tags:
  - laravel-blade
  - Laravel
---


Las plantillas en Laravel nos ayudan a definir una estructura solida para nuestro HTML. O sea, ayuda a mantener la estructura que se repite en varios archivos Blade. Un ejemplo de esto (suponiendo que el proyecto lo requiere) es que toda página debe tener un logo, un header, donde ira una navbar y un footer. Teniendo más o menos esta estructúra:

```html
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="" />
    <title>Document</title>
</head>

<body>
    <header>
        <nav></nav>
    </header>
    <footer></footer>
</body>
</html>
```

Esta plantilla se repetirá en gran parte de las vistas del proyecto.

# Plantillas por componentes

En `Components/welcome-layout.blade.php`

```html
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="" />
    <title>Document</title>
</head>

<body>
    <header>
        <x-navbar></x-navbar>
    </header>
    <!-- Todo contenido here -->
    {{ $slot }}
    <footer></footer>
</body>
</html>
```

En `Components/navbar.blade.php` se encuentra el componente `navbar` de la plantilla `welcome-layout.blade.php`

Y en la raíz de `Views` tenemos, por ejemplo, `home.blade.php`

```html
<x-welcome-layout>
		Hola Mundo
</x-welcome-layout>
```

esta es una manera mas moderna de llevar a cabo las plantillas, sin embargo, aún muchos proyecto trabajan con otro tipo de plantillas, que ahora se verán.

# Plantillas por Layouts.

Crearemos dentro de `Views` la carpeta `Layouts` y dentro de esta crearemos nuestra plantilla.

Por ejemplo, crearemos una nueva platilla en: `Layouts/main.blade.php`

```html
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>

<body>
    <header>
        <x-navbar>    
        </x-navbar>    
    </header>
    <br><br><br><br>
    <!-- Todo contenido here -->
    {{-- Esta estructura cambia --}}
    @yield('content')
    <footer></footer>
    <script src="{{ asset('../resources/js/script.js') }}"></script>
</body>
</html>
```

En la hoja raíz (ejemplo) `home` pondremos lo siguiente

```html
@extends('layouts.main')
@section
		Aqui el contenido html
@endsection
```

Es posible también agregar varias `@section` y elementos `@stack`, que son casi lo mismo, pero este ultimo sirve para agregar un contenido variable

```html
@stack('css')
```

En mi hoja raíz `home.blade.php` pondría algo como:

```html
@push('css')
		<style>...</style>
@endpush
```

La diferencia radica en que ``yield`` solamente tiene un contenido, y este no se puede ir sumando (o sea que a un ``yield`` le corresponde un ``section``), se define de forma **única** en la hoja raíz ``home.blade.php``. Mientras que el ``stack`` puede ir teniendo añadiduras gracias a la sentencia ``push``

Eso quiere decir que puedo agregar varias veces contenido css a mi stack ``@stack('css')``.

