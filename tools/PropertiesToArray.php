<?php

/**
 * Properties
 */
class PropertiesToArray extends ToolBaseObject
{

    public function init()
    {
        ini_set("arg_seperator.output", "&amp;");
        ini_set("magic_quotes_runtime", 0 );
        ini_set("magic_quotes_gpc", true );
    }

    function run()
    {
        $text = $this->getText();


        /*
            原來插入數據庫時我的PHP用的是ANSCII編輯,
            而我復制出來后用unserialize()的PHP文件是UTF-8編碼,
            編碼不同,所以就出現錯誤了.
        */
      //$text = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $text);
      //$text = preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $text);
      //$text = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $text);

        /*
        $text = preg_replace_callback (
            '!s:(\d+):"(.*?)";!',
            function($match) {
                return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
            },
            $text
        );
        */

        $text = unserialize(trim($text));

        $this->setBeforeText(
            print_r($text, true)
        );

        $this->setAfterText(
            json_encode($text)
            . "\n\nor\n\n"
            . json_encode($text, JSON_PRETTY_PRINT)
        );

    }

    /**
     *
     */
    public function getDefaultText()
    {
        return 'a:1:{i:0;O:8:"stdClass":3:{s:5:"domId";s:15:"control_tag_143";s:2:"id";s:3:"143";s:4:"name";s:12:"￣)︿(￣)";}}';
    }

}


//
