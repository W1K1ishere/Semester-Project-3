import time
from machine import Pin, I2C
import dht

from ssd1306 import SSD1306_I2C


i2c = I2C(0, scl=Pin(5), sda=Pin(4), freq=400_000)
oled = SSD1306_I2C(128, 64, i2c)

sensor = dht.DHT22(Pin(15))


def read_humidity() -> float | None:
    try:
        sensor.measure()
        return sensor.humidity()
    except OSError:
        return None


def show_text(line1: str, line2: str = "") -> None:
    oled.fill(0)
    oled.text(line1, 0, 0)
    if line2:
        oled.text(line2, 0, 16)
    oled.show()


show_text("booting...", "give me a sec")
time.sleep(1)

while True:
    hum = read_humidity()
    if hum is None:
        show_text("sensor error :(", "check wiring")
    else:
        show_text("room humidity:", f"{hum:.1f}%")

    time.sleep(2)


