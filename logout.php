<?php
session_start();
	session_destroy();
	header('Location: /rsd/login.php'); 
?>