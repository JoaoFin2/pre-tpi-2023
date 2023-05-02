from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from datetime import datetime
import time
import pytz
import requests
import os

options = webdriver.ChromeOptions()
options.add_argument('--no-sandbox')
options.add_argument('--headless')
options.add_argument('--disable-dev-shm-usage')

driver = webdriver.Chrome(options=options)

timezone = pytz.timezone('Europe/Paris')
now = datetime.now(timezone)
date = now.strftime("%Y-%m-%d %H:%M:%S")

api_url = os.environ['API_URL']
wind_url = os.environ['WIND_URL']
temp_url = os.environ['TEMP_URL']
precip_url = os.environ['PRECIP_URL']
div_class = os.environ['DIV_CLASS']
value_class = os.environ['VALUE_CLASS']

driver.get(wind_url)
driver.execute_script("location.reload()")


def extract_value(driver, label, unit):
    time.sleep(1)

    div = driver.find_element(By.XPATH, div_class)
    value = div.find_element(By.XPATH, value_class)
    value = float(value.text.split()[0]) 

    print(f"{label}: {value}{unit} {date}")

    return value


wind = extract_value(driver, "Vitesse du vent", "km/h")

button = driver.find_element(By.CSS_SELECTOR, 'label[for="pill_subParams1"]')
button.click()

gust = extract_value(driver, "Raffale", "km/h")


driver.get(temp_url)
driver.execute_script("location.reload()")

temp = extract_value(driver, "Température", "°")


driver.get(precip_url)
driver.execute_script("location.reload()")

precip = extract_value(driver, "Précipitation", "mm")

driver.close()


data = {
    'wind': wind,
    'gust': gust,
    'temperature': temp,
    'precipitation': precip,
    'date' : date
}

response = requests.post(api_url, data=data)

if response.status_code == 201:
    print('Données insérées avec succès')
else:
    print('Erreur lors de l\'insertion des données')
    print(response.text)
