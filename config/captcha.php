<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd',
        'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9
    ],
    'fontsDirectory' => public_path('backend/assets/fonts2'),
    'bgsDirectory' => public_path('backend/assets/backgrounds'),
    'default' => [
        'length' => 6,
        'width' => 120,
        'height' => 40,
        'quality' => 90,
        'font' => 'arial.ttf', // pastikan font ini ada di fontsDirectory
    ],
    'flat' => [
        'length' => 6,
        'fontColors' => [
            '#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'
        ],
        'width' => 250,
        'height' => 50,
        'math' => false,
        'quality' => 100,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#c2c2c2ff',
        'contrast' => 0,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => false,
        'contrast' => -5,
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
    ],
];

