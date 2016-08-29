<?php

/**
 *
 */
class Ip_to_country extends ToolBaseObject
{

    public function init()
    {
    }

    public function run()
    {
        $text = '';
        $ip = trim($this->getText());
        if ($ip) {
            $text = $this->ip2country($ip, 2);
        }

        $this->setBeforeText($text);
    }

    /*
        利用跟 ip-to-country.csv 比對 ip 的方式,
        來查詢此 ip 的來源

        $type:
            0   國家 2 位元簡稱
            1   國家 3 位元簡稱
            2   國家完整名稱

     */
    public function ip2country( $ip='' ,$type=0 ,$where = "../storage/ip-to-country/") {
        // CSV: http://ip-to-country.directi.com/
        // Author: andr3a [ www.3site.it ] [ andrea@3site.it ]
        // Author: mdsjack [ www.mdsjack.tk/ ] [ mdsjack@iol.it ]
        $ip = explode(".", $ip);
        $ip = ($ip[0] * 16777216) + ($ip[1] * 65536) + ($ip[2] * 256) + ($ip[3]);
        //echo $ip.'<br><br>';
        $csv = fopen($where . "ip-to-country.csv", "r");
        while ($line = fgetcsv($csv, 1024)) {
            list ($from, $to, $code[0], $code[1], $code[2]) = $line;
            //echo "$from , $to , {$code[0]} ,{$code[1]} ,{$code[2]} , <br>";
            if (($from <= $ip) and ($to >= $ip)) {
                fclose($csv);
                $sended = isSet($code[$type]) && $code[$type]!='' ? $code[$type] : "UNK";
                return $sended;
            }
        }
        fclose($csv);
        return "YOU";
    }

    /**
     *
     */
    public function getDefaultText()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

}


//