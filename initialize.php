<?php

$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$dev_data = array('id'=>'-1','firstname'=>'ANAND','lastname'=>'','username'=>'dev_oretnom','password'=>'1234','last_login'=>'','date_updated'=>'','date_added'=>'');
if(!defined('base_url')) define('base_url',$root);
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
// if(!defined('dev_data')) define('dev_data',$dev_data);
if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME',"maizozvp_iq_vendor");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"maizozvp_iq_vendor");
if(!defined('DB_NAME')) define('DB_NAME',"maizozvp_iq_vendor");
?>