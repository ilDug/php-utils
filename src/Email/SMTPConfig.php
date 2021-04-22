<?php

namespace ilDug\Email;

class SMTPConfig
{
    public $host;
    public $port;
    public $user;
    public $password;
    public $sender_address;
    public $sender_name;

    function __construct($host, $port, $user, $password, $sender_address, $sender_name)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->sender_address = $sender_address;
        $this->sender_name = $sender_name;
    }
}
