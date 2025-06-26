#DataBases #models #Laravel 

# ¿Qué son las validaciones?

Cuando se envía información a través de un formulario, es importante que muchos se estos campos realmente sean llenados, sino se llenan, Laravel mandará una ventana de error. Para evitar esto, existen las validaciones en Laravel.

# Programación.

En este ejemplo se usará el modelo ``Artist``. Para empezar, se debe ir al controlador de este modelo, en este caso ``ArtistController``. Aquí se hará referencia a la variable ``$request`` que tiene por función ``validate()`` del método ``store()``.

## Validate.

``Validate`` recibirá un arreglo, en este arreglo se definirá si uno o varios de los campos serán requeridos (``required``) o no.

```php
public function store(Request $request)
{
	$request->validate([
		// Aqui los campos que sean necesarios
		'name' => 'required'
	]);
	Artist::create($request->all());
	return redirect()->route('artists.index');
}
```

Una vez hecho esto, Laravel no mandará por defecto ningún error, y simplemente volverá a cargar la página. Esto quiere decir que ha funcionado, pero puede ser confuso para el usuario final ver que simplemente se recarga.

# Mensajes de error para validaciones fallidas.

Laravel además de recargar la página anterior cuando una validación no es cumplida, guarda este tipo de errores en una variable llamada ``errors``. En esta variable coloca todos los errores de validación que han ocurrido.

Para poder mostrar mensajes de errores al usuario, se debe ir a la vista y colocar la siguiente directiva de blade. En este caso, se debe ir a la vista del formulario de creación de artistas (Para este ejemplo).

```php
@if($errors->any())
	<h2>Error:</h2>
	<ul>
		@foreach($errors as $error)
			<li>{{$error}}</li>
		@endforeach
	</ul>
@endif
```

Otra manera de mostrar los errores en las validaciones es usando una directiva de Laravel llamada ``@error()`` que recibe como parámetro el nombre del campo al cuál se le mostrara el error en caso de que no se valide

```html
<input type="email" name="email"/>
@error('email')
	<p>El campo email no ha sido llenado adecuadamente</p>
@enderror
```

O por otro lado, dejar por defecto el mensaje que tiene Laravel.

```html
<input type="email" name="email"/>
@error('email')
	<p>{{ $message }}</p>
@enderror
```

## Método ``old()``.

Listo! ha quedado solucionado y ahora el usuario podrá ver que campos no ha llenado y son requeridos. Sin embargo, cuando se hacen las validaciones, imaginando que tenemos 20 registros y al usuario solo se le ha olvidado llenar uno, perder todos los campos ya llenados puede ser molesto. Para ello, Laravel nos deja recuperar estos campos ya llenados antes de que se hagan las validaciones y muestre el error.

Para ello, en el formulario, en cada campo se debe hacer lo siguiente:

```html
<input type="text" name="name" value="{{ old('name') }}"/>
```

El método ``old()`` verifica si hubo validaciones erróneas y recupera el valor que había antes en ese campo, en este caso, la función recibe por parámetro el nombre del campo del cual se busca recuperar su antiguo valor.

# Poner múltiples tipos de validaciones.

Si se quiere poner mas de un tipo de validación, en el método ``validate()`` que ofrece la consulta ``Request`` se pueden insertar varias de dos formas:

```php
public function store(Request $request)
{
	$request->validate([
		'name' => "required",
		'email' => "required|email"
	]);
	Artist::create($request->all());
	return redirect()->route('artists.index');
}
```

O por un ``array``:

```php
public function store(Request $request)
{
	$request->validate([
		'name' => "required",
		'email' => ["required", "email"]
	]);
	Artist::create($request->all());
	return redirect()->route('artists.index');
}
```

## Validaciones para elementos únicos.

Para elementos únicos se utiliza la opción `unique:table`, en donde dice ``table`` se coloca el nombre de la tabla a la cual se le esta haciendo referencia. Esta validación lo que hará es decirle al usuario, si es que ya existe un elemento con ese valor en algún registro, que ya existe en la base de datos. Esto, obvio, si la base de datos tiene este campo como ``unique``.

```php
public function store(Request $request)
{
	$request->validate([
		'name' => "required",
		'email' => "required|email|unique:artists"
	]);
	Artist::create($request->all());
	return redirect()->route('artists.index');
}
```

# Validar en método ``update()``.

Si se quiere validar en una función de actualización, todo es igual que en un método ``store()``, exceptuando los campos unicos.

Si se quiere verificar que un campo sea único, se le deben pasar mas parámetros a la validación ``unique``, además de la tabla.

Una validación ``unique`` cuenta con los siguientes parámetros:

```shell
unique:table,column,except,id
```

El parámetro que importa es el tercero (3), que se denomina ``except``, este parámetro lo que hará será buscar con un identificador único (por excelencia, el ID de los registros) y omitirá aquel que coincida con ese parámetro.

>[!NOTE] Importante
>Si esto último no se hace, dará un error por defecto y es aquel que indica que dicho valor de slug (en este ejemplo) ya ha sido tomado. Entonces se hace una excepción con aquel campo que se esta editando y que antes de la edición ya tenía dicho valor.

En el método ``update`` el controlador contendría lo siguiente:

```php
public function update(Request $request, Artist $artist)
{
	$request->validate([
		'name' => "required",
		'email' => "required|email|unique:artists,slug,{$artist->id}"
	]);
	$artist->update($request->all());
	return redirect()->route('artists.show', $artist);
}
```

En la vista de blade, cada que una validación no sea cumplida, obtendría nuevamente los valores que recupera de la base de datos, sin embargo, al igual que se planteo antes, sería molesto tener que escribir nuevamente todo, más aún si son varios campos. Para ello, el método ``old()``, puede recibir un segundo parámetro que refiere a un valor por defecto en el caso de los campos que no hayan tenido un error de validación:

```html
<input type="text" name="name" value="{{ old('name', $artist->name) }}"/>
```

Para mas validaciones, revisar la documentación de **Laravel**.