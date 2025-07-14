<?php
/**
 * Created by pSom.
 * User: 9r00+
 * at: 15.07.2025 - 0:11
 */

require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

/**
 * Consumer, that pull time to time resp. from Redis.
 */

// prepare, set params from ENV or settings. + param "task_queue" to store messages.
$client = new Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

/// DO, without closing connections.
while (true) {
    $result = $client->blpop(['task_queue'], 0); // Блокирующее чтение
    $message = $result[1];
    echo " [x] Received: $message\n";
}