<?php

use yii1\helpers\Cache;

add_filter('wc_get_template_part', function ($template, $slug, $name = null) {
    static $templateParts = [];

    global $yii;

    $name = $name ?? 0;
    $template = CHtml::value($templateParts, "{$slug}.{$name}", $template);
    $templateParts[$slug][$name] = $template;

    if ($template && ($post = get_post())) {
        $key = implode('/', array_filter([
            'wc_get_template_part',
            $slug,
            $name,
            $post->ID . '-' . ($yii->user->discountGroup ?: 0),
        ]));
        $stamp = strtotime($post->post_modified_gmt);
        $ret = Cache::getOrSetTemplate($key, $stamp, function () use ($template) {
            ob_start();
            load_template($template, false);

            return ob_get_clean();
        });
    }

    return $ret ?? $template;
}, 1, 3);
