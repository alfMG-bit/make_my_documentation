#DataBases #Eloquent #models #Laravel 

# Contenido

1. [[#¿Qué es?]]
2. [[#Hacer Asignaciones masivas de forma segura y rápida.]]
3. [[#Actualización de registros con Asignación masiva.]]

# ¿Qué es?

Anteriormente, para guardar o actualizar registros se usaba un método sencillo, que es de la siguiente manera:

```php
public function store(Request $request)
{
	$model = new Model();
	$model->name = $request->name;
	$model->lastname = $request->lastname;
	
	$model->save();
	return redirect()->route('objects.index');
}
```

Sin embargo, hay otra forma más eficiente de hacer este proceso, y es usando la asignación masiva.

```php
public function store(Request $request)
{
	Model::create([
            'name' => $request->name,
            'lastname' => $request->lastname
    ]);
   return redirect()->route('objects.index');
}
```

Sin embargo esto aun se puede reducir más, una manera de hacerlo es de la siguiente manera:

```php
Model::create($request->all());
```

A pesar de que esta forma reduce a una sola línea de código todo el proceso de registro, es muy insegura, ya que se podrían hacer inyecciones por medio de un formulario a la tabla de la base de datos.

# Hacer Asignaciones masivas de forma segura y rápida.

Para comenzar, es importante habilitar la asignación masiva en el modelo en cuestión, para este ejemplo se usara el modelo `Artist`. Dentro del modelo `Artist` se debe programar una propiedad de la clase que debe llamarse `$fillable`, es importante que su tipo sea ``protected``

```php
protected $fillable = [
	'name',
	'slug',
	'email',
	'register_date'
];
```

Esta propiedad protege de cualquier inyección de algún campo no verificado en un formulario restringido. Si se intenta acceder, por ejemplo, al id, la tabla hará caso omiso de este campo, pues no esta dentro de la propiedad ``$fillable``.

Una vez hecho esto, entonces ahora sí, se puede usar el método ``create``:

```php
public function store()
{
	Artist::create($request->all());
	return redirect()->route('artists.show');
}
```

# Actualización de registros con Asignación masiva.

Si se busca hacer lo mismo, pero con registros, entonces solamente se debe encontrar por un campo único a algún registro de la tabla, guardar ese registro en una variable (por ejemplo ``$artist``) y posteriormente insertar la consulta con el método ``->all()``.

>[!WARNING] Importante
>No olvidar crear la propiedad ``fillable`` en la clase del modelo y asignarla como ``protected``

```php
public function update(Artist $artist, Request $request)
{
	$artist->update($request->all());
	return redirect()->route('artists.show', $artist);
}
```

# Fillable y Guarded.

Fillable y guarded son dos propiedades que se pueden definir dentro de la clase del modelo, una de ellas define los campos los cuales se busca capturar, y la otra excluye a un grupo de campos que se quiera excluir.

## Fillable.

``protected $fillable`` lo que hace es establecer que campos únicamente se deben tener en cuenta al momento de mandar formularios.

```php
protected $fillable = [
	'name',
	'lastname'
];
```

## Guarded.

``protected $guarded`` establece excluir un grupo de campos específicos.

```php
protected $guarded = [
	// No tomara en cuenta los inputs con estos nombres
	'id',
	'status'
]
```