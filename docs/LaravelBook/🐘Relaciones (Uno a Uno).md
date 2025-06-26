#DataBases #models #controllers #Eloquent #Laravel 

1. [[#Explicación]]
2. [[#Codificación.]]
	1. [[#Constrained.]]
3. [[#Join Traer la información de un elemento relacionado]]
4. [[#Proceso inverso]]
5. [[#Convenciones]]
6. [[#Creación de un elemento a través de su relación]]

# Explicación

Al igual que en una base de datos MySQL, el ORM de Laravel puede incluso trabajar con llaves foráneas. Las llaves foráneas se pueden llevar en relaciones de tipo: uno a uno, uno a muchos, muchos a muchos.

# Caso

Se tienen dos tablas, una llamada ``users`` y otra llamada ``cards``:
# Users

| id  | name  | email      |
| --- | ----- | ---------- |
| 1   | alan  | alan@alan  |
| 2   | alan2 | alan2@alan |

**Modelo**: ``User``

---
# Cards

| id  | number     | user_id |
| --- | ---------- | ------- |
| 1   | 1235312321 | 1       |
| 2   | 4451231113 | 2       |

**Modelo**: ``Card

---
# Codificación.

Para ello, en la migración se debe agregar lo siguiente... Primeramente se crearán dos modelos que puedan tener relación, una vez creados, para asignar una relación de uno a uno, primeramente se crea el campo que será la llave foránea (en este ejemplo, en ``cards`` se crea el campo de llave foránea ``user_id``). Posteriormente, se agrega una clausula que estipula lo siguiente:

>[!NOTE] Nota
>Si no existe un registro en la primer tabla (``users``) que tenga asignado el id que se busca guardar en ``cards``, entonces se tomará como un error

Esto quiere decir que si en ``users`` yo tengo un id único ``2`` y ``4``, si en ``cards`` busco guardar un id inexistente, como ``3``, entonces me arrojará un error.

```php
public function up(): void
{
	Schema::create('cards', function (Blueprint $table) {
		$table->id();
		
		// ... Varios campos demas aquí
		$table->unsignedBigInteger("user_id");
		$table->foreign()
				->references("id")
				->on("users")
				->onDelete("cascade")
				->onUpdate("cascade");
		// FOREIGN KEY ("id") REFERENCES ("users") ON DELETE CASCADE
		// ON UPDATE CASCADE
		$table->timestamps();
	})
}
```

## Constrained.

Si se busca ahorrar un par de líneas de código, se pueden usar las convenciones y una instrucción que específica que se creará una llave foránea. Para ello se usa ``$table->foreignId('model_id')``. En este caso, ``model`` se reemplazaría por el singular del nombre de una tabla (modelo), posteriormente, se pone un guion bajo y la palabra ``id``. Esto porque de ahí se toma el nombre de la tabla y el campo id de la tabla a la que se hace referencia. Pero sin olvidar algo sumamente importante, agregar la clausula ``constrained()`` que deja en claro a que tabla se hará referencia en base a la convención del nombre utilizado

>[!DANGER] Importante
>No olvidar ``constrained()``

```php
public function up(): void
{
	Schema::create('cards', function (Blueprint $table) {
		$table->id();
		
		// ... Varios campos demas aquí
		$table->foreignId("user_id")
				->constrained() // references->("id")->on("users")
				->onDelete("cascade")
				->onUpdate("cascade");
		$table->timestamps();
	})
}
```

# Join. Traer la información de un elemento relacionado

Si se busca traer un elemento en base a la relación que tiene con otro en otra tabla, en el modelo se debe agregar una función, esta función (por convención y conveniencia) debe tener el nombre de la tabla a la cual se le hará el cruce de información, y va de la siguiente manera. En el modelo ``User``:

**Dentro del modelo ``User``:**

```php
public function card()
{
	return $this->hasOne(Card::class);
}
```

El retorno hace primeramente referencia al modelo ``User`` con ``$this``, posteriormente, como es una relación de uno a uno, se usa el método ``hasOne`` y dentro de este, se hace referencia a la otra tabla/modelo, con la que ``User`` tiene la relación, en este caso es ``Card``.

Para retornar la información del elemento de la segunda tabla relacionado con el ``id`` de la primer tabla, se usa el método en donde se encuentre al registro de la primer tabla:

```php
Route::get('/test', function () {
	$user = User::find(1);
	return $user->card;
})
```

El resultado será el elemento de la segunda tabla relacionado con el ``id`` numero ``1``.

Otra manera de hacer esto es cargar directamente la relación en el método ``find()``

```php
Route::get('/test', function () {
	$user = User::find(1)
			->with('card');
	return $user;
})
```

# Proceso inverso

Para hallar una tabla en base a un registro de llave foránea, se debe crear un método en el modelo con el nombre del modelo al cual se busca encontrar. Después, dentro de esta función, se pone el método ``belongsTo()``

**Dentro del modelo ``Card``:**

```php
public function user()
{
	return $this->belongsTo(User::class);
}
```

# Convenciones

Al momento de crear las llaves foráneas en la segunda tabla, en este caso ``cards`` (o el modelo ``Card``) es importante seguir las convenciones. Cuando se crea la llave foránea en el modelo ``Card``, se debe colocar el nombre de la tabla de la cual viene esa llave foránea, seguido de un guion bajo, se coloca la palabra ``id`` de esta manera:

```php
$table->foreignId("user-id")->constrained()->onDelete("cascade")->onUpdate("cascade");
```

Y en el modelo ``User`` se haría referencia en el método de la siguiente manera:

```php
public function card()
{
	return $this->hasOne(Card::class)
}
```

En caso de que en la definición del ``foreign Key`` no se hubiese seguido las convenciones, se tendría que pasar como parámetro el nombre de la llave foránea y como tercer parámetro, el nombre de la llave en la tabla a la que pertenece:

```php
public function card()
{
	return $this->hasOne(Card::class, "user_id", "id");
}
```


# Creación de un elemento a través de su relación

En esta caso, un usuario puede tener una tarjeta, cuando un usuario ya es creado y aun no se le ha asignado una tarjeta, esto se puede hacer encontrando al propio usuario y usando el método ``create``. Si se creara la ``card`` de forma convencional, sería así:

```php
Route::get('/test', function () {
	Card::create([
		'number' => "213132142",
		'user_id' => 1
	]);
});
```

Pero si usamos el método de creación a través de la relación, sería de la siguiente manera:

```php
Route::get('/test', function () {
	$user = User::find(1);
	$user->card()->create([
		'number' => "1112321311"
	]);
});
```