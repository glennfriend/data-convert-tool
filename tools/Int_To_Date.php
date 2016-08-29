<?php

/**
 * Int to Date
 */
class Int_To_Date extends ToolBaseObject
{

    public function init()
    {
    }

    public function run()
    {
        $text = $this->getText();
        $myDate = date("Y-m-d H:i:s", $text);
        $this->setResult($myDate);
    }

    public function getDefaultText()
    {
        return '954518400';
    }

}

//