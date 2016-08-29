<?php

/**
 * Json
 */
class Json_Show extends ToolBaseObject
{

    function run()
    {
        $originText = $this->getText();
        if (!$originText) {
            return;
        }

        $text = json_decode($originText, true);
        if (json_last_error()) {
            $this->setAfterText(
                'json_last_error_msg()' . "\n"
                . json_last_error_msg() . "\n"
            );
            return;
        }

        $this->setResult(
            print_r($text, true)
        );

        $textOneLine = json_encode(json_decode($originText, true));
        $this->appendOutput($textOneLine);
        $this->appendOutput(serialize($text));
    }

    /**
     *
     */
    public function getDefaultText()
    {
        $defaultData = [
            'id' => 12,
            'com' => 'happy',
            'items' => [
                'john' => [
                    'name' => 'john',
                    'like' => 'rice',
                ],
                'vivnan' => [
                    'name' => 'vivnan',
                    'like' => 'noodles',
                ],
            ],
        ];
        return json_encode($defaultData, JSON_PRETTY_PRINT);
    }

}


//