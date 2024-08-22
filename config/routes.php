<?php
return [
    'throttle' => [
        'maxAttempts' => 100,
        'decayMinutes' => 5,
    ],
    'blacklist' => [
        '192.168.1.1',
        '10.0.0.1-10.2.0.1', // Range spanning multiple subnets
        '203.0.*.*', // Wildcard
    ],
    'whitelist' => [
        '203.0.113.42',
        '198.51.100.23',
        '192.168.*.*', // Wildcard
    ],
];