<?php

/**
 * 程式碼上色
 */
class SourceCodeToColor extends ToolBaseObject
{

    public function init()
    {
        if( !$this->getText() ) {
            $this->setText( 'echo "hi";' );
        }
    }

    function run()
    {
        $codePrefix    = '<'.'?php';
        $codeDesinence = '?'.'>';

        $text = trim($this->getText());
        if( $codePrefix != strtolower(substr($text,0,5)) ) {
            $text = $codePrefix ."\n". $text ."\n". $codeDesinence ;
        }

        ob_start();
        highlight_string( $text );
        $html = ob_get_contents();
        ob_end_clean();

        $this->setBeforeText( $html );

    }

}


//