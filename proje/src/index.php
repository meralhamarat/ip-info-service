<?php
include("Ip.php");
if($_GET['ip']){
    $ip = $_GET['ip'];
} else{
    $ip = $_SERVER['REMOTE_ADDR'];
}

$service = new Ip($ip);
echo $service->getServiceUrl().PHP_EOL;
// Yukarıda getServiceUrl ile tanımlanmış servis ural adresi kullanılarak curl çağrılacak ve dönen json ifade ekrana echo edilecek.
echo $service->info().PHP_EOL;
