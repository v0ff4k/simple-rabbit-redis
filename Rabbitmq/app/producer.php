<?php
/**
 * Created by pSom.
 * User: 9r00+
 * at: 14.07.2025 - 23:54
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * creating queue for rabbit from  http://localhost/producer.php?msg=some_test_message_that_will_be_in_queue
 */

// prepare, add string sanitizing.
$message = isset($_GET['msg']) ? $_GET['msg'] : 'Hello from PHP '.PHP_VERSION;
// prepare connection. move to ENV and others configs.
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');

/// DO
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

$msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent '$message'\n";

// close
$channel->close();
$connection->close();