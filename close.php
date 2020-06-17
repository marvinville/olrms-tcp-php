<?php
$port = 43556;
$sock = socket_create_listen($port);
$close = socket_close($sock);

echo $close  === false ? socket_last_error() : "Socket closed";
?>