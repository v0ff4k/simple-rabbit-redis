<?php
/**
 * Created by pSom.
 * User: 9r00+
 * at: 14.07.2025 - 23:54
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Consumer, that wait and exec queue from rabbit.
 */

// prepare, set params from ENV or settings. Dont forget to set "task_queue" name also from setting.
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');


$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done", "\n";
    $msg->ack();
};

$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
};

// close
$channel->close();
$connection->close();