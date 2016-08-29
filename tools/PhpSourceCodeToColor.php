<?php

/**
 * PHP 程式碼上色
 */
class PhpSourceCodeToColor extends ToolBaseObject
{

    function run()
    {
        $codePrefix    = '<'.'?php';
        $codeDesinence = '?'.'>';

        $text = trim($this->getText());
        if (!$text) {
            return;
        }

        if( $codePrefix != strtolower(substr($text,0,5)) ) {
            $text = $codePrefix ."\n". $text ."\n". $codeDesinence ;
        }

        ob_start();
        highlight_string($text);
        $html = ob_get_contents();
        ob_end_clean();

        $this->setBeforeText($html);
    }


    /**
     *
     */
    public function getDefaultText()
    {
        return 'echo "hi";';
    }

}


//