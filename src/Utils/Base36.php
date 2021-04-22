<?php

namespace ilDug\Utils;

/**
 *  gestisce i codici in base 36
 */
class Base36
{

    static $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");



    /**
     * restituisce il valore successivo di un codice passato come argomento.
     * @param string $prev = '000' il codice precendete
     */
    public static function next($prev = '0', $charsNum = 1): string
    {
        $prev = is_array($prev) ? Base36::last($prev) : $prev;
        $int = (intval($prev, 36) + 1);
        $str36 = base_convert($int, 10, 36);
        return str_pad($str36, $charsNum, "0", STR_PAD_LEFT);
    }


    /**
     * restituisce il maggiore dei codici in base 36 di una lista
     * STATIC 
     */
    public static function last(array $list)
    {
        /** clona la lista */
        $_list = $list;
        return Base36::sortDesc($_list)[0];
    }


    /**
     * callback privata per ordinare i codici ASC
     */
    private static function _sortAsc($a, $b)
    {
        $ax = intval($a, 36);
        $bx = intval($b, 36);

        if ($ax < $bx) return -1;
        if ($ax > $bx) return 1;
        return 0;
    }



    /**
     * callback privata per ordinare i codici DESC
     */
    private static function _sortDesc($a, $b)
    {
        $ax = intval($a, 36);
        $bx = intval($b, 36);

        if ($ax > $bx) return -1;
        if ($ax < $bx) return 1;
        return 0;
    }


    /**
     * ordina una lista di codici in base 36  ASC
     */
    public static function  sortAsc(array $list)
    {
        usort($list, array("Base36", "_sortAsc"));
        return $list;
    }


    /**
     * ordina una lista di codici in base 36  DESC
     */
    public static function sortDesc(array $list)
    {
        usort($list, array("Base36", "_sortDesc"));
        return $list;
    }
}
