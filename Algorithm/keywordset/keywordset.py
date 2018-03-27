# -*- coding: utf8 -*-
import sys
import datetime
import requests
import pymongo
from operator import eq
from bs4 import BeautifulSoup as bs

#커넥션 생성
connection = pymongo.MongoClient('localhost', 27017)
db = connection.Health_One
#시간설정
dt=datetime.datetime.now()
#헤더 초기화
headers = {
    'Accept-Encoding': 'gzip, deflate, sdch',
    'Accept-Language': 'en-US,en;q=0.8',
    'Upgrade-Insecure-Requests': '1',
    'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Cache-Control': 'max-age=0',
    'Connection': 'keep-alive',
}



#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 전체키워드리스트 추출
def keywordset(survey_string, category_string):

    #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
    for doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
        category_index = doc['category_index']
        survey_index = doc['survey_index']
        scope = extract(doc['scope'])
        keyword_title = doc['keyword_title']
        keyword_list = doc['keyword_list']

        #category_string이 1인 항목만 추출
        if eq(category_string[category_index], '1'):
            #DB에 저장된 조건이 '=='일 때
            if eq(scope['operator'], '=='):
                if int(survey_string[survey_index]) == int(scope['operand']):
                    get_google_search(keyword_list, keyword_title)

            #DB에 저장된 조건이 '<='일 때
            elif eq(scope['operator'], '<='):
                if int(survey_string[survey_index]) <= int(scope['operand']):
                    get_google_search(keyword_list, keyword_title)

            #DB에 저장된 조건이 '>='일 때
            elif eq(scope['operator'], '>='):
                if int(survey_string[survey_index]) >= int(scope['operand']):
                    get_google_search(keyword_list, keyword_title)


def google_search():
    #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
    for doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
        id = doc['_id']
        keyword_title = doc['keyword_title']
        keyword_list = doc['keyword_list']

        #크롤링 URL에 키워드 설정
        googleUrl = f'https://www.google.co.kr/search?source=hp&q='
        for keyword in keyword_list[:-1]:
            googleUrl += (keyword+'OR')
        googleUrl += (keyword_list[-1])

        #다음페이지를 위한 for문
        for pages in range(0,6):
            geturl=(googleUrl + '&start={pages}0')
            r = requests.get(geturl, headers=headers, allow_redirects=False)
            html = r.text
            soup = bs(html, 'html.parser')

            titles = soup.select('h3.r')
            no = 1
            print(geturl)
            for title in titles:
                try:
                    date = dt.strftime("%Y-%m-%d")
                    link = title.a['href']
                    a = link.find('http:/')
                    b = link.find('&')

                    link2 = link[a:b]
                    no = no + 1
                    r2 = requests.get(link2)
                    html2 = r2.text
                    soup2 = bs(html2, 'html.parser')
                    w = soup2
                    w2 = str(w)
                    w3 = w2.count(keyword_title)

                    db.link.insert({"no":no, "title":title.text, "url":link2, "key_score":w3, "date":date, "keyword_title_id":id, "hit":0, "pheromone":1.0})
                except:
                    print("could not open %s" % title)
                    continue

def get_word_count(url, query):
    r2 = requests.get(url)
    html2 = r2.text
    soup2 = bs(html2,'html.parser')
    w = soup2
    w.count(query)



#if __name__=='__main__':
#    keywordset(sys.argv[1], sys.argv[2])
google_search()
