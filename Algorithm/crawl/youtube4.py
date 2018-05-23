import datetime
import pymongo
from bs4 import BeautifulSoup as bs
import requests

dt = datetime.datetime.now() #시간설정

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
collection = db.youtubelink

def get_youtube_search():
    try:
        for keywordset_doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
            keyword_list = keywordset_doc['keyword_list']
            keyword_title = keywordset_doc['keyword_title']
            keyword_title_id = keywordset_doc['_id']

            youtubeUrl=f'https://www.youtube.com/results?search_query='
            for keyword in keyword_list:
                youtubeUrl += (keyword+'OR')
            youtubeUrl += (keyword)

            r=requests.get(youtubeUrl)
            html = r.text
            soup = bs(html,'html.parser')
            links = soup.findAll('div', attrs={'class':'yt-lockup-dismissable'})

            for link in links:
                img_src=link.find('img')['src']
                title=link.find('h3').find('a')['title']
                video_src=link.find('h3').find('a')['href']
                date = dt.strftime("%Y-%m-%d")
                youtube_check = collection.find_one({"url":video_src})
                if youtube_check == video_src:
                    continue
                elif youtube_check == None:
                    collection.insert({'title': title, 'url': video_src, 'img_src': img_src, 'date': date,'keyword_title_id': keyword_title_id, 'keyword_title': keyword_title, 'pheromone_m':0.0})
                print(title)
                print(video_src)
                print(img_src)
            print({'code': 100, 'msg': "크롤링이 완료되었습니다."})
    except:
        print({'code': 1, 'msg': "오류가 발생하였습니다."})

if __name__=='__main__':
    get_youtube_search()
