<?php
function createGpsData($imei, $lat, $lng, $mcc, $mnc)
{
    $today = date('Y-m-d H:i:s', strtotime('+8 hours'));

    $payload = array(
        'device_info' => array(
            "batt_level" => "",
            "dt" => array(
                array(
                    "date_time" => $today,
                )
            ),
            "imei" => $imei,
            "laccid" => array(
                array(
                    "cid" => "0",
                    "lac" => "0"
                )
            ),
            "latlng" => array(
                array(
                    "lat" => $lat,
                    "lng" => $lng,
                )
            ),
            "mac_address" => $imei,
            "mcc" => $mcc,
            "mnc" => $mnc,
        )
    );

    return json_encode($payload);
}

function curlData($payload)
{
    $url = 'http://gps.olrms.com/gps/getdeviceinfo';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $authHeader = md5('olrmsgps');

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Auth: ' . $authHeader,
        'Content-Type: application/json',
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return json_encode(
        array(
            'httpCode' => $httpCode,
            'result' => $result,
        )
    );
}

function logData($logs)
{
    $today = date('Y-m-d H:i:s', strtotime('+8 hours'));
    $date = date('Ymd');
    $logDir = 'txt';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $serverFile = fopen($logDir . '/server_' . $date . '.txt', 'a+');
    $logs .= "\n";
    $logs .= $today;
    $logs .= "\n";
    $logs .= "==================================================";
    $logs .= "\n";

    fwrite($serverFile, $logs);
    fclose($serverFile);
}
