#routes #Laravel 

En un controlador, para redireccionar a una nueva ruta se hace de la siguiente manera:

```php
public function update(Model $model, Request $req)
{
	$model->name = $req->name$;
	$model->save();
	
	return redirect('/models/'.$model);
}
```

Sin embargo, una manera mas efectiva de hacer esto, sería a través del uso del nombre de las rutas:

```php
public function update(Model $model, Request $req)
{
	$model->name = $req->name$;
	$model->save();
	
	return redirect()->route('models.show', $model);
}
```