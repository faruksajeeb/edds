<?php

return [
    'DEBUG' => true,
    'mode'                     => 'utf-8',
    'format'                   => 'A4',
    'default_font_size'        => '10',
    'default_font'             => 'Courier New',
    'margin_left'              => 20,
    'margin_right'             => 20,
    'margin_top'               => 20,
    'margin_bottom'            => 20,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    // 'orientation' => 'L', 
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => 'Sajeeb',
    // 'watermark'                => "ICDDR'B",
    'show_watermark'           => true,
    'show_watermark_image'     => false,
    'watermark_font'           => 'sans-serif',
    'display_mode'             => 'fullpage',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'custom_font_dir'          => base_path('public/assets/fonts/'),
'custom_font_data'         => [
        'kalpurush' => [
            'R'  => 'Kalpurush.ttf',
            'B'  => 'Kalpurush.ttf',
            'I'  => 'Kalpurush.ttf',
            'BI' => 'Kalpurush.ttf'
            ]
        ],
'auto_language_detection'  => true,
    'temp_dir'                 => storage_path('app'),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,
];
