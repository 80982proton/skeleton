<?php

namespace PimcoreZendBundle\Templating\Zend;

use PimcoreBundle\Document\TagRenderer;
use PimcoreBundle\View\ZendViewHelperBridge;
use PimcoreZendBundle\Templating\Zend\Helper\DocumentTag;
use Zend\View\Renderer\PhpRenderer as BasePhpRenderer;

class PhpRenderer extends BasePhpRenderer
{
    /**
     * @var TagRenderer
     */
    protected $tagRenderer;

    /**
     * @var ZendViewHelperBridge
     */
    protected $zendViewHelperBridge;

    /**
     * @param TagRenderer $tagRenderer
     */
    public function setTagRenderer(TagRenderer $tagRenderer)
    {
        $this->tagRenderer = $tagRenderer;
    }

    /**
     * @param ZendViewHelperBridge $zendViewHelperBridge
     */
    public function setZendViewHelperBridge($zendViewHelperBridge)
    {
        $this->zendViewHelperBridge = $zendViewHelperBridge;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $argv)
    {
        // TODO zf1 view helpers are used until we ported them to Zend\View 3
        if ('zf1_' === substr($method, 0, 4)) {
            return $this->renderLegacyViewHelper(substr($method, 4), $argv);
        }

        if ($this->tagRenderer->tagExists($method)) {
            if (!isset($argv[0])) {
                throw new \Exception('You have to set a name for the called tag (editable): ' . $method);
            }

            // set default if there is no editable configuration provided
            if (!isset($argv[1])) {
                $argv[1] = [];
            }

            /** @var DocumentTag $helper */
            $helper = $this->plugin('documentTag');

            // delegate to documentTag view helper - calls __invoke
            return $helper($method, $argv[0], $argv[1]);
        }

        return parent::__call($method, $argv);
    }

    /**
     * Render ZF1 view helper via zend view helper bridge
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    protected function renderLegacyViewHelper($name, array $arguments = [])
    {
        return $this->zendViewHelperBridge->execute($name, $arguments);
    }
}
