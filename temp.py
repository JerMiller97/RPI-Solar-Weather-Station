#!/usr/bin/env python
import time
import re
from datetime import datetime
import requests

def get_temperature():
    temp_file = open("/sys/bus/w1/devices/28-3c01d6074873/w1_slave","r")

    temp_file = temp_file.read()

    yes_check = re.search("(YES)",temp_file)
    if yes_check:
        temp_check = re.search("t=([0-9]{3,5})",temp_file)
        if temp_check:
	    temp_c = float(temp_check.group(1))/1000
            temp_f = (temp_c * 1.8) + 32
            return temp_f

now = datetime.now()
temp = get_temperature()
now_time = now.strftime("%d/%m/%Y %H:%M")
log_line = open("temp.csv", "a")
log_line.write(str(temp) + "," + now_time + "\n")
log_line.close()
now_datetime = now.strftime("%Y-%m/%d %H:%M")
params = (
    ('date', str(now_datetime)),
    ('temp', str(temp)),
)

response = requests.post('http://192.168.88.50/RPI-Solar-Weather-Station/temp_insert.php', params=params, timeout=30)
print response.text
print str(temp) + "," + now_time
#time.sleep(10)
