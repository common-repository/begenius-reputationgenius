<?php
return [
    'plugin_name' => 'ReputationGenius',

    // Il namespace del plugin
    // Deve esistere una cartella omonima nella root del progetto
    'plugin_namespace' => 'Reputationgenius',

    'menu_page' => [
        'page_title' => 'ReputationGenius',
        'menu_title' => 'ReputationGenius',
        'menu_slug' => 'reputationgenius',
        'capability' => 'manage_options',
        'icon' => [
            'type' => 'icon',
            'name' => 'dashicons-admin-comments',
        ],
        'position' => null,
    ],
    // Variabili di configurazione runtime
    'config' => [
        'tracking_url' => 'https://widget.reputationgenius.it/{slug}/tracking',
        'tracking_check_url' => 'https://widget.reputationgenius.it/{slug}/tracking-check',
        'tracking_script_url' => 'https://widget.reputationgenius.it/begenius/wp-tracking.js',
        'rev_btn_selector' => '.bgrg-rev-btn',
    ],
    // Opzioni plugin salvate sul db
    'options' => [
        'rss_feed_url' => [
            'title' => 'Url feed rss',
            'type' => 'text',
            'required' => true,
        ],
        'comments_cache_expiration' => [
            'title' => 'Durata della cache (s)',
            'type' => 'text',
            'required' => true,
            'value' => 900,
        ],
        'feed_type' => [
            'title' => 'Feed type',
            'type' => 'dropdown',
            'required' => true,
            'values' => [
                'xml' => 'XML',
                'json' => 'JSON',
            ]
        ],
        'landing_page_url' => [
            'title' => 'Landing page url',
            'type' => 'text',
            'required' => true,
            'value' => 'http://comments.reputationgenius.it/'
        ],
        'comments_template' => [
            'title' => 'Comments template',
            'type' => 'dropdown',
            'required' => true,
            'value' => 'hotel_master',
            'values' => [
                'custom' => 'Customizable',
                'hotel_master' => 'Hotel Master',
            ],
        ],
        'latest_comments_download' => [
            'title' => 'Latest comment download',
            'type' => 'text',
            'required' => false,
            'hidden' => true
        ],
        'paper_color' => [
            'title' => 'Paper color',
            'type' => 'text',
            'required' => true,
            'value' => '#FFF8E1'
        ],
        'paper_border_color' => [
            'title' => 'Paper border color',
            'type' => 'text',
            'required' => true,
            'value' => '#FFF8E1'
        ],
        'stars_color' => [
            'title' => 'Stars color',
            'type' => 'text',
            'required' => true,
            'value' => '#FF8F00'
        ],
        'stars_hidden_color' => [
            'title' => 'Stars hidden color',
            'type' => 'text',
            'required' => true,
            'value' => '#FFDDB5'
        ],
        'text_color' => [
            'title' => 'Text color',
            'type' => 'text',
            'required' => true,
            'value' => '#000000'
        ],
    ],
];
