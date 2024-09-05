<?php
ob_start();
ini_set('date.timezone','Asia/Kolkata');
date_default_timezone_set('Asia/Kolkata');
session_start();

require_once( "image-resize/ImageResize.php");
require_once("image-resize/ImageResizeException.php");
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');
$db = new DBConnection;
$conn = $db->conn;
function redirect($url=''){
	if(!empty($url))
	echo '<script>location.href="'.base_url .$url.'"</script>';
}
function validate_image($url,$gender){
	if(!empty($url)){
			// exit;
        $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200')) {
        return $url; // Image exists
    }
}
    $url=($gender=='Male')?base_url.'uploads/male.jpg':'uploads/female.jpg';
    return $url; 
}
function format_num($number = '' , $decimal = ''){
    if(is_numeric($number)){
        $ex = explode(".",$number);
        $decLen = isset($ex[1]) ? strlen($ex[1]) : 0;
        if(is_numeric($decimal)){
            return number_format($number,$decimal);
        }else{
            return number_format($number,$decLen);
        }
    }else{
        return "Invalid Input";
    }
}
function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800);          // 7*24*60*60;
    $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
    if ($seconds <= 60) {
        return "just now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 " . "minute ago";
        } else {
            return "$minutes " . "minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 " . "hour_ago";
        } else {
            return "$hours " . "hours ago";
        }
    } else if ($days <= 30) {
        if ($days == 1) {
            return "1 " . "day_ago";
        } else {
            return "$days " . "days ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "1 " . "month ago";
        } else {
            return "$months " . "months ago";
        }
    } else {
        if ($years == 1) {
            return "1 " . "year ago";
        } else {
            return "$years " . "years ago";
        }
    }
}

ob_end_flush();
?>