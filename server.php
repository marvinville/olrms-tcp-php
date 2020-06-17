<?php
$sock = socket_create_listen(43556);
socket_getsockname($sock, $addr, $port);

echo $logs = "Server Listening on $addr:$port\n";

require "bin/helper.php";

while ($c = socket_accept($sock)) {
   
   socket_getpeername($c, $raddr, $rport);
   $incoming = socket_read($c, 2048);
   // $incoming = '$$A173,864507038087309,AAA,35,14.290400,120.903526,191122013724,A,10,14,35,71,0.9,129,8727455,42108959,515|2|0008|00000008,0200,0001|0000|0000|019A|0569,00000001,,3,,,424,328*3A';
   $gps = explode(',', $incoming);
   $keyword = $gps[0];
   
   $logs .= "Received Connection from $raddr:$rport";
   $logs .= "\n";
   $logs .= $incoming;
   $logs .= "\n";

   if ($keyword === '$$A173') {

      $imei = $gps[1];
      $lat = $gps[4];
      $lng = $gps[5];
      $network = $gps[16];

      $networkData = explode("|", $network);
      $mcc = $networkData[0];
      $mnc = $networkData[1];

      $payload = createGpsData($imei, $lat, $lng, $mcc, $mnc);

      echo $curlResult = curlData($payload);

      $logs.= $curlResult;
   }

   logData($logs);
   
   $msg = 'Reply';

   socket_write($c, $msg);
}
socket_close($sock);