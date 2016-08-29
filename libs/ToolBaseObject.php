<?php

class ToolBaseObject
{
    /**
     * 輸入
     */
    private $_text = null;

    /**
     * 輸出
     */
    private $_result = null;

    /**
     *
     */
    private $_output = [];

    /**
     *
     */
    public function __construct($text=null)
    {
        $this->setText($text);
    }

    /**
     *
     */
    public function init()
    {
        // you can settings
    }

    /**
     * 輸入的內容
     */
    public function setText($text)
    {
        $this->_text = $text;
    }

    /**
     * 輸入的內容
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * 輸出的內容
     */
    public function setResult($text)
    {
        $this->_result = $text;
    }

    /**
     * 輸出的內容
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     * 增加一組 輸出的格式
     */
    public function appendOutput($text, $type=null)
    {
        $this->_output[] = [
            'content'   => $text,
            'type'      => $type,
        ];
    }

    /**
     * 取得輸出的資料
     */
    public function getAllOutput()
    {
        return $this->_output;
    }

    /**
     *
     */
    public function run()
    {
        die('error - you need rewrite run() method.');
    }

    /**
     *  取得該程式的預設值
     */
    public function getDefaultText()
    {
        return '';
    }

}

