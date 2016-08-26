<?php

class Json_to_properties extends ToolBaseObject
{

    public function init()
    {
        if (!$this->getText()) {
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
            $this->setText(json_encode($defaultData, JSON_PRETTY_PRINT));
        }
    }

    function run()
    {
        $originText = $this->getText();
        $textOneLine = json_encode(json_decode($originText, true));

        $text = json_decode($originText, true);

        if (json_last_error()) {
            $this->setBeforeText(
                '<pre>'
                    . 'Input-Error: ' . json_last_error_msg()
                .'</pre>'
            );
            return;
        }

        $this->setBeforeText(
            '<pre>'
                . $textOneLine
                . "\n\n"
                . serialize($text)
                . "\n\n"
                .  print_r($text, true)
            .'</pre>'
        );
    }

}


//