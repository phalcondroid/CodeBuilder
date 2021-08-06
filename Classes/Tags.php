<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Builder\Base;

/**
 * Code Builder for php tool.
 *
 * LICENSE
 *
 * This source file is subject to license that is bundled
 * with this package in the file docs/LICENSE.txt.
 *
 * @author Julian Arturo Molina Castiblanco @phalcondroid
 */
class Tags extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * @var const integer
     */
    const PHP = 1;

    /**
     * @var const integer
     */
    const SCRIPT = 2;

    /**
     * @var const integer
     */
    const STYLE = 3;

    /**
     * @var const integer
     */
    const HTML = 4;

    /**
     * @var const integer
     */
    const HTML_COMMENT = 5;

    /**
     * Initialize tags informatios such as type and others.
     *
     * @param string | Base $content
     * @param int           $type
     * @param bool          $close
     */
    public function __construct($content, $type = self::PHP, $close = false)
    {
        $this->struct['type'] = $type;
        $this->struct['content'] = $content;
        $this->struct['close'] = $close;
    }

    /**
     * Receive initialized data from struct array.
     *
     * @param string | Base $content [description]
     * @param booleam       $close   [description]
     *
     * @return string
     */
    private function getPHPTags($content, $close = false)
    {
        $dataContent = $content;
        if ($content instanceof Base) {
            $dataContent = $content->resolve();
        }

        if ($close) {
            return "<?php\n\n".$dataContent."\n?>".PHP_EOL;
        }

        return "<?php\n\n".$dataContent;
    }

    /**
     * Return any content with tags.
     *
     * @return string
     */
    public function resolve()
    {
        switch ($this->struct['type']) {
            case 1:
                return $this->getPHPTags($this->struct['content'], $this->struct['close']);
        }
    }
}
