<?php

namespace App\Models\Serasa;

use Webklex\IMAP\Facades\Client;

class Gerencie
{
    public static function connect()
    {
        $client = Client::account('default');
        return $client->connect();
    }
}
