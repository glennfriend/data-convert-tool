<?php

class Mumber_to_english extends ToolBaseObject
{

    public function init()
    {
        if( !$this->getText() ) {
            $this->setText( "100\n123\n321" );
        }
    }

    public function run()
    {
        $text = $this->getText();
        $datas = explode("\n",$text);

        $results = Array();
        foreach( $datas as $data ) {
            $results[] = $data . ' - ' . $this->num2english( $data );
        }

        $text = join("<br />",$results);
        $this->setBeforeText( $text );
    }

    public function num2english( $n, $followup='' )
    {

        if($n==0)
        {
            if($followup=='no')
            {
                return "";
                exit();
            }
            else
            {
                return "zero";
                exit();
            }
        }
        switch($n)
        {
            case 1: return "one"; break;
            case 2: return "two"; break;
            case 3: return "three"; break;
            case 4: return "four"; break;
            case 5: return "five"; break;
            case 6: return "six"; break;
            case 7: return "seven"; break;
            case 8: return "eight"; break;
            case 9: return "nine"; break;
            case 10: return "ten"; break;
            case 11: return "eleven"; break;
            case 12: return "twelve"; break;
            case 13: return "thirteen"; break;
            case 14: return "fourteen"; break;
            case 15: return "fifteen"; break;
            case 16: return "sixteen"; break;
            case 17: return "seventeen"; break;
            case 18: return "eighteen"; break;
            case 19: return "nineteen"; break;
            case 20: return "twenty"; break;
            case 30: return "thirty"; break;
            case 40: return "forty"; break;
            case 50: return "fifty"; break;
            case 60: return "sixty"; break;
            case 70: return "seventy"; break;
            case 80: return "eighty"; break;
            case 90: return "ninety"; break;
            case 100: return "one hundred"; break;
            case 1000: return "one thousand"; break;
            case 100000: return "one lakh"; break;
            default:
            {
                if($n<100)
                {
                    return $this->num2english(floor($n/10)*10, 'no')."-".$this->num2english($n%10, 'no'); break;
                }
                elseif($n<1000)
                {
                    return $this->num2english(floor($n/100), 'no')." hundred ".$this->num2english($n%100, 'no'); break;
                }
                elseif($n<100000)
                {
                    return $this->num2english(floor($n/1000), 'no')." thousand ".$this->num2english($n%1000, 'no'); break;
                }
                elseif($n<10000000)
                {
                    return $this->num2english(floor($n/100000), 'no')." lakh ".$this->num2english($n%100000, 'no'); break;
                }
                else
                {
                    return "Something else"; break;
                }
            }
        }
    }


}

//