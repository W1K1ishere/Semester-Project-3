import dht
from machine import Pin
import sensor_config

if sensor_config.SENSOR_TYPE == "DHT22":
    sensor = dht.DHT22(Pin(sensor_config.SENSOR_PIN))
else:
    sensor = dht.DHT11(Pin(sensor_config.SENSOR_PIN))
def read_dht():
    try:
        sensor.measure()
        temp = sensor.temperature()
        hum = sensor.humidity()
        return float(temp), float(hum)
    except:
        return None, None

