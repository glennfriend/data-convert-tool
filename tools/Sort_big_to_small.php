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
        arsort($lines, SORT_NUMERIC);
        $text = join("\n", $lines);
        $this->setResult($text);
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