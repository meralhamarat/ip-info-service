<?php
include("Ip.php");

if(isset($_GET['ip']) && $_GET['ip']){
    $ip = $_GET['ip'];
} else{
    $ip = $_SERVER['REMOTE_ADDR'];
}

$service = new Ip($ip);
$response = $service->info();
$data = json_decode($response, true);
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Alan</th><th>Değer</th></tr>";

if(is_array($data)){
    foreach($data as $key => $value){
        echo "<tr><td>".htmlspecialchars($key)."</td><td>".htmlspecialchars($value)."</td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>Veri alınamadı</td></tr>";
}
/*header('Content-Type:*/
echo "</table>";
