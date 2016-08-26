<?php

/**
 * 網頁內的網址資訊
 */
class GetUrlInformation extends ToolBaseObject
{

    public function init()
    {
        if( !$this->getText() ) {
            $this->setText( 'http://www.google.com.tw' );
        }
    }

    public function run()
    {

        $url = trim($this->getText());
        $this->setText( $url );


        $a = tidy_parse_file($url);
        $a->cleanRepair();
        $html = print_r( $this->_dump_nodes($a->html()), true );

        $this->setAfterText(
            '<pre>' . htmlspecialchars($html) . '</pre>'
        );

    }

    /**
     *  dump http
     *  將一個檔案( or url )的網址分離出來
     *
     */
    protected function _dump_nodes(tidyNode $node, &$urls = NULL)
    {

        $urls = (is_array($urls)) ? $urls : array();

        if(isset($node->id)) {
            if($node->id == TIDY_TAG_A) {
                $urls[] = $node->attribute['href'];
            }
        }

        if($node->hasChildren()) {
            foreach($node->child as $c) {
                $this->_dump_nodes($c, $urls);
            }
        }

        return $urls;
    }

}


//