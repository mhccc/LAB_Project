import datetime
import requests
import pymongo
from bs4 import BeautifulSoup as bs
headers = {
    'Accept-Encoding': 'gzip, deflate, sdch',
    'Accept-Language': 'en-US,en;q=0.8',
    'Upgrade-Insecure-Requests': '1',
    'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Cache-Control': 'max-age=0',
    'Connection': 'keep-alive',
}
dt=datetime.datetime.now() #시간설정

#connection = pymongo.MongoClient("localhost",27017)
#Health_One = connection.DB
#collection = Health_One.URLCollection
#DB내용 출력테스트시 5~7번 28~29번 주석처리 필요

def get_google_search(query,query2,query3):
    for pages in range(0,6): #다음페이지를 위한 for문
        geturl=(f'https://www.google.co.kr/search?source=hp&q={query}OR{query2}&start={pages}0')
        r=requests.get(geturl, headers=headers, allow_redirects=False)
        html = r.text
        soup = bs(html, 'html.parser')

        titles=soup.select('h3.r')
        no=1
        print(geturl)
        for title in titles:
            try:
                date=dt.strftime("%Y %B %d.")
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
                #w3=w2.count(query3)
                #collection.insert({"no":no,"title":title.text,"url":link2,"key_score":w3,"date":date})

                print(title.text)
                print(link2)
                print(w2.count(query3))
                print(date)
                print(no)
            except:
                print("could not open %s" % title)
                continue

def get_word_count(url,query):
    r2=requests.get(url)
    html2=r2.text
    soup2=bs(html2,'html.parser')
    w=soup2
    w.count(query)

if __name__=='__main__':
    get_google_search('치질에 좋은음식','유방암에 좋은음식','치질')