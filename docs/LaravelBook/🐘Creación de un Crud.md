#DataBases #Laravel 

1. [[#Lectura de datos]]
	1. [[#Lectura de muchos datos]]
	2. [[#Lectura individual.]]
2. [[#Creación (Insert into).]]
	1. [[#¿Cómo capturar la información mandada desde un formulario `post`?]]
		1. [[#Por Helper `Request`.]]
		2. [[#Por inyección de un objeto.]]
	2. [[#Ingreso de datos a la base de datos]]
3. [[#Edición de campos (UPDATE).]]
	1. [[#Rutas para actualizar]]
4. [[#Eliminación de elementos (DELETE).]]
5. [[#Convenciones.]]

# Lectura de datos

## Lectura de muchos datos

Para leer todo un diccionario de datos, primeramente se debe traer desde la [[🐘Conexión a una base de datos|base de datos]]:

En el controlador que se este manipulando la información se hará una función `show()` para mostrarla (el nombre `show` es por convención, aunque **no es forzoso**).

```php
public function show() 
{
	$elements = ElementModel::all();
	return view('view', compact('elements'));
}
```

Una vez se hayan capturado desde el back-end los datos del modelo `Element` (o tabla `elements`) se capturan con ``compact`` y se muestran en la vista seleccionada:

```html
@foreach ($elements as $element)
	{{ $element->fstProperty }}
	{{ $element->sndProperty }}
@endforeach
```

## Lectura individual.

Si se busca solo capturar uno solo de los elementos de la tabla, en primera instancia se puede usar el método `find()` del modelo `Element.php`.

```php
Route::get('explore/{element?}', function ($element) {
	$toReturn = Element::find($element);
	return "Este elemento tiene por prop 1: " . $toReturn->propOne;
});
```

# Creación (Insert into).

Para ello se utilizará ahora el método [[🐘Introducción#POST|post]], este método permitirá ingresar parámetros sin insertarlos por la URL.

Dentro del archivo `routes/web.php`:

```php
Route::get('/form', [Controller::class, 'create']);
```

En el formulario HTML se debe configurar la ruta a mandar el formulario, también el método (en este caso debe ser post) y un token (esto con el fin de evitar suplantación y creación de formularios no hechos por el desarrollador).

```html
<form action="/store" method="post">
	@csrf
	...
</form>
```

>[!WARNING] Importante
>`@csrf` es la instrucción que incluye un token, el cual se coloca en un input oculto, una vez que la ruta lo descifre, dará por valido que el formulario creado por el desarrollador es el autentico.

## ¿Cómo capturar la información mandada desde un formulario `post`?

Para comenzar, es importante entender que la ruta POST debe ser independiente a la ruta del formulario desde el cual se mandan los campos, esto se traduce en que se debe crear otra ruta independiente para recibir los datos del formulario que (en este ejemplo) se encuentra en `/form`;

El controlador para el método POST será (por ejemplo):

```php
Route::post('/store', [Controller:class, 'store']);
```

### Por Helper `Request`.

La primera es que dentro del controlador o la función de la ruta se coloque un **helper** como lo es `request()`:

```php
public function store()
{
	$gotten = request()->all(); // Obtiene todos los campos
}
```

O para capturar campos específicos:

```php
public function store()
{
	$gotten = request()->field;
}
```

### Por inyección de un objeto.

La otra forma es inyectar un objeto que se encargue de la recuperación de estos campos:

```php
public function store(Request $request)
{
	$gotten = $request->all();
	// O un campo en específico
	$oneGotten = $request->field;
}
```

## Ingreso de datos a la base de datos

Una vez que se a comprendido como capturar los datos, estos datos simplemente se enviarán por el objeto del modelo. En el controlador se pondrá lo siguiente:

```php
public function store(Request $request)
{
	$model = new Model;
	$model->f1 = $request->f1;
	$model->f2 = $request->f2;
	$model->save();
	return redirect('/objects');
}
```

# Edición de campos (UPDATE).

Lo primero que se debe de hacer es capturar el campo específico a actualizar, en este caso, lo se hará es capturar el id por medio de la URL. Una buena ruta para edición de registros podría ser:

```php
Route::get('objects/{specific}/edit', [Controller::class, 'edit']);
```

En el controlador `edit` se pondrá lo siguiente:

```php
public function edit($param) {
	$object = Model::find($param);
	return view('view', compact('object'));
}
```

En la vista HTML se coloca el valor devuelto por el controlador dentro de los campos a editar:

```html
...
<input type="text" value="{{ $object->text }}"/>
```

## Rutas para actualizar

Ya sea que se use [[🐘Introducción#PUT Y PATCH|put]] o [[🐘Introducción#PUT Y PATCH|patch]] como rutas de actualización, se deben crear en el archivo `web.php`, pues es ahí, al igual que el método `post`, donde realmente se procesará la información:

```php
Route::put('objects/{object}', [Controller::class, 'update'])
```

Su controlador:

```php
public function update(Request $request, $object)
{
	$fields = $request->all();
	$object = Model::find($object);
	
	$object->name = $fields->name;
	...
	$object->save();
	return redirect('objects/' . $object)
}
```

>[!WARNING] Importante
>En el HTML se debe definir con la directiva `@method('PUT')` que tipo de método `POST` se esta utilizando

```html
<form action="objects/{{$object->id}}">
	@csrf
	@method('PUT')
	...
</form>
```

# Eliminación de elementos (DELETE).

Para comenzar, las rutas de método `post` que se encarguen de eliminar son rutas de tipo [[🐘Introducción#DELETE|delete]]:

```php
Route::delete('/objects/{object}/del', [Controller::class, 'destroy'])
```

Lo que se debe hacer en el HTML es:

```html
...
<form action="objects/{object}/del" method="post">
	@csrf
	@method('DELETE')
	<input type="submit" value="submit"/>
</form>
```

En el controlador:

```php
public function destroy($object)
{
	$object = Model::find($object);
	$object->delete();
	return redirect('/otra_ruta');
}
```

# Convenciones.

Las sentencias Laravel que interactúan con la base de datos en el archivo `web.php` y en los respectivos controladores, tienen una convención, y esta se ve reflejada en las funciones del controlador:

- `index`: Utiliza métodos como `::get()` o `::all()` para capturar todo lo que hay en la base de datos.
- ``show``: Utiliza métodos como `::find()` o `::where()` para hallar elementos específicos de la base de datos.
- ``create``: Este método es de tipo `GET` y devuelve el formulario por donde se crearan nuevos elementos
- `store`: Este método se utiliza para cuando se guarda un nuevo elemento de algún modelo (`new Model()`). Su método de captura de datos es `POST`
- `edit`: Este método devuelve el formulario que servirá para editar los registros de una base de datos o tabla (método `GET`).
- ``update``: Este método es de tipo `PUT` o `PATCH` y lo que hace es actualizar los registros por métodos de el modelo, como lo son `::find()` o `::where()` para obtener un elemento de la base de datos y posteriormente editar sus campos `->field = "something"`.
- `destroy`: Este método del controlador elimina los registros de la base de datos, puede usar métodos como `::find()` o `::where()`. Su método en HTML es `DELETE`.