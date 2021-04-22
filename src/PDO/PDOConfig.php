<?php

namespace ilDug\PDO;

class PDOConfig
{
    public $database;
    public $host;
    public $user;
    public $password;

    function __construct($host, $database, $user, $password)
    {
        $this->database = $database;
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
}
