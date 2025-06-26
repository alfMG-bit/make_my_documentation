#DataBases #Eloquent #controllers #models #Laravel 

# Caso

Estas relaciones se basan en que ya no se hace solo entre dos tablas, sino más de dos. Para este ejemplo y caso, se usarán las siguientes tablas. Las tablas ``users`` y ``students`` tendrán una relación con la tabla ``phones``:

>[!NOTE] Nota
>Cuando se realizan relaciones polimórficas, es importante que ahora el campo que tenia (por ejemplo) ``user_id`` sea cambiado por el nombre de la tabla en singular, mas el posfijo ``neable``. Además, para reconocer a que tipo de usuario le pertenece un id, ya que muchos, en distintas tablas pueden ocupar el mismo numero de id, se agrega el campo ``-nable_type``

--- start-multi-column: ID_skfz
```column-settings
Number of Columns: 2
Largest Column: standard
```

# Users

| id  | name | email      |
| --- | ---- | ---------- |
| 1   | alan | alan@email |


--- column-break ---

# Students

| id  | name | email      | group |
| --- | ---- | ---------- | ----- |
| 1   | Jose | jose@email | B     |


--- end-multi-column
# Phones

| id  | number     | phoneable_id | phoneable_type     |
| --- | ---------- | ------------ | ------------------ |
| 1   | 222334453  | 1            | App\Models\User    |
| 2   | 1122334455 | 1            | App\Models\Student |
# Codificación

Para empezar, en la migración de `create_phones_table` se debe agregar una instrucción que agrega los campos phoneable:

```php
public function up(): void
{
	Schema::create('phones', function (Blueprint $table) {
		$table->id();
		$table->string("number");
		// Aqui la creacion de los `phoneables`
		$table->morpghs("phoneable");
		$table->timestamps();
	});
}
```

Ahora para generar la relación, no se agrega la llave foránea como se hacia antes, sino que se escribe en los modelos de ``User`` y ``Student`` la propia relación, esto se hace gracias a la clausula ``morphOne()`` que recibe dos parámetros, el primero es el modelo al cual se relaciona, y el segundo es la instrucción ``-nable`` que representa los campos de esta índole, en este caso, la instrucción sería ``phoneable`` que representa ``phoneable_id`` y ``phoneable_type``:

```php
public function phone() {
	return $this->morphOne(Phone::class, 'phoneable');
}
```

**De ``phone`` hacia ``User`` lo que se debe de hacer es lo siguiente**: Al ser una relación polimórfica, ya no se usa el método relacionado a ``users``, sino que ahora se crea un método llamado ``phoneable`` que tiene la siguiente instrucción

```php
public function phoneable () 
{
	return $this->morphTo();
}
```

>[!WARNING] Importante
>No se debe olvidar de agregar en la propiedad ``$fillable`` estos campos, así como cualquier otro campo de asignación masiva.

# Creación de registros

Para crear registros, se puede hacer de la misma manera que una relación de uno a uno común:

```php
Route::get('/test', function() {
	$student = Student::find(1);
	$student->phone()->create([
		"number" => "1122334455",
		// Aqui los campos phoneable_is y type se ahorran
	]);
});
```