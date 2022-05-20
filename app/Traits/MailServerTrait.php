<?php

namespace App\Traits;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;

trait MailServerTrait
{

    public function setMailConfig()
    {
        $driver = getParameter('MAIL_DRIVER');
        $host = getParameter('MAIL_HOST');
        $port = getParameter('MAIL_PORT');
        $username = getParameter('MAIL_USERNAME');
        $password = getParameter('MAIL_PASSWORD');
        $encryption = getParameter('MAIL_ENCRYPTION');
        $fromAddress = getParameter('MAIL_FROM_ADDRESS');
        $fromName = getParameter('MAIL_FROM_NAME');

        if ($driver && $host && $port && $username && $password && $encryption && $fromAddress && $fromName) {
            Config::set('mail.driver', $driver);
            Config::set('mail.host', $host);
            Config::set('mail.port', $port);
            Config::set('mail.username', $username);
            Config::set('mail.password', $password);
            Config::set('mail.encryption', $encryption);
            Config::set('mail.from.name', $fromName);
            Config::set('mail.from.address', $fromAddress);
            (new MailServiceProvider(app()))->register();
        }

    }

}