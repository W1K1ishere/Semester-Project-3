import network
import time
import json
from umqtt.simple import MQTTClient
import sensor_config

wlan = network.WLAN(network.STA_IF)
def connect_wifi():
    if not wlan.isactive():
        wlan.active(True)
    if not wlan.isconnected():
        wlan.connect(sensor_config.WIFI_SSID, sensor_config.WIFI_PASSWORD)
        while not wlan.isconnected():
            time.sleep(0.3)
    return wlan.ifconfig()[0]
def connect_mqtt():
    client = MQTTClient(sensor_config.CLIENT_ID,
                        sensor_config.BROKER_IP,
                        port=1883)
    client.connect()
    return client
def send_payload(client, temp, hum):
    payload = json.dumps({"temp": temp, "hum": hum})
    client.publish(sensor_config.TOPIC, payload)
    print("Sent:", payload)

