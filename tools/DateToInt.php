<?php

/**
 * 日期 to Int
 */
class DateToInt extends ToolBaseObject
{

    public function init()
    {
        if( !$this->getText() ) {
            $this->setText('2000-01-01');
        }
    }

    public function run()
    {
        $text = $this->getText();

        $dateInt = strtotime($text);
        $this->setBeforeText($dateInt);
    }

}

//