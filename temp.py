#!/usr/bin/env python3
import time
import re
from datetime import datetime
import requests
import json
import pytz

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
now_time = now.strftime("%Y-%m-%d %H:%M")
log_line = open("temp.csv", "a")
log_line.write(str(temp) + "," + now_time + "\n")
log_line.close()
now_datetime = now.strftime("%Y-%m-%d %H:%M")
params = (
    ('date', str(now_datetime)),
    ('temp', str(temp)),
)

response = requests.post('http://192.168.88.50/RPI-Solar-Weather-Station/temp_insert.php', params=params, timeout=30)
print (response.text)
print (str(temp) + "," + now_time)
#time.sleep(10)

local = pytz.timezone("America/Los_Angeles")
local_dt = local.localize(now, is_dst=None)
utc_dt = local_dt.astimezone(pytz.utc)

now_datetime_elastic = utc_dt.strftime("%Y-%m-%dT%H:%M:00Z")

data = {
    "datetime": str(now_datetime_elastic),
    "temperature": temp
}
data = json.dumps(data)
print (data)
headers = {'Content-type': 'application/json'}

response = requests.post('http://192.168.88.50:9200/outside_temperature/_doc/', data=data, timeout=30, headers=headers)
print (response.text)
