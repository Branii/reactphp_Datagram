<?php 

use React\EventLoop\Loop;
use React\MySQL\Factory as MYSQL_FACTORY;
use React\MySQL\QueryResult as REACT_RESULT;
require __DIR__ . '/vendor/autoload.php';

$loop = Loop::get();
// $mySqlFactory = new MYSQL_FACTORY($loop);
// $connection = $mySqlFactory->createLazyConnection('root:root@localhost/bets');
// $timer = $loop->addPeriodicTimer(1, function () use ($connection) { 
//     $connection->query('SELECT * FROM actions WHERE status = "done"')->then(
//             function (REACT_RESULT $result) {
//                 $rows = $result->resultRows;
//                 if (count($rows) > 0) {
//                     echo "Changes detected in the database!\n";
//                     // Execute your script or perform desired action here
//                 } else {
//                     echo "No changes detected.\n";
//                 }
//             },
//             function (Exception $e) {
//                 echo "Error: " . $e->getMessage() . "\n";
//             }
//         );
// });

function fetchData(){
    echo "Fetching data from database" . date('Y-m-d H:i:s') . "\n";
}

$timer1 = $loop->addPeriodicTimer(5, function(){

    date('s') === 0 ? fetchData() : "wait";

});

$loop->run();

?>