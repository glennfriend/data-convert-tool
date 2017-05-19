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
            $this->appendOutput(
                'json_last_error_msg()' . "\n"
                . json_last_error_msg() . "\n"
            );
            return;
        }

        $this->setResult(
            print_r($text, true)
        );

        $textArray = json_decode($originText, true);
        $textOneLine = json_encode($textArray);
        // to properties
        // $this->appendOutput(serialize($text));
        // to json
        $this->appendOutput($textOneLine);
        // to json pretty
        $this->appendOutput(json_encode($textArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

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