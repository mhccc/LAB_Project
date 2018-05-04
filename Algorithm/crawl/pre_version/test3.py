import datetime
import requests
import pymongo
from bs4 import BeautifulSoup as bs

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
collection = db.link
link2="blog.naver.com"
check = collection.find_one({"url":link2})
print(check)
title="test"
w3=3
date=4
keyword_title_id=45
if check != link2:
    collection.insert({'title': title, 'url': link2, 'key_score': w3, 'date': date, 'keyword_title_id': keyword_title_id,  'hit': 1, 'pheromone': 1.0})    #findOneAndUpdate오류 발생시 사용
elif check == None:
    collection.insert({'title': title, 'url': link2, 'key_score': w3, 'date': date,'keyword_title_id': keyword_title_id, 'hit': 1, 'pheromone': 1.0})