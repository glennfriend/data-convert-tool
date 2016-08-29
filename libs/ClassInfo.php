<?php

class ClassInfo
{
    /**
     *
     */
    protected $className;

    /**
     *
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * 取得 class info 的 title
     */
    public function getTitle()
    {
        $info = $this->getClassInfo();

        if (!isset($info['_class']['text'])) {
            return '';
        }
        $text = $info['_class']['text'];

        $tmp = explode("\n", $text);
        return $tmp[0];
    }


    // --------------------------------------------------------------------------------
    // private
    // --------------------------------------------------------------------------------

    /**
     * 取得 class info
     */
    protected function getClassInfo()
    {
        $className = $this->className;
        $reflector = new ReflectionClass($className);
        $info = ['_class' => $this->getReflector($reflector, $className)];

        foreach ($reflector->getMethods() as $reflectorMethod) {
            if ($reflectorMethod->class === $className) {
                $reflector = new ReflectionMethod($className, $reflectorMethod->name);
                $info[$reflectorMethod->name] = $this->getReflector($reflector, $reflectorMethod->name);
            }
        }

        return $info;
    }

    /**
     * 取得 reflector
     */
    protected function getReflector($reflector, $showName)
    {
        try {
            $scanner = new Zend\Code\Reflection\DocBlockReflection($reflector);
        }
        catch (Exception $e) {
            return [
                'name'   => $showName,
                'error'  => $e->getMessage(),
            ];
        }

        $getTag = function($tag) use ($scanner)
        {
            return $tag->getDescription();
            // $tag->getType()
        };

        /*
        $tagFlat = function($name) use ($scanner)
        {
            $tag = $scanner->getTag($name);
            if (!$tag) {
                return '';
            }

            pr(get_class_methods($tag));
            pr($tag);
            echo '<pre>';
            echo $tag->getContent();
            exit;
            return $tag->getDescription();
        };
        */

        $contents = [];
        foreach (explode("\n", $scanner->getContents()) as $line) {
            $line = $line;
            if ('@' === substr(trim($line),0,1)) {
                break;
            }
            $contents[] = $line;
        }
        $text = trim(join("\n", $contents));

        return [
            'name'    => $showName,
            'param'   => array_map($getTag, $scanner->getTags('param')),
            'return'  => $scanner->getTag('return'), // $tagFlat('return'), // $scanner->getTag('return'),
            'text'    => $text,
        ];

    }


}
