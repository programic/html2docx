# Programic - HTML 2 DOCX

Met deze package kun je HTML converteren naar Word, ODText, RTF en PDF.
## Gebruik
Om deze package te gebruiken, installeer je de package via composer.

In je `composer.json`:
```json
{
  "require": {
    "programic/html2docx": "^1.0"
  }
}
```

In je code:
```php
<?php

use Programic\Html2Docx\Docx;

$docx = new Docx($settings);
$docx->setContent($content);
$docx->save($location, $writerInterface='Word2007');
```

#### Settings
```
'base_root' => url('/'), // Required for link elements - change it to your domain.
'base_path' => base_path(), // Path from base_root to whatever url your links are relative to.

'current_style' => ['size' => '11'], // The PHPWord style on the top element
'parents' => [0 => 'body'], // Our parent is body.
'list_depth' => 0, // This is the current depth of any current list.
'context' => 'section', // Possible values - section, footer or header.
'pseudo_list' => true, // NOTE: Word lists not yet supported (TRUE is the only option at present).
'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
'table_allowed' => true, // Tables cannot be nested in PHPWord.
'treat_div_as_paragraph' => true, // If set to TRUE, each new div will trigger a new line in the Word document.

// This is an array (the "style sheet")
'style_sheet' => [], // check hasStyles trait for options
```
#### Writer Interface
De writerInterface geeft door naar welk formaat we de html gaan omzetten. De mogelijkheden zijn:

1. Word2007
2. ODText
3. RTF
4. PDF
