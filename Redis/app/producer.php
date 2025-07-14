<?php
/**
 * Created by pSom.
 * User: 9r00+
 * at: 15.07.2025 - 0:09
 */

require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

/**
 * Creating queue for Redis from url  from  http://localhost/producer.php?msg=test_message_that_will_be_in_queue
 */

// set params from ENV or settings.
$client = new Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

// prepare
$msg = isset($_GET['msg']) ? $_GET['msg'] : 'Hello from PHP ' . PHP_VERSION;

// sent(store)
$client->rpush('task_queue', $msg);

echo " [x] Sent '$msg'\n";