#controllers #DataBases #models #mails #Laravel 

Link del [tutorial](https://www.youtube.com/watch?v=iFsLHr6Bf-8&list=PLZ2ovOgdI-kVtF2yQ2kiZetWWTmOQoUSG&index=25)
# Servicios de prueba 

Consiste en una plataforma de prueba que permite enviar y visualizar correos de prueba. Para testear el servicio de envió de correos veine muy bien, debido a que enviar correos tiene costo, hay varios servicios de paga que realmente permiten enviar correos reales.

El servicio de prueba es https://mailtrap.io/es/

## Configuración en MailTrap.

Si ya se ha creado una cuenta, se debe ir a ``Email Testing`` e ``inboxes``. Una vez ahí, dar click en ``Demo inbox``.

# Configuración de Laravel.

Para la configuración en el proyecto de Laravel, se debe ir a las variables de entorno (``.env``) e ir a la sección de ``MAIL`` y reemplazar estos valores:

```php
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=fa3bffeb527c95
MAIL_PASSWORD=****84cc
```

Posteriormente se modificarán los valore de:

```php
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Estos valores son los identificadores del email de la aplicación Laravel. Cuando se mande un email desde la aplicación, el correo y el nombre del remitente serán los estipulados aquí.

# Programación

Primeramente, en nuestro proyecto Laravel se debe generar un archivo ``Mailable`` que se genera de la siguiente forma:

```powershell
php artisan make:mail <Name>
```

En este caso, el nombre puede seguir esta convención (aunque en este caso, este tipo de archivos no son tan rigurosos en ese sentido): ``ModelCreatedMail``.

Una vez creado, habrá una carpeta nueva en ``app/Mail``. Esta carpeta ``Mail`` tendrá el archivo creado a través del comando en la shell.

```php
<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArtistCreatedMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Artist Created Mail',
        );
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
```

Se debe enfocar en la función ``content()`` pues dentro de esta función irá una vista. Esta vista representara el contenido del mail, así que se tendrá que crear una vista.

# En el controlador.

Según donde se vaya a usar el envió de Mails, se debe usar el siguiente ``Facade``:

```php
Mail::to('example@example.com')->send(new ModelEditedMail);
```

![[EjemploMailLaravel_20250418212932.png]]

# Modificación de datos del email.

Si se quieren cambiar datos, como el nombre del Email, el remitente (from) y aspectos más, se debe dirigir al método ``envelope()``.

```php
public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Artist Created Mail',
        );
    }
```

Esta función puede recibir algunos parámetros, como ``subject`` que define el tema a tratar en el correo, ``from`` que define quien manda el correo.

Si se busca definir un nuevo ``from`` como propiedad, se debe hacer instanciando una clase llamada ``Address``. Esta clase viene desde ``Illuminate\Mail\Mailables\Address``

```php
public function envelope() : Envelope
{
	return new Envelope(
		subject: "New Artist Submited",
		from: new Address('','')
	);
}
```

Address recibe dos parámetros o propiedades, el primero es la dirección de correo que se quiere que se muestre en el correo electrónico, y la segunda, es el nombre del remitente.

```php
public function envelope() : Envelope
{
	return new Envelope(
		subject: "New Artist Submited",
		from: new Address('admin@email.com','adminLaravel')
	);
}
```

# Pasar objetos como parámetro al constructor del Mail.

Lo único que se debe de hacer es guardar el objeto creado (en este ejemplo un ``Artist``) en una variable y posteriormente pasarlo a la clase ``ModelMail($model)``, para este ejemplo podría ser ``ArtistCreatedMail($artist)``.

```php
// Dentro del controlador store
$artist = Artist::create($request->all());
Mail::to($artist->email)->send(new ArtistCreatedMail($artist));
```

Y en la vista del MAIL ya se podrá acceder a la variable en cuestión.