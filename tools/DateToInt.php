<?php

/**
 * 日期 to Int
 */
class DateToInt extends ToolBaseObject
{

    public function init()
    {
        /*
        if (!$this->getText()) {
            $defaultValue = $this->getDefaultText();
            $this->setText($defaultValue);
        }
        */
    }

    public function run()
    {
        $text = $this->getText();

        $dateInt = strtotime($text);
        $this->setResult($dateInt);
    }

    /**
     *
     */
    public function getDefaultText()
    {
        return '2000-01-01';
    }

}

//