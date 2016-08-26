<?php

class ToolBaseObject
{
    /**
     *
     */
    private $_beforeText = null;

    /**
     *
     */
    private $_text = null;

    /**
     *
     */
    private $_afterText = null;

    /**
     *
     */
    public function __construct( $text=null )
    {
        if( $text ) {
            $this->setText( $text );
        }
    }

    /**
     *
     */
    public function init()
    {
        // you can settings
    }

    /**
     *
     */
    public function setText( $text )
    {
        $this->_text = $text;
    }
    public function getText()
    {
        return $this->_text;
    }

    /**
     *
     */
    public function setBeforeText( $text )
    {
        $this->_beforeText = $text;
    }
    public function getBeforeText()
    {
        return $this->_beforeText;
    }

    /**
     *
     */
    public function setAfterText( $text )
    {
        $this->_afterText = $text;
    }
    public function getAfterText()
    {
        return $this->_afterText;
    }

    /**
     *
     */
    public function run()
    {
        die('error - you need rewrite run() method.');
    }

}


//