# ACF Block Builder for Sage

A wrapper around ACF Builder for registering ACF Blocks.
Default usage is for Sage 10.

## Installation

Within your theme or plugin:

```shell
$ composer require kmdigital/acf-block-builder
```

## Usage

```php
use KMDigital\AcfBlockBuilder\Block;

$testimonial = new Block('testimonial');

$testimonial
    ->addWysiwyg('content')
    ->addText('person')
    ->addText('where')
    ->addText('when');

add_action('acf/init', function () use ($testimonial) {
    acf_add_local_field_group($testimonial->build());
});
```

There are additional methods you can use for setting and
overriding block options:

```php
$testimonial
  // Allows you to set a custom title for the block. 
  // Default is the block name/slug titlized.
  ->setTitle('Review')

  // Allows you to set the block description. Default is none.
  ->setDescription('A review with meta.')

  // Allows you to set the block description. Default is a block.
  ->setIcon('star-half')

  // Allows you to set the block category. Default is none.
  ->setCategory('common')

  // Allows you to set the block keywords. Default is none.
  ->setKeywords('review', 'testimonial')

  // Allows you to use a different rendering function. Default is Sage 10 (Acorn).
  ->renderWith(['Me\\View\\', 'render']);
```

## Default rendering function

The default rendering function is for Sage 10 or projects using
Acorn. It searches for templates in `resources/views/blocks` (if
`resources/views` is your default views path).
