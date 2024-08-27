<?php

namespace Hubrix\Providers;

class MailServiceProvider
{
    public function register()
    {
        add_action('phpmailer_init', function($phpmailer) {
            $phpmailer->isSMTP();
            $phpmailer->Host = config('host','mail') ?? 'smtp.example.com';
            $phpmailer->SMTPAuth = config('smtp_auth','mail') ?? true;
            $phpmailer->Username = config('username','mail') ?? 'test@inbox.mailtrap.io';
            $phpmailer->Password = config('password','mail') ?? 'password123changeme';
            $phpmailer->SMTPSecure = config('encryption','mail') ?? 'tls';
            $phpmailer->Port = config('port','mail') ?? 587;
            $phpmailer->From = config('from.address','mail') ?? 'no-reply@inbox.maltrip.io';
            $phpmailer->FromName = config('from.name','mail') ?? 'My Plugin Name';
        });
    }
}