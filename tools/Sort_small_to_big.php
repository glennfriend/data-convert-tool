<?php

/**
 * 排序 小 to 大
 */
class Sort_small_to_big extends ToolBaseObject
{

    function run()
    {
        $text = $this->getText();
        $lines = explode("\n",$text);
        asort($lines);
        $text = join($lines,"\n");
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