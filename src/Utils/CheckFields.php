<?php

namespace ilDug\Utils;

/** controlla che l'oggetto contenga tutte le proprietà 
 * @param object $item l'oggetto da controllare
 * @param array $fields array di stringhe che corrispondono alle proprietà che l'oggett odeve contenere
 * @return bool
 */
class CheckFields
{
    static function check(object $item, array $fields): bool
    {
        foreach ($fields as $field) {
            if (!$item->{$field}) {
                throw new \Exception("Attibuto mancante,  riprovare inserendo il valore per " . $field, 400);
                return false;
            }
        }
        return true;
    }
}
