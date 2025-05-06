<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'wows';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>