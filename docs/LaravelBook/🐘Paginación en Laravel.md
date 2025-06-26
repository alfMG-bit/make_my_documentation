#DataBases #Eloquent #Laravel 

# ¿Qué es la Paginación?

La paginación consiste en dividir por secciones aquella información recuperada de una tabla de una base de datos. La paginación es muy útil cuando se traen demasiados registros (por ejemplo, tener una tabla con 1000 registros). Si se cargarán 1000 registros de golpe, la página web tardaría mucho en cargarlos, en cambio, si se dividen estos registros en intervalos de 10 en 10, las carga será muchísimo más rapida.

# Paginación en código.

Para realizar la paginación en Laravel es sumamente sencillo, en lugar de usar solamente el método `::all()` o `::get()`, se usa también el método `->paginate()`.

```php
$model = Model::all()->paginate();
```

Por defecto solo muestra 15 registros del total, pero si se busca variar este valor, se le pasa por parámetro:

```php
$model = Model::all()->paginate(10) // Mostrara de 10 en 10
```

En el HTML, para mostrar los botones de paginación se agrega al `bottom` de la página lo siguiente:

```html
@foreach(...)
...
@endforeach
{{$objects->links()}}
```

`$object` en este caso es reemplazado por la entidad que se este devolviendo según el modelo, por ejemplo, si el modelo se llamará `user` sería:

```html
@foreach($users as $user)
...
@endforeach
{{ $users->links() }}
```

### Para mas estilos ir a [[🐘AppServiceProvider]]
