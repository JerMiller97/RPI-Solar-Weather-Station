<html>
<title>Solar Weather Station Status</title>
<style>
body {
  text-align: center;
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

$sql = "SELECT * FROM `outside_temperature` ORDER BY `outside_temperature`.`temp_id` DESC limit 1";
$result = $conn->query($sql);

while($row  = $result->fetch_assoc()){
    echo "<h1>" . $row['temperature']."°F outside at " . $row['date'] . "</h1>";
  }

$sql = "SELECT * FROM `battery_status` ORDER BY `battery_status`.`status_id` DESC limit 1";
$result = $conn->query($sql);

while($row  = $result->fetch_assoc()){
    if ($row['batt_status'] == "CHARGING_FROM_IN") {
        $batt_status_text = "charging";
    }
    elseif ($row['batt_status'] == "NORMAL") {
        $batt_status_text = "<i>dis</i>charging";
    }
    else {
        $batt_status_text = "unknown";
    }
    echo "<h1>" . $row['charge_level']."% charged at " . $row['date'] . "</h1></br>";
    echo "Battery is currently <b>".$batt_status_text.".</b></br>";
  }


$conn->close();
?> 

<html>
<style type="text/css" media="screen">
  body, html {
    background-color: #f7f7f9;
  }
  </style>

</br>
<script src="http://192.168.88.50:3000/embed.js" data-charted="f5bccea"></script>
<script src="http://192.168.88.50:3000/embed.js" data-charted="aa8cb98"></script>
</html>