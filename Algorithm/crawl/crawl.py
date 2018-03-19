# -*- coding: utf8 -*-
import requests
import pymongo
from bs4 import BeautifulSoup as bs

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
collection = db.link 
#DB내용 출력테스트시 5~7번 28~29번 주석처리 필요

def get_google_search(query,query2,query3):
    r=requests.get(f'https://www.google.co.kr/search?source=hp&q={query}OR{query2}')
    html = r.text
    soup = bs(html, 'html.parser')

    titles=soup.select('h3.r')
    no=1
    for title in titles:
        link = title.a['href']
        a=link.find('http:/')
        b=link.find('&')
        link2=link[a:b]

        no=no+1
        r2 = requests.get(link2)
        html2 = r2.text
        soup2 = bs(html2, 'html.parser')
        w = soup2
        w2=str(w)
        w3=w2.count(query3)
        collection.insert({"url":link2,"title":title.text,"keyword_set_title_id":ObjectId("5a9ff01f33b689d9d546593f"),"key_score":w3,"hit":0,"pheromone":1.0,"date":"2018-03-07"})
        
        print(title.text)
        print(link2)
        print(w2.count(query3))
        print(no)

def get_word_count(url,query):
    r2=requests.get(url)
    html2=r2.text
    soup2=bs(html2,'html.parser')
    w=soup2
    w.count(query)

if __name__=='__main__':
    get_google_search('치질에 좋은음식','유방암에 좋은음식','치질')
    