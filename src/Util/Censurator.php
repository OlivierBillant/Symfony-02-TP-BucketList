<?php

namespace App\Util;

class Censurator{

public function purify(string $text){

    $blackList = array("flute", "bigre", "diantre");
    return str_replace($blackList,"*",$text);

}
}