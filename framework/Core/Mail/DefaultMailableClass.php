<?php
/**
 * How to use the mailable class
 * Wherever you want the mailable class to fire, include the following
 *
 * use YourPlugin\Mail\DefaultMailableClass;
 *
 * $data = ['name' => 'John Doe'];
 * $mailer = $container->make('mailer');
 *
 * $mailer->to('recipient@example.com')->send(new DefaultMailableClass($data));
 */

namespace Hubrix\Core\Mail;

use Illuminate\Mail\Mailable;

class DefaultMailableClass extends Mailable
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.default')
            ->with(['data' => $this->data]);
    }
}