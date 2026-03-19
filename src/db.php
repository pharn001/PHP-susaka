<?php

$db = new mysqli('db','root','root123','php_test');

if ($db->connect_error) {
    die("Connect failed: " . $db->connect_error);
}

