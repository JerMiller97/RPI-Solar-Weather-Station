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

$sql = "SELECT date,temperature FROM `outside_temperature` WHERE `temp_id` > (SELECT MAX(temp_id) from `outside_temperature`)-577 ORDER BY `outside_temperature`.`temp_id` ASC";

$result = $conn->query($sql);
echo "\"Date\",\"Outside Temperature\"";
while($row  = $result->fetch_assoc()){
    echo "\n\"".$row['date']."\",\"" . $row['temperature']."\"";
  }

$conn->close();
?> 