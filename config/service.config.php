<?php

namespace MJErwin\SonicScrewdriver;

use MJErwin\SonicScrewdriver\Log\Service\LogService;

return [
    'invokables' => [
        'MJErwin\\SonicScrewdriver\\Doctrine\\Validator\\IsUnique' => 'MJErwin\\SonicScrewdriver\\Doctrine\\Validator\\IsUnique',
        LogService::class => LogService::class,
    ],
];