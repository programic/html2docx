<?php

namespace Programic\Html2Docx;

use PhpOffice\PhpWord\Exception\Exception;
use Programic\Html2Docx\Simplehtmldom\SimpleHtmlDom;
use Programic\Html2Docx\Traits\hasStyles;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

/**
 * Class Docx
 * @package Programic\HtmlToDocx
 */
class Docx
{
    use hasStyles;

    private $dom;
    private $phpWord;
    private $settings;
    private $file = null;
    private $styles = [];
    private $controls = [];
    private $writerInterface = 'Word2007';

    /**
     * Docx constructor.
     * @param array $settings
     */
    public function __construct($settings = [])
    {
        $this->dom = new SimpleHtmlDom();
        $this->phpWord = new PhpWord();

        $base_root = function_exists('url') ? url('/') : null;
        $base_path = function_exists('base_path') ? base_path() : null;
        $this->settings = array_merge([
            // Required parameters:
            'phpword_object' => &$this->phpWord, // Must be passed by reference.
            'base_root' => $base_root, // Required for link elements - change it to your domain.
            'base_path' => $base_path, // Path from base_root to whatever url your links are relative to.
            // Optional parameters - showing the defaults if you don't set anything:
            'current_style' => ['size' => '11'], // The PHPWord style on the top element
            'parents' => [0 => 'body'], // Our parent is body.
            'list_depth' => 0, // This is the current depth of any current list.
            'context' => 'section', // Possible values - section, footer or header.
            'pseudo_list' => true, // NOTE: Word lists not yet supported (TRUE is the only option at present).
            'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
            'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
            'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
            'table_allowed' => true, // Tables cannot be nested in PHPWord.
            'treat_div_as_paragraph' => true, // If set to TRUE, each new div will trigger a new line in the document.

            // This is an array (the "style sheet")
            'style_sheet' => $this->getStyles(),
        ], $settings);
    }

    public function setStyles(array $styles)
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    public function setElementControl(string $target, $callback) : self
    {
        $this->controls[$target] = $callback;

        return $this;
    }

    /**
     * @param $writerInterface
     * @return $this
     */
    public function setWriterInterface($writerInterface)
    {
        if (in_array($writerInterface, [
            'ODText',
            'RTF',
            'Word2007',
            'HTML',
            'PDF'
        ])) {
            $this->writerInterface = $writerInterface;
        }

        return $this;
    }

    private function render()
    {
        $this->dom->load('<html><body>' . $this->content . '</body></html>');

        $section = $this->phpWord->createSection();
        $html_dom_array = $this->dom->find('html', 0)->children();
        htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $this->settings, $this->controls);

        $this->dom->clear();
        $this->dom = null;
    }

    private function settings()
    {
        foreach ($this->settings['style_sheet'] as $type => $setting) {
            if (isset($this->styles[$type])) {
                $this->settings['style_sheet'][$type] = array_merge($setting, $this->styles[$type]);
            }
        }
    }

    /**
     * @param $location
     * @param null $writerInterface
     * @return mixed
     * @throws Exception
     */

    public function save($location, $writerInterface = null)
    {
        $this->settings();
        $this->render();

        if ($this->writerInterface !== null) {
            $this->setWriterInterface($writerInterface);
        }

        $objWriter = IOFactory::createWriter($this->phpWord, $this->writerInterface);

        return $objWriter->save($location);
    }
}
