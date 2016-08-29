<?php

class To_MD5 extends ToolBaseObject
{

    function run()
    {
        $text = trim($this->getText());
        if (!$text) {
            return;
        }

        $code = md5($text);
        $this->setText($text);
        $this->setResult($code);
        $this->appendOutput('注意! 原本輸入的資料有經過 trim() 處置', 'pre');
    }

    /**
     *
     */
    public function getDefaultText()
    {
        return "123456";
    }

}

//