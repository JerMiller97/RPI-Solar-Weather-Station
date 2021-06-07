<html>
<style>
body {
  text-align: center;
  font-size: 50px;

}

</style>
</html>

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

$sql = "SELECT * FROM `outside_temperature` ORDER BY `outside_temperature`.`date` DESC limit 1";
$result = $conn->query($sql);

while($row  = $result->fetch_assoc()){
    echo $row['temperature']."°F at " . $row['date'];
  }

echo "</br>";
$sql = "SELECT * FROM `battery_status` ORDER BY `battery_status`.`date` DESC limit 1";
$result = $conn->query($sql);

while($row  = $result->fetch_assoc()){
    echo $row['charge_level']."% charged at " . $row['date'];
  }


$conn->close();
?> 