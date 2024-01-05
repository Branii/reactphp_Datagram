<?php 

require __DIR__ . '/vendor/autoload.php';
use React\EventLoop\Loop;
$factory = new React\Datagram\Factory();
$socket = '192.168.254.172:2020';

$loop = Loop::get();
$clients = [];

$factory->createServer($socket)->then(function (React\Datagram\Socket $server) use ($loop, &$clients) {

    $server->on('message', function($message, $clientAddress, $server) use (&$clients) {
        echo 'received "' . $message . '" from ' . $clientAddress . PHP_EOL;

        // Store connected clients
        if (!in_array($clientAddress, $clients)) {
            $clients[] = $clientAddress;
        }
    });

    $server->on('error', function(Exception $e, React\Datagram\Socket $server) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    });

    $server->on('close', function($clientAddress) use (&$clients) {
        echo 'Client ' . $clientAddress . ' disconnected' . PHP_EOL;

        // Remove disconnected client from the list
        $key = array_search($clientAddress, $clients);
        if ($key !== false) {
            unset($clients[$key]);
        }
    });

    // Send messages to connected clients at regular intervals
    $loop->addPeriodicTimer(5, function() use ($server, &$clients) {
        echo 'Sending regular message to ' . count($clients) . ' clients' . PHP_EOL;
        foreach ($clients as $clientAddress) {
            $server->send('Regular message', $clientAddress);
        }
    });

});

echo 'Listening on ' . $socket . PHP_EOL;

$loop->run();


?>