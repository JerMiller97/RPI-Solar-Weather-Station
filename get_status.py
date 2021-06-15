#!/usr/bin/python3
from pijuice import PiJuice # Import pijuice module
import time
import re
from datetime import datetime
import json 
import requests

pijuice = PiJuice(1, 0x14) # Instantiate PiJuice interface object
#print(pijuice.status.GetStatus()) # Read PiJuice status.

def get_battery_level():
    data_block = pijuice.status.GetChargeLevel()

    battery_level = data_block.get('data')
    return battery_level
def get_status():
    data_block = pijuice.status.GetStatus()

    data_block = data_block.get('data')
    battery_status = data_block.get('battery')
    return battery_status

now = datetime.now()
battery_level = get_battery_level()
battery_status = get_status()
now_time = now.strftime("%Y-%m-%d %H:%M")
log_line = open("battery_log.csv", "a")
log_line.write(str(battery_level) + "," + now_time + "\n")
log_line.close()

now_datetime = now.strftime("%Y-%m-%d %H:%M")
params = (
    ('date', str(now_datetime)),
    ('charge', str(battery_level)),
    ('batt_status', str(battery_status)),

)

response = requests.post('http://192.168.88.50/RPI-Solar-Weather-Station/batt_insert.php', params=params, timeout=30)

print(str(battery_level) + "," + now_time)
print(pijuice.status.GetChargeLevel())
