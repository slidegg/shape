<?php

/**
 * Load styles/scripts
 */
$package = json_decode(file_get_contents(ABSPATH . 'package.json'), true);
$package = $package['gg7'] ?? [];

$assets = [
    'js' => [
        // 'bundled' => [],// all bundled scripts
        // 'bundles' => [],// script bundles to register
        // 'handle_first' => null,// first bundle, so that we can add aggregated extra['data'], extra['before'] to it for bundled scripts to work
        // 'handle_last' => null,// last bundle, so that we can add aggregated extra['after'] to it for bundled scripts to work
    ],
    'css' => [],
];

// parse assets[] from package.json
foreach ($package as $type => $config) {
    foreach ($config as $args => $cnf) {
        foreach ($cnf as $bundle_file => $included_assets) {
            if (!empty($included_assets)) {
                $assets[$type][$args] = $assets[$type][$args]
                    ?? [
                        'bundled' => [],
                        'bundles' => [],
                        'handle_first' => null,
                        'handle_last' => null,
                    ];
                $handle = URLify::filter(basename($bundle_file));
                if (!$assets[$type][$args]['handle_first']) {
                    $assets[$type][$args]['handle_first'] = $handle;
                }
                $assets[$type][$args]['handle_last'] = $handle;
                $assets[$type][$args]['bundles'][$handle] = $bundle_file;
                foreach ($included_assets as $included_asset) {
                    $assets[$type][$args]['bundled'][$included_asset] = $handle;
                }
            }
        }
    }
}

// register asset bundles on init so that they are registered before all other assets (scripts/styles)
add_action('init', function () use ($assets) {
    // $baseUrl = home_url();
    // $css = [
    //     'wp-content/themes/kallyas-child/assets/print.css' => 'print',
    //     'wp-content/themes/kallyas-child/assets/gg7.css' => 'all',
    // ];
    // $prev = null;
    // foreach ($css as $path => $media) {
    //     $slug = 'gg7-' . preg_replace('/^([^.]+)\..*$/', '$1', strtolower(basename($path)));
    //     if (!GG7_MODE_DEV) {
    //         $path = preg_replace('/\.css$/', '.min.css', $path);
    //     }
    //     wp_enqueue_style($slug, "{$baseUrl}/{$path}", $prev, filemtime(ABSPATH . $path), $media);
    //     $prev = $slug;
    // }
    // $js = [
    //     'wp-content/themes/kallyas-child/assets/vendor.js',
    //     'wp-content/themes/kallyas-child/assets/gg7.js',
    // ];
    // $prev = null;
    // foreach ($js as $path) {
    //     $slug = 'gg7-' . preg_replace('/^([^.]+)\..*$/', '$1', strtolower(basename($path)));
    //     if (!GG7_MODE_DEV) {
    //         $path = preg_replace('/\.js$/', '.min.js', $path);
    //     }
    //     wp_enqueue_script($slug, "{$baseUrl}/{$path}", $prev, filemtime(ABSPATH . $path), false);
    //     $prev = $slug;
    // }

    foreach ($assets as $type => $config) {
        foreach ($config as $args => $cnf) {
            foreach ($assets[$type][$args]['bundles'] as $slug => $asset) {
                if (!strncmp($asset, 'vendor/', 7)) {
                    continue;
                }
                $asset = GG7_MODE_DEV ? "{$asset}.{$type}" : "{$asset}.min.{$type}";
                if (is_file($asset)) {
                    switch ($type) {
                        case 'js':
                            wp_enqueue_script($slug, '/' . ltrim($asset, '/'), [], filemtime(ABSPATH . $asset), (bool)$args);
                            break;
                        case 'css':
                            wp_enqueue_style($slug, '/' . ltrim($asset, '/'), [], filemtime(ABSPATH . $asset), $args);
                            break;
                    }
                }
            }
        }
    }
}, 9999);

add_action('wp_enqueue_scripts', function () use ($assets) {
    // if (is_admin()) {
    //     return;
    // }

    // register styles to unload them afterwards
    $base = get_stylesheet_directory_uri();
    wp_deregister_style('kallyas-styles');
    wp_enqueue_style('kallyas-styles', get_template_directory_uri() . '/style.css', '', ZN_FW_VERSION);
    // wp_enqueue_style('kallyas-child', get_stylesheet_uri(), ['kallyas-styles'], ZN_FW_VERSION);
    wp_enqueue_style('kallyas-child-gg7', "{$base}/assets/gg7" . (GG7_MODE_DEV ? '' : '.min') . '.css', ['kallyas-styles'], ZN_FW_VERSION);
    wp_enqueue_style('kallyas-child', "{$base}/style.css", ['kallyas-styles'], ZN_FW_VERSION);

    /**
     * scripts
     */
    /*
     * remove bundled assets from queue while collecting their extras (not conditionals/rtl!)
     */
    $wp_deps = [
        'js' => wp_scripts(),
        'css' => wp_styles(),
    ];
    foreach ($wp_deps as $type => $deps) {
        foreach ($assets[$type] as $args => $cnf) {
            /** @var WP_Dependencies $deps */
            $queue = $deps->queue;
            $deps->all_deps($queue);
            $host = $_SERVER['SERVER_NAME'] ?? null;
            $asset_handles = [];
            $unhandled = [];
            $extra = [
                'before' => [],
                'after' => [],
                'data' => [],
            ];
            foreach ($deps->to_do as $i => $handle) {
                $asset = trim($deps->registered[$handle]->src);
                $asset = preg_replace("#^(https?:)?//{$host}#", '', $asset);
                $asset = preg_replace('#^/(?!/)#', '', $asset);
                if ($asset) {
                    if (isset($assets[$type][$args]['bundled'][$asset])) {
                        // handled assets, collect extras & dequeue
                        $registered =& $deps->registered[$handle];

                        if ($before = $registered->extra['before'] ?? null) {
                            /** @noinspection SlowArrayOperationsInLoopInspection */
                            $extra['before'] = array_merge($extra['before'], $before);
                        }
                        if ($after = $registered->extra['after'] ?? null) {
                            /** @noinspection SlowArrayOperationsInLoopInspection */
                            $extra['after'] = array_merge($extra['after'], $after);
                        }
                        if ($data = $registered->extra['data'] ?? null) {
                            $extra['data'][] = $data;
                        }
                        $asset_handles[$handle] = $asset;
                        $deps->registered[$handle]->src = null;
                        // $deps->dequeue($handle);
                        // unset($deps->to_do[$i]);
                        // $deps->done[] = $handle;
                    } else {
                        // unhandled & external assets, but we need to process their dependencies
                        $unhandled[] = $handle;
                    }
                } else {
                    // asset bundle with no src (like jquery), unregister it
                    $asset_handles[$handle] = true;
                    $deps->registered[$handle]->src = null;
                    // $deps->dequeue($handle);
                    // unset($deps->to_do[$i]);
                    // $deps->done[] = $handle;
                }
            }

            // remove registered dependencies for unhandled assets
            foreach ($unhandled as $handle) {
                /** @var _WP_Dependency $registered */
                $registered =& $deps->registered[$handle];
                foreach ($registered->deps ?? [] as $i => $dep) {
                    if ($asset_handles[$dep] ?? false) {
                        unset($registered->deps[$i]);
                    }
                }
                // fixme maybe move asset bundles unregister here -only- when all deps are registered?
            }

            // add extras to $assets[$type][$args]['handle_first'] / $assets[$type][$args]['handle_last']
            if (!empty($deps->registered[$assets[$type][$args]['handle_first']])) {
                $deps->registered[$assets[$type][$args]['handle_first']]->extra = array_filter([
                    'before' => $extra['before'] ?: null,
                    'data' => implode("\n", $extra['data']) ?: null,
                ]);
            }
            if (!empty($deps->registered[$assets[$type][$args]['handle_last']])) {
                $deps->registered[$assets[$type][$args]['handle_last']]->extra = array_filter([
                    'after' => $extra['after'] ?: null,
                ]);
            }
        }
    }
    // $scripts = GG7_MODE_DEV ? [
    //     'lodash' => 'js/vendor/lodash.min.js',
    //     'livequery' => 'js/vendor/jquery.livequery.min.js',
    //     'sticky-kit' => 'js/vendor/sticky-kit.min.js',
    //     // 'stickybits' => 'js/vendor/jquery.stickybits.min.js',
    //     'gg7_checkout' => 'js/checkout.js',
    //     'gg7_header' => 'js/header.js',
    //     'gg7_catalog_categories_widget' => 'js/catalog_categories_widget.js',
    // ] : ['gg7' => 'assets/gg7.min.js'];
    // foreach ($scripts as $slug => $script) {
    //     wp_enqueue_script($slug, "{$base}/{$script}", [], filemtime(__DIR__ . '/' . $script), false);
    // }

    // $base = get_stylesheet_directory_uri();
    //
    // /**
    //  * styles
    //  */
    // wp_deregister_style('kallyas-styles');
    // wp_enqueue_style('kallyas-styles', get_template_directory_uri() . '/style.css', '', ZN_FW_VERSION);
    // // wp_enqueue_style('kallyas-child', get_stylesheet_uri(), ['kallyas-styles'], ZN_FW_VERSION);
    // wp_enqueue_style('kallyas-child', "{$base}/assets/gg7" . (GG7_MODE_DEV ? '' : '.min') . '.css', ['kallyas-styles'], ZN_FW_VERSION);

    // $deps = wp_styles();
    // // $deps = wp_scripts();
    // $queue = $deps->queue;
    // $deps->all_deps($queue);
    // print_rp([
    //     'queue before all_deps' => $queue,
    //     'queue after all_deps' => $deps->queue,
    //     'to_do' => $deps->to_do,
    //     'registered' => $deps->registered,
    // ]);
    // foreach ($deps->to_do as $handler) {
    //     echo "{$deps->registered[$handler]->src}\n";
    // }
}, 9999);
