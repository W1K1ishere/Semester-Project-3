import time
import json
import network
from machine import Pin, I2C
from picobricks import SSD1306_I2C, SHTC3
from umqtt.simple import MQTTClient

#name of network
name = "WiFi6753ajd"
#password from network
password = "LNUyX7xqv"
#ip of device which is listening
device_id = "192.168.1.188"
#don't touch this please
connection = b"pico-measurements"
#department name for database
picoId = "test"


wlan = network.WLAN(network.STA_IF)
wlan.active(True)
wlan.connect(name, password)
while not wlan.isconnected():
    time.sleep(1)

mqtt = MQTTClient(picoId, device_id, port=1883)
mqtt.connect()

i2c = I2C(0, scl=Pin(5), sda=Pin(4))
oled = SSD1306_I2C(128, 64, i2c, addr=0x3c)
sensor = SHTC3(i2c)

counter = 0
while True:
    t = sensor.temperature()
    h = sensor.humidity()

    oled.fill(0)
    oled.text(str(t) + " °C", 0, 0)
    oled.text(str(h) + " %", 0, 20)
    oled.show()
    
    if counter >= 60:
        measurements = json.dumps({
            "device": picoId,
            "temperature": t,
            "humidity": h
        })
        mqtt.publish(connection, measurements)
        counter = 0
    
        
    counter += 1
    time.sleep(2)
