<?php

namespace KMDigital\AcfBlockBuilder;

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
        if (function_exists('acf_register_block_type')) {
            acf_register_block_type([
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
                'align' => $this->align ?? '',
                'mode' => $this->mode ?? 'preview',
                'post_types' => $this->postTypes ?? null,
                'supports' => $this->supports ?? null,
            ]);
        }

        return parent::build();
    }

    /**
     * Render for Sage 10
     *
     * @param $block []
     */
    public function render($block)
    {
        $group = ltrim($block['name'], 'acf/');
        $block['acf'] = get_fields($block['id']);

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

    public function setAlign(string $align)
    {
        $this->align = $align;

        return $this;
    }

    public function setMode(string $mode)
    {
        $this->mode = $mode;

        return $this;
    }

    public function setSupports(array $supports)
    {
        $this->supports = $supports;

        return $this;
    }

    public function setPostTypes(...$postTypes)
    {
        $this->postTypes = $postTypes;

        return $this;
    }
}
