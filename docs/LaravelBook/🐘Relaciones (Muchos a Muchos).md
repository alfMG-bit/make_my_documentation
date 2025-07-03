#DataBases #controllers #Eloquent #models #Laravel 

# Explicación

Las relaciones muchos a muchos contienen tablas ``pivot``, que pueden denominarse como tablas que permiten la interacción entre los múltiples registros de dos tablas que tienen una relación de muchos a muchos.

--- start-multi-column: ID_q987
```column-settings
Number of Columns: 3
Largest Column: standard
```

# Posts

| id  | title    | content     |
| --- | -------- | ----------- |
| 1   | titulo 1 | contenido 1 |
| 2   | titulo 2 | contenido 2 |
| 3   | titulo 3 | contenido 3 |


--- column-break ---

# Post_tag (Tabla Pivot)

| post_id | tag_id |
| ------- | ------ |
| 1       | 1      |
| 1       | 2      |
| 2       | 1      |
| 2       | 3      |



--- column-break ---

# Tags

| id  | name          |
| --- | ------------- |
| 1   | programacion  |
| 2   | base de datos |
| 3   | front-end     |
| 4   | back-end      |


--- end-multi-column

>[!WARNING] Importante
>Para la tabla intermedia es importante seguir un orden alfabético. En este caso la letra *p* es antes que la *t*, entonces el nombre no puede ser ``tag_post`` sino que debe ser ``post_tag`` 

# Programación

Primeramente empezaremos por hacer la tabla intermedia, en este caso es ``post_tag``. Esta tabla intermedia no lleva modelos.

>[!DANGER] Importante
>Cada que se creen tablas intermedias, es importante tener ya creadas las dos tablas que se van a unir, en este caso, antes de crear a la tabla ``post_tag`` se deben crear las tablas ``posts`` y ``tags``


```powershell
php artisan make:migration create_post_tag_table
```

Dentro de la migración crearemos las llaves foráneas

```php
public function up(): void
{
	Schema::create('post_tag', function (Blueprint $table) {
		$table->id();
		$table->foreignId('post_id')
				->constrained()
				->onDelete("cascade")
				->onUpdate("cascade");
		$table->foreignId('tag_id')
				->constrained()
				->onDelete("cascade")
				->onUpdate("cascade");
		$table->timestamps();
	});
}
```

## Métodos de captura en los Modelos.

Para capturar la información, igual que las otras relaciones se deben hacer métodos para ello.

En el modelo ``Post``:

```php
public function tags()
{
	return $this->belongsToMany(Tag::class);
}
```

>[!NOTE] Nota
>Si por alguna razón, decides poner otro nombre a la tabla pivote, como Eloquent trabaja por convenciones de escritura, entonces se tendrás que definir manualmente, cual es la tabla pivote. por ejemplo, en lugar de usar la convención (para este ejemplo) *post_tag* se uso *tabla_pivote*
>```php
>public function tags()
>{
>	return $this->belongsToMany(Tag::class, "tabla_pivote");
>}
>```

En el modelo ``Tag``:

```php
public function posts()
{
	return $this->belongsToMany(Post::class);
}
```

# Creación de elementos relacionados.

Una vez ya hechas las instancias necesarias en nuestros modelos, se pueden crear registros relacionado a partir de un registro existente en la primera tabla, en este caso, si ya existe un ``Post`` y una serie de ``Tag``'s, por ejemplo, para asignar la relación se debe hacer lo siguiente

```php
Route::get('/test', function () {
	$post = Post::find(1);
	$post->tags()->attach([1,3]);// Aqui la seríe de registros que deseamos enlazar por medio del id
});
```

# Eliminar una relación

En caso de que ya no se desee tener una relación, por ejemplo, que del anterior caso se desee quitar el 3, entonces se hace lo siguiente: 

```php
Route::get('/test', function () {
	$post = Post::find(1);
	$post->tags()->detach([3]);
});
```

# Sincronización de las relaciones.

En caso de que, por ejemplo, ahora se busque poner todas las tags a un post (el de id 1, por ejemplo), si se usa ``attach()`` como método de relación, va a duplicar algún campo que no hayamos eliminado. Para evitar esto, se usa el método ``sync()``, que antes de agregar alguna relación, verifica que no exista en los registros, si ya existe, **omitirá agregar dicha relación**.

```php
Route::get('/test', function () {
	$post = Post::find(1);
	$post->tags()->sync([1,2,3])
});
```

No solamente agrega, sino que elimina, es una sincronización en sentido literal. Por ejemplo, si se quita el numero de id 2 de la sincronización, lo borrara en la base de datos:

```php
Route::get('/test', function () {
	$post = Post::find(1);
	$post->tags()->sync([1,3])
});
```