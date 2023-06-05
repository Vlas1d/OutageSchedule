<?php
    $servername ="localhost";
    $username ="vlasid_admin";
    $password = "vlasid_admin_password";
    $dbname ="outagescheduledb";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Відкриття файлу SQL
        $sqlFile = file_get_contents('database/outagescheduledb.sql');
    
        // Виконання SQL-запиту
        $conn->exec($sqlFile);
    
    } catch(PDOException $e) {
    }
    

//-----------------------------------------------------------------------------------------------------
$timeData = array();


if($_GET['subqueue'] == null) {
    $subqueue = 1;
}
else {
    $subqueue = $_GET['subqueue'];
}
if($_GET['date'] == null) {
    $date = '2023-02-01';
}
else {
    $date = $_GET['date'];
}

$sql = "SELECT * FROM power_outages JOIN dates ON power_outages.id_date = dates.id WHERE dates.date = '$date' AND power_outages.id_subqueue = '$subqueue'";
$result = $conn->query($sql);


while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $timeData[] = $row;
}

$jsonData = json_encode($timeData);

echo $jsonData;


//-------------------------------------------------------------------------------------------------
?>