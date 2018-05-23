import datetime
import requests
import pymongo
from bs4 import BeautifulSoup as bs

headers = {
    'Accept-Encoding': 'gzip, deflate, sdch',
    'Accept-Language': 'ko-KR,ko;q=0.8',
    'Upgrade-Insecure-Requests': '1',
    'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Cache-Control': 'max-age=0',
    'Connection': 'keep-alive',
}
dt = datetime.datetime.now()  # 시간설정

connection = pymongo.MongoClient("localhost", 27017)
db = connection.Health_One
collection = db.link


# DB내용 출력테스트시 5~7번 28~29번 주석처리 필요

def get_google_search():
    try:
        for keywordset_doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
            keyword_list = keywordset_doc['keyword_list']
            keyword_title = keywordset_doc['keyword_title']
            keyword_title_id = keywordset_doc['_id']

            googleUrl = f'https://www.google.co.kr/search?source=hp&q='
            for keyword in keyword_list:
                googleUrl += (keyword + 'OR')
            googleUrl += (keyword)

            for pages in range(0, 6):  # 다음페이지를 위한 for문
                geturl = (f'{googleUrl}&start={pages}0')  # 크롤링할 url설정
                r = requests.get(geturl, headers=headers, allow_redirects=False)  # header를 적용한 크롤링 r에 저장
                html = r.text
                soup = bs(html, 'html.parser')  # 25-26 크롤링 구문

                titles = soup.select('h3.r')  # 주요 검색 부분인 h3, r태그 저장

                print(geturl)
                for title in titles:  # 각 부분별 크롤링(하나의 링크마다 반복됨)
                    try:
                        date = dt.strftime("%Y-%m-%d")  # 날짜
                        link = title.a['href']
                        a = link.find('http:/')
                        b = link.find('&')
                        link2 = link[a:b]  # 34-37 크롤링된 링크url중 불필요 부분 제거
                        r2 = requests.get(link2)
                        html2 = r2.text
                        soup2 = bs(html2, 'html.parser')
                        w = soup2
                        w2 = str(w)  # 단어카운팅을 위한 부분
                        w3 = w2.count(keyword_title)
                        # collection.findOneAndUpdate({"title":title.text,"url":link2,"key_score":w3,"date":date}, upsert=True)
                        check = collection.find_one({"url": link2})
                        if check != link2:
                            collection.insert({'title': title.text, 'url': link, 'key_score': w3, 'date': date,
                                               'keyword_title_id': keyword_title_id, 'hit': 1, 'pheromone': 1.0,
                                               'like': 0})  # findOneAndUpdate오류 발생시 사용
                        elif check == None:
                            collection.insert({'title': title.text, 'url': link, 'key_score': w3, 'date': date,
                                               'keyword_title_id': keyword_title_id, 'hit': 1, 'pheromone': 1.0,
                                               'like': 0})
                        print(check)
                        print(title.text)
                        print(link)
                        print(link2)
                        print(w2.count(keyword_title))
                        print(date)

                    except:
                        print("could not open %s" % title)
                        continue

        print({'code': 100, 'msg': "크롤링이 완료되었습니다."})

    except:
        print({'code': 1, 'msg': "오류가 발생하였습니다."})


def get_word_count(url, query):
    r2 = requests.get(url)
    html2 = r2.text
    soup2 = bs(html2, 'html.parser')
    w = soup2
    w.count(query)


if __name__ == '__main__':
    # for keywordset_doc in db.keyword_set.find().sort('survey_index',pymongo.ASCENDING):
    #   keyword_list = keywordset_doc['keyword_list']
    #  keyword_title = keywordset_doc['keyword_title']
    get_google_search()
