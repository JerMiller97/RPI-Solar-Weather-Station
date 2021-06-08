<?php
$servername = "localhost";
$username = "rpi";
$password = "JbdqGIF8oRZPjDEjysr";
$dbname = "weather_station";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT date,charge_level FROM `battery_status` ORDER BY `battery_status`.`status_id` ASC LIMIT 432";
$result = $conn->query($sql);
echo "\"Date\",\"Charge Level\"";
while($row  = $result->fetch_assoc()){
    echo "\n\"".$row['date']."\",\"" . $row['charge_level']."\"";
  }


$conn->close();
?> 