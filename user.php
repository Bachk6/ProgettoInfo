<?php 
session_start();
include("SQLconnect.php");
CheckUser(array('admin','client'));
?>