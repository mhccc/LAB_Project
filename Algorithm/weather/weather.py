import os
import sys
import json
import urllib.request
from bs4 import BeautifulSoup
from pyowm import OWM

def get_weather(lat, lon):
	try:
		# owm api - 날씨
		# id : afewgm20@gmail.com
		# pw : afewgm.20
		# key : a5486ad8df5934ae8df439dae0f2bb9e
		owm_api_key = 'a5486ad8df5934ae8df439dae0f2bb9e'
		owm = OWM(owm_api_key)
		obs = owm.weather_at_coords(float(lat), float(lon))
		w = obs.get_weather()

		temperature = str(round(w.get_temperature(unit='celsius')['temp'])) + '˚C'
		status = w.get_status()
		#status = w.get_detailed_status()

		# google api - 주소 변환
		url = ("http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=ko&address=" + str(lat) + "," + str(lon))
		html = urllib.request.urlopen(url)
		soup = BeautifulSoup(html,"lxml")
		p_tag = soup.find('p')
		google_results = json.loads(p_tag.text)
		
		address = google_results['results'][0]['formatted_address']

		'''
		# naver api - 상태 변환
		# naver_id : kimjg0616
		# naver_pw : wlsrhkd123
		# key_id : W7VcmzK7THMgnOBJD_P6
		# key_secret : ELtRu0W0BY
		client_id = "W7VcmzK7THMgnOBJD_P6"
		client_secret = "ELtRu0W0BY"
		encText = urllib.parse.quote(w.get_status())
		data = "source=en&target=ko&text=" + encText
		url = "https://openapi.naver.com/v1/papago/n2mt"
		request = urllib.request.Request(url)
		request.add_header("X-Naver-Client-Id",client_id)
		request.add_header("X-Naver-Client-Secret",client_secret)
		response = urllib.request.urlopen(request, data=data.encode("utf-8"))
		rescode = response.getcode()
		response_body = response.read()
		naver_results = json.loads(response_body.decode('utf-8'))

		status = naver_results['message']['result']['translatedText']
		'''

		# 상태 변환, 날씨 이미지 url : http://openweathermap.org/img/w/$weather_img
		if status == 'Clear':
			status = '맑음'
			weather_img = '01d.png'
		elif status == 'Rain':
			status = '비'
			weather_img = '09d.png'
		elif status == 'Clouds':
			status = '구름'
			weather_img = '04d.png'
		elif status == 'Haze':
			status = '안개(연무)'
			weather_img = '03d.png'
		elif status == 'Mist':
			status = '안개(박무)'
			weather_img = '03d.png'
		elif status == 'Fog':
			status = '짙은 안개'
			weather_img = '03d.png'
		elif status == 'Snow':
			status = '눈'
			weather_img = '13d.png'
		elif status == 'Sand':
			status = '황사'
			weather_img = '50d.png'
		elif status == 'Dust':
			status = '먼지'
			weather_img = '50d.png'
		elif status == 'Thunderstorm':
			status = '뇌우'
			weather_img = '11d.png'
		elif status == 'Smoke':
			status = '연기'
			weather_img = '03d.png'
		elif status == 'Drizzel':
			status = '이슬비'
			weather_img = '10d.png'

		print({'code' : 100, 'msg' : "True", 'lat' : lat, 'lon' : lon, 'address' : address, 'status' : status, 'weather_img' : "http://openweathermap.org/img/w/" + weather_img, 'temperature' : temperature})
		#return {'code' : 100, 'msg' : "True", 'lat' : lat, 'lon' : lon, 'address' : address, 'status' : status, 'weather_img' : "http://openweathermap.org/img/w/" + weather_img, 'temperature' : temperature}

	except:
		print({'code' : 1, 'msg' : "False", 'lat' : lat, 'lon' : lon})
		get_weather(sys.argv[1] ,sys.argv[2])
		#return {'code' : 1, 'msg' : "False", 'lat' : lat, 'lon' : lon}

if __name__=='__main__':
	try:
		if sys.argv[3] != "":
			print({'code' : 2, 'msg' : "False"})
			#return {'code' : 2, 'msg' : "False"}

	except:
		try:
			get_weather(sys.argv[1] ,sys.argv[2])
		
		except:
			print({'code' : 2, 'msg' : "False"})
			#return {'code' : 2, 'msg' : "False"}
			