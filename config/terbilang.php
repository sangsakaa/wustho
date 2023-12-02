<?php

// config for Riskihajar/Terbilang
return [
    'output' => [
        'date' => '{DAY} {MONTH} {YEAR}',
        'time' => '{HOUR} {SEPARATOR} {MINUTE} {MINUTE_LABEL} {SECOND} {SECOND_LABEL}',
    ],

    'locale' => 'id',

    'distance' => [
        'type' => \Riskihajar\Terbilang\Enums\DistanceDate::Day,
        'template' => '{YEAR} {MONTH} {DAY} {HOUR} {MINUTE} {SECOND}',
        'hide_zero_value' => true,
        'separator' => ' ',
        'terbilang' => false,
        'show' => [
            'year' => true,
            'month' => true,
            'day' => true,
            'hour' => true,
            'minute' => true,
            'second' => true,
        ],
    ],
];
