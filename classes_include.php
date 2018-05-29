<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE); 
ob_start();
session_start();
//echo session_id();
extract($_GET);
extract($_POST);
ob_flush();

include_once("lib/ayar.php");
include_once("lib/libx.php");
include_once("s_cls/cls_forms.php");
include_once("s_cls/dbclass.php");
include_once("s_cls/sessions.php");

include_once("s_cls/cls_giris.php");

include_once("s_cls/cls_kullanicilar.php");

/**/
?>