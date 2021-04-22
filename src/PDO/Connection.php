<?php

namespace ilDug\PDO;

use PDO;

class Connection
{
    const PDO_OPTS  = array(
        // PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );


    public function __construct()
    {
    }

    /**
     * ritorna una connessione del tipo PDO
     * @return PDO
     */
    public static function pdo(PDOConfig $c): PDO
    {
        try {
            $pdo_dsn  = 'mysql:host=' . $c->host . ';dbname=' . $c->database . ';port=3306;charset=utf8mb4';

            $pdo = new  PDO($pdo_dsn, $c->user, $c->password, self::PDO_OPTS);
            return $pdo;
        } catch (\Exception $e) {
            throw new \Exception("Errore iniziale di connessione al server con PDO - database " . $c->database . " --- " . $e->getMessage(), 500);
            die($e);
        }
    }
}
