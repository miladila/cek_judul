<?php
error_reporting(~E_NOTICE);
session_start();

global $db;


include 'config.php';
include 'include/db.php';
include 'include/general.php';
$db = new DB($config['server'], $config['user'], $config['password'], $config['database_name']);

$modules = $_GET['mod'];
$action = $_GET['act'];

?>