<?php
$db_server = 'localhost';
$db_user = 'zsht';
$db_pass = '1234';
$db_name = 'zsht';

function dbConnect($db_server, $db_name, $db_user, $db_pass) {
    try {
        $db_conn = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_user, $db_pass);
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $db_conn;
}
?>