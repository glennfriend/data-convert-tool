<?php

class To_MD5 extends ToolBaseObject
{

    function run()
    {
        $text = trim($this->getText());

        $code = md5($text);
        $result = "注意! 以下結果是經由 textarea 的值做過 trim() 處置：<br /><br />". '"'. $code . '"';

        $this->setText( $text );
        $this->setBeforeText( $result );
    }

}

//