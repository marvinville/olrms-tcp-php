<?php
$port = 43556;
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

$env = '1';

$ip = $env === '0' ? '127.0.0.1' : '35.232.137.166';

if ($sock === false) 
{
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        exit();
}

if(socket_connect($sock, $ip, $port) === false){
        echo socket_strerror(socket_last_error());
        socket_close($sock);
        exit();
}

$msg = 'Test MarvinV';

socket_write($sock,$msg);

echo socket_read($sock, 2048);

?>