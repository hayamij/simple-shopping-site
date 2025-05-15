<?php
$serverName = "localhost"; // or your desktop name
$connectionOptions = array(
    "Database" => "yourdatabase",
    "Uid" => "sa",
    "PWD" => "password",
    "CharacterSet" => "UTF-8"
);
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    // echo "Kết nối thành công";
}
?>
