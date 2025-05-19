<?php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "dbms_mypham",
    "Uid" => "phuongtuan",
    "PWD" => "phuongtuan2312@",
    "CharacterSet" => "UTF-8"
);
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    // echo "Kết nối thành công";
}
?>