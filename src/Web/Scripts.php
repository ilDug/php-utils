<?php

namespace ilDug\Web;

class  Scripts
{
    /** 
     * archivio degli scripts nella forma 
     * 
     * $ARCHIVE = array(
     *      KEY => __DIR__ . "/abs/path/to/scripts.html",
     *      ...
     * )
     */
    public static $ARCHIVE = array();


    /** 
     * registra nell'archivio la lista degli scripts disponibili
     * eventualmente da registrare in appConfig
     */
    public static function adopt(string $key, string $path)
    {
        /** controlla che il template esista */
        if (!file_exists($path)) {
            throw new \Exception("Il template dello script non esite", 400);
        }

        self::$ARCHIVE[$key] = $path;
    }


    /** 
     * pubblica la lista degli script nella pagina
     * @param array $scripts la lista delle KEY che individuano gli scripts adottati
     */
    public static function run(array $scripts = [])
    {
        // se non viene passato nessun parametro
        if (count($scripts) == 0) return;


        foreach ($scripts as $s) {
            if (!array_key_exists($s, self::$ARCHIVE)) {
                throw new \Exception("Script " . $s . " not adopted", 400);
            }
            $script = file_get_contents(self::$ARCHIVE[$s]);
            echo  $script;
        }
    }
}
