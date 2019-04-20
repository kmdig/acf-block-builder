<?php

namespace KnowlerKnows\AcfBlockBuilder;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Block extends FieldsBuilder
{
    public function __construct($name, $config = [])
    {
        parent::__construct($name, $config);

        $this->setLocation('block', '===', "acf/{$this->name}");
    }

    public function build()
    {
        if (function_exists('acf_register_block')) {
            acf_register_block([
                'name' => $this->name,
                'title' => $this->title ?? $this->generateLabel($this->name),
                'description' => $this->description ?? null,
                'icon' => $this->icon ?? null,
                'category' => $this->category ?? 'common',
                'keywords' => $this->keywords ?? [],
                'render_callback' => isset($this->renderCallback)
                    ? function ($block) {
                        call_user_func($this->renderCallback, $block);
                    }
                    : [$this, 'render'],
            ]);
        }

        return parent::build();
    }

    public function render($block)
    {
        echo \Roots\view("blocks.{$this->name}", $block);
    }

    public function renderWith(callable $renderCallback)
    {
        $this->renderCallback = $renderCallback;

        return $this;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;

        return $this;
    }

    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function setKeywords(...$keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }
}
