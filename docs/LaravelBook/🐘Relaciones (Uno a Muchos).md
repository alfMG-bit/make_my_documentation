#DataBases #Eloquent #models #controllers #Laravel 

# Caso de ejemplo

Suponiendo que se tienen dos tablas, una llamada ``posts`` y otra llamada ``comments`` se hará una relación de uno a muchos. Por cada registro en la Tabla 1, puede haber varios registros en la Tabla 2.

--- start-multi-column: Tables1  
```column-settings  
number of columns: 2    
```

# Tabla 1: Posts

| id  | title | content |
| --- | ----- | ------- |
| 1   | Post1 | Lorem   |
| 2   | Post2 | ipsum   |
| 3   | Post3 | dalila  |

**Modelo**: ``Post``

--- end-column ---

# Tabla 2: Comments

| id  | content      | post_id |
| --- | ------------ | ------- |
| 1   | Comentario 1 | 1       |
| 2   | Comentario 2 | 1       |

**Modelo**: ``Comment``

--- end-multi-column

# Programación.

## Creación de la migración.

>[!NOTE] Nota
>Para crear un modelo con su respectiva migración lo que se debe hacer es ejecutar el comando ``php artisan make:model Post -m`` para crear el modelo y la migración de un solo comando.

## Definición de los campos y de las llaves foráneas.

Para empezar, en la primer tabla y en la segunda tabla se definirán los campos y en la segunda tabla, se definirá una llave foránea en cascada para eliminación y actualización.

**Tabla 1: posts**

```php
public function up(): void
{
	Schema::create('posts', function (Blueprint $table) {
		$table->id();
		$table->string('title');
		$table->string('content');
		$table->string('picture')->nullable();
		$table->timestamps();
	});
}
```

**Tabla 2: comments**

```php
public function up(): void
{
	Schema::create('comments', function (Blueprint $table) {
		$table->id();
		$table->string('content');
		$table->foreignId('post_id')
				->constrained()
				->onDelete("cascade")
				->onUpdate("cascade");
		$table->timestamps();
	});
}
```

>[!WARNING] Importante
>Es indispensable que siempre se definan los campos ``fillable`` en los modelos creados

## Creación de posts y comments de prueba

Se pueden crear dos tipos de prueba para cada tabla o según se requieran de la siguiente manera en una URL de prueba.

```php
Route::get('/test', function() {

    Post::create([

        'title' => 'titulo',

        'content' => 'contenido',

    ]);

  

    return "Post Created";

});
```

```php
Route::get('/test', function() {

    Comment::create([

        'content' => 'comentario',

        'post_id' => '1',

    ]);

  

    return "Comment Created";

});
```

# Recuperación de la información.

Para recuperar información en una relación de uno a muchos, al igual que en una relacion uno a uno, en el modelo correspondiente, en este caso ``Post`` se debe crear un método. Si cada post tuviera un solo comentario, el método se escribiría en singular, o sea 

```php
public function comment()
{
	return $this->hasOne(Comment::class);
}
```

Pero como un solo ``Post`` puede tener varios comentarios, se escribe en plural (``comments``) y se usa el método ``hasMany()``:

```php
public function comments()
{
	return $this->hasMany(Comment::class);
}
```

## Recuperación inversa.

Al igual que en la relación de muchas a uno, se puede recuperar la información de forma inversa, escribiendo el método (en este caso) en el modelo ``Comment`` en singular del ``post()``:

```php
public function post()
{
	return $this->belongsTo(Post::class);
}
```

# [[🐘Relaciones (Uno a Uno)#Creación de un elemento a través de su relación|Creación por medio de la relación]]

