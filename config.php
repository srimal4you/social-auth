<?php
session_start();

$base_path = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

define('BASE_URL', $base_path);
