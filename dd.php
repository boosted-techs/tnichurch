<?php
//session_save_path("/tmp");
session_start();
$_SESSION['id'] = 89;
print_r($_SESSION);