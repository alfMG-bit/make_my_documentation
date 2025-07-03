#laravel-blade #mails #Laravel 

# Uso

Cuando se envían [[🐘Envio de Correos|correos]] por email, estos correos vienen sin un estilo predilecto. Para ello se puede usar Markdown para decorar el estilo de estos correos.

# Plantilla de Laravel.

Laravel tiene plantillas por defecto para correos, cada plantilla distintos usos, como recuperación de contraseñas, notificaciones importantes, etc. Para empezar a utilizar MARKDOWN en los correos, se debe dirigir a el archivo ``mailable`` que en este caso (como ejemplo) es ``ArtistCreatedMail``:

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
            view: 'mails.artist-created',
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

En ``content`` en lugar de seleccionar la propiedad ``view``, esta se cambiará por ``markdown``:

```php
public function content(): Content
{
	return new Content(
		markdown: 'mails.artist-created',
	);
}
```

Ahora en la vista ``blade`` se debe borrar las cabeceras, el pie y las etiquetas de cuerpo HTML de la vista. Entonces el documento de la vista quedará de la siguiente manera:

```html
    <h1>Email de Confirmación</h1>
    <p>Este email es para tí</p>
```

Posteriormente, se mandará a llamar un componente nombrado: ``<x-mail::message>``. Dentro de este componente, se colocará el mensaje que llevara el correo electrónico.

```html
<x-mail::message>
	<h1>Email de Confirmación</h1>
	<p>Este email es para tí</p>
</x-mail::message>
```

En lugar de usar sintaxis ``html`` se puede utilizar sintaxis de ``markdown``. Del mismo modo, hay varios componentes para correos electrónicos:

```markdown
<x-mail::message>
# Email de Confirmación
<x-mail::panel>
este es un mensaje
</x-mail::panel>
</x-mail::message>
```

En los correos es posible agregar todo tipo de contenido que se deseé, inclusive hipervínculos. Ya sea por etiquetas HTML o por elementos MD que ofrece Laravel, como los botones:

```markdown
<x-mail::message>
# Email de Confirmación
<x-mail::panel>
este es un mensaje
</x-mail::panel>

<a href="{{ route('artists.show', $artist) }}"></a>

</x-mail::message>
```

```markdown
<x-mail::message>
# Email de Confirmación
<x-mail::panel>
este es un mensaje
</x-mail::panel>

<x-mail::button url="{{ route('artists.show', $artist) }}">Mostrar</x-mail::button>

</x-mail::message>
```

**Si en algún momento se requiere pasar contenido PHP a un parámetro de HTML se puede poner como prefijo del mismo ``:``**:

```html
<x-mail::message>
# Email de Confirmación
<x-mail::panel>
este es un mensaje
</x-mail::panel>
<!-- Como aqui -->
<x-mail::button :url="route('artists.show', $artist)">Mostrar</x-mail::button>

</x-mail::message>
```

Los botones pueden recibir varios parámetros, así como otros componentes de ``mail``. 

# Importación de componentes para correos al proyecto Laravel.

Si se desea personalizar a fondo el correo, como por ejemplo, cambiar el logo del correo electrónico, del de Laravel a uno personalizado. Es esencial tener los componentes, por lo tanto, se deben instalar o instanciar en el proyecto con el siguiente comando:

```powershell
php artisan vendor:publish --tag=laravel-mail
```

