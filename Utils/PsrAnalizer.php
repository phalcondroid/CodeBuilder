<?php

namespace CodeBuilder\Utils;

class PsrAnalizer
{
    /**
     * @var [type]
     */
    private $file = '';
    /**
     * @param [type] $data [description]
     */
    public function __construct($data)
    {
        if (is_string($data)) {
            $this->analizeString($data);
        }
    }
    /**
     * @return [type] [description]
     */
    public function analizeString($data)
    {
        $this->setBlankSpace($data);
        $regEx = "/(^[\r\n\n]*|[\r\n\n]+)[\s\t]*[\r\n\n]+/";
        $this->file = preg_replace($regEx, PHP_EOL.PHP_EOL, $this->file);
    }

    /**
     * [setBlankSpace description].
     */
    public function setBlankSpace($data)
    {
        $temp = explode(PHP_EOL, $data);
        foreach ($temp as $key => $item) {
            $auxItem = explode(' ', $item);
            if (count($auxItem) > 0) {
                if ($key + 1 < count($temp)) {
                    $auxItem2 = explode(' ', $temp[$key + 1]);
                    if ($auxItem[0] == 'use' and ($auxItem2[0] == 'class' or $auxItem2[0] == '/**')) {
                        array_splice($temp, $key + 1, 0, array(PHP_EOL));
                    }
                }
            }
        }
        $this->file = implode(PHP_EOL, $temp);
    }

    /**
     * [get description].
     *
     * @return [type] [description]
     */
    public function get()
    {
        return $this->file;
    }
}
