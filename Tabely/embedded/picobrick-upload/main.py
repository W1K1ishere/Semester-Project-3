import time
import sensor_config
from sensor_reader import read_dht
from mqtt_client import connect_wifi, connect_mqtt, send_payload

def main():
    connect_wifi()
    client = connect_mqtt()
    while True:
        temp, hum = read_dht()

        if temp is not None:
            send_payload(client, temp, hum)
        else:
            print("Sensor error: no data")
        # sleep  timer
        for _ in range(sensor_config.SEND_INTERVAL):
            time.sleep(1)
main()

