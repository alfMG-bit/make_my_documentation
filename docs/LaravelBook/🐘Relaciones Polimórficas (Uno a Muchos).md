#controllers #Eloquent #models #DataBases #Laravel 

# ¿Qué son?

Al igual que las relaciones polimórficas de uno a uno, las relaciones polimórficas de uno a varios relacione un elemento con varios de otra tabla. Sin embargo, hay casos donde estas entidades (tablas), utilizan otra con los mismos campos:

# Ejemplo

Existen las tablas posts y comentarios. Un post puede tener múltiples comentarios. Pero suponiendo que se agrega una entidad llamada ``cursos``, esos cursos también podrían tener comentarios. Entonces aquí, la entidad ``comments`` ya no solo tiene una relación de uno a muchos con los ``posts``, sino que también tiene esa misma relación con los ``courses``.

--- start-multi-column: ID_92cc
```column-settings
Number of Columns: 2
Largest Column: standard
```

## Posts

| id  | title    | content     |
| --- | -------- | ----------- |
| 1   | Titulo 1 | Contenido 1 |


--- column-break ---

## Comments

| id  | content     | commentable_id | commentable_type |
| --- | ----------- | -------------- | ---------------- |
| 1   | lorem ipsum |                |                  |


--- end-multi-column

<center style="border: 1px solid gray; padding: 10px 0">
	<h2>Courses</h2>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>Laravel</td>
			</tr>
		</tbody>
	</table>
</center>


# Proceso

## Comment y comments

Como ya no voy a trabajar con una relación uno a muchos "*común*" entonces se debe borrar la referencia de la ``foreignId()`` de la migración ``create_comments_table``:

```php
<?php
//...
public function up(): void
{
	Schema::create("comments", function (Blueprint $table) {
		$table->id();
		$table->string("content");
		//$table->foreignId("post_id")
		//	->constrained()
		//	->onDelete("cascade");
		// ----------------
		// Se reemplaza por
		
		$table->morphs("commentable");
		$table->timestamps();
	});
}
```

La segunda modificación que deben de hacer es en el modelo ``Comment``, en este se debe de reasignar el ``fillable`` de ``post_id`` por ``commentable_id`` y ``commentable_type``:

```php
<?php
//...

class Comment extends Model
{
	$fillable = [
		"content",
		"post_id" //cambiamos este
	];
}
```

**Se debe de reemplazar por este**:

```php
<?php

class Comment extends Model
{
	$fillable = [
		"content",
		"commentable_id",
		"commentable_type"
	];
}
```

Además, en el modelo ``Comment``, se debe también crear la función encargada de relacionar tanto con el ``Post`` como con el ``Course``. Esta función tiene el nombre del modelo fusionado con el sufijo ``able``:

```php
<?php
//...

public function commentable()
{
	return $this->morphTo();
}
```

## Modelo Post

En el modelo posts se ha venido trabajando con el método ``hasMany()``, para relaciones de uno a muchos. En este caso, ese método se verá reemplazado por el método ``morphMany()``:

```php
<?php

class Post extends Model
{
	//...
	public function comments()
	{
		return $this->morphMany(Comment::class, 'commentable');
	}
}
```

# Acceder a la relación inversa.

Al igual que otros tipos de relaciones, se puede acceder a las entidades de la relación por medio de la misma. En las rutas o el controlador se puede hacer lo siguiente

```php
Route::get("/", function() {
	$post = Post::find(1);
	return $post->comments;
})
```

**Pero si se desea acceder de forma inversa, o sea, a partir de un comentario ligado a un post, sería de la siguiente manera**:

```php
<?php
Route::get("/", function() {
	$comment = Comment::find(1);
	return $comment->commentable;
})
```