<?php
$sock = socket_create_listen(43556);
socket_getsockname($sock, $addr, $port);

echo $logs = "Server Listening on $addr:$port\n";

require "bin/helper.php";
include "database/connect.php";
require "database/model.php";

$db = new DB_Model();

while ($c = socket_accept($sock)) {

   socket_getpeername($c, $raddr, $rport);
   $incoming = socket_read($c, 2048);

   $data = array(
      'remote_address' => $raddr,
      'remote_port' => $rport,
      'gprs_data' => $incoming
   );

   $db->insert('gprs', $data, $conn);

   $gps = explode(',', $incoming);
   $keyword = $gps[0];
   $imei = isset($gps[1]) ? $gps[1] : '';

   $logs .= "Received Connection from $raddr:$rport";
   $logs .= "\n";
   $logs .= $incoming;
   $logs .= "\n";

   if ($imei) {

      $lat = $gps[4];
      $lng = $gps[5];
      $network = $gps[16];

      $networkData = explode("|", $network);
      $mcc = $networkData[0];
      $mnc = $networkData[1];

      $payload = createGpsData($imei, $lat, $lng, $mcc, $mnc);

      echo $curlResult = curlData($payload);

      $logs .= $curlResult;
   }

   logData($logs);

   $msg = 'Reply';

   socket_write($c, $msg);
}
socket_close($sock);
