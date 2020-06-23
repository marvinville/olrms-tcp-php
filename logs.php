<?php
include "database/connect.php";
require "database/model.php";

$db = new DB_Model();

$rows = $db->read($conn, 'gprs', 'id DESC', '200');
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/app.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OLRMS TCP</title>
</head>

<body>
    <div class='no-more-tables'>
        <table width=100% class='table-bordered table-striped'>
            <thead>
                <th>Remote Address</th>
                <th>Port</th>
                <th>GPRS Data</th>
                <th>Received</th>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                ?>
                    <tr>
                        <td data-title='Remote Address'><?php echo $row->remote_address; ?></td>
                        <td data-title='Port'><?php echo $row->remote_port; ?></td>
                        <td data-title='GPRS Data'><?php echo $row->gprs_data; ?></td>
                        <td data-title='Received'><?php echo $row->date_created; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>