<?php

namespace ilDug\Web;

class Meta
{
    public static $TEMPLATE = __DIR__ . '/meta/meta-tags.html';
    public static $PLACEHOLDERS = array('%TITLE%', '%DESCRIPTION%', '%MAIN_IMAGE%', '%URL%');

    /**
     * funzione che scrive i meta-tags
     * prende come parametro un array con 4 argomenti
     * 
     * @param array $meta parametro un array di stringhe con 4 argomenti [TITLE, DESCRIPTION, MAIN_IMAGE, URL]
     * @return  html stampa il template nella pagina web
     */
    public static function publish(array $meta)
    {
        /** controlla che il template esista */
        if (!file_exists(self::$TEMPLATE)) {
            throw new \Exception("Il template dei meta tags non esite", 400);
        }

        /** controlla che l'arrai con i valori abbia tutte le proprietà */
        $len_ = count(self::$PLACEHOLDERS);
        if (count($meta) !== $len_) {
            throw new \Exception("Largomento deve essere un array contentente tutti " . $len_ . " i valori", 400);
        }

        $template = new \ilDug\Template(self::$TEMPLATE);
        echo $template->fill(self::$PLACEHOLDERS, $meta)->payload;
    }
}
