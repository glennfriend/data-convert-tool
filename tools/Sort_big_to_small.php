<?php

/**
 * 排序 大 to 小
 */
class Sort_big_to_small extends ToolBaseObject
{

    function run()
    {
        $text = $this->getText();

        $lines = explode("\n", $text);
        arsort($lines);
        $text = join($lines, "\n");
        $this->setBeforeText($text);
    }

    /**
     *
     */
    public function getDefaultText()
    {
        return "3\n5\n1\n2\n4";
    }

}


//