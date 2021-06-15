<?php


namespace App\Helpers;
use Illuminate\Support\Str;


class Utils
{

    public static function unaccents($str)
    {
        $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,ã,è,ì,ò,ù,ä,ë,ï,ö,õ,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
        $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,a,e,i,o,u,a,e,i,o,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
        return str_replace($search, $replace, $str);
    }

    public static function removeAcentosCollective($collection, $mapa)
    {
        $collection->map(function ($collect) use ($mapa) {
            $collect->$mapa = self::removeAcentos($collect->$mapa);
        });

       return $collection;
    }

    public static function removeAcentos($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }
    public static function str_contains($string, $needles) {
        return Str::contains($string, $needles);
    }


}
