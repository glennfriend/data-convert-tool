<?php

class ToTidy extends ToolBaseObject
{

    public function init()
    {
        if( !$this->getText() ) {
            $this->setText( 'http://www.google.com.tw' );
        }
    }

    function run()
    {

        $url = trim($this->getText());
        $this->setText( $url );

        $tidy = tidy_parse_file( $url );
        $tidy->cleanRepair();
        if( !empty($tidy->errorBuffer) ) {

            $this->setAfterText(
                '<pre>' . htmlspecialchars($tidy->errorBuffer) . '</pre>'
            );
        }

    }

}


//