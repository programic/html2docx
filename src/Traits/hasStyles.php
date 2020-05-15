<?php

namespace Programic\Html2Docx\Traits;

use \PhpOffice\PhpWord\Style\Font;

trait hasStyles
{
    public function getStyles()
    {
        $styles['default'] = [
            'size' => 11,
        ];

        $styles['elements'] = [
            'h1' => [
                'bold' => true,
                'size' => 20,
            ],
            'h2' => [
                'bold' => true,
                'size' => 15,
                'spaceAfter' => 150,
            ],
            'h3' => [
                'size' => 12,
                'bold' => true,
                'spaceAfter' => 100,
            ],
            'li' => [],
            'ol' => [
                'spaceBefore' => 200,
            ],
            'ul' => [
                'spaceAfter' => 150,
            ],
            'strong' => [
                'bold' => true,
            ],
            'b' => [
                'bold' => true,
            ],
            'em' => [
                'italic' => true,
            ],
            'i' => [
                'italic' => true,
            ],
            'sup' => [
                'superScript' => true,
                'size' => 6,
            ],
            'u' => [
                'underline' => Font::UNDERLINE_SINGLE,
            ],
            'a' => [
                'color' => '0000FF',
                'underline' => Font::UNDERLINE_SINGLE,
            ],
            'table' => [
                'borderColor' => '000000',
                'borderSize' => 10,
            ],
            'th' => [
                'borderColor' => '000000',
                'borderSize' => 10,
            ],
            'td' => [
                'borderColor' => '000000',
                'borderSize' => 10,
            ],
        ];

        $styles['classes'] = [];

        $styles['inline'] = [
            'text-decoration: underline' => [
                'underline' => Font::UNDERLINE_SINGLE,
            ],
            'vertical-align: left' => [
                'align' => 'left',
            ],
            'vertical-align: middle' => [
                'align' => 'center',
            ],
            'vertical-align: right' => [
                'align' => 'right',
            ],
        ];

        return $styles;
    }
}
