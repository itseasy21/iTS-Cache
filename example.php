<?php
include "itscache.class.php";

$path = 'cache/'; // Set Cache path ! Do not forget '/'
$cache_adv = new itscache;
$cache_name='page1'; // set name for cache
$cache_time = '3600'; // (3600s = 1h :D )
if ($cache_adv -> start ($cache_name,$cache_time,$path)) {

///my normal page content here to be cached
$cache_adv -> build ($path);
}
?>
