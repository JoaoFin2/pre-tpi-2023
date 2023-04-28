from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

options = webdriver.ChromeOptions()
options.add_argument('--no-sandbox')
options.add_argument('--headless')
options.add_argument('--disable-dev-shm-usage')

driver = webdriver.Chrome(options=options)
wind_site = "https://www.meteosuisse.admin.ch/static/measured-values-app/index.html#lang=fr&param=messwerte-windgeschwindigkeit-kmh-10min&station=PRE&chart=hour"
temp_site = "https://www.meteosuisse.admin.ch/static/measured-values-app/index.html#lang=fr&param=messwerte-lufttemperatur-10min&chart=hour&station=PUY"
precip_site = "https://www.meteosuisse.admin.ch/static/measured-values-app/index.html#lang=fr&param=messwerte-niederschlag-10min&chart=hour&station=LSN"

driver.get(wind_site)
driver.execute_script("location.reload()")

def extract_value(driver):
    time.sleep(1)
    div = driver.find_element(By.XPATH, '//div[@class="measurement-map__detail-body"]')
    value = div.find_element(By.XPATH, './/div[@class="measurement-map__detail--value"]')
    return value.text


wind = extract_value(driver)
print("Vitesse du vent: " + wind)

button = driver.find_element(By.CSS_SELECTOR, 'label[for="pill_subParams1"]')
button.click()


gust = extract_value(driver)
print("Rafale: " + gust)

driver.get(temp_site)
driver.execute_script("location.reload()")
temp = extract_value(driver)
print("Température: " + temp)

driver.get(precip_site)
driver.execute_script("location.reload()")
precip = extract_value(driver)
print("Précipitation: " + precip)

driver.close()