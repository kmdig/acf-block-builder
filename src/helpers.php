<?php

namespace KnowlerKnows\AcfBlockBuilder;

/**
 * Runs wpautop on rich text fields within the block’s data.
 * @param $block []
 * @return []
 */
function prepare_block($block)
{
    foreach (array_keys($data = &$block['data']) as $key) {
        /** If non-used field, skip. */
        if (preg_match('/^(_|field_)/', $key)) {
            continue;
        }

        $field = get_field_object($key);
        $data[$key] = $field['type'] === 'wysiwyg' ? wpautop($field['value']) : $field['value'];
    }

    return $block;
}
