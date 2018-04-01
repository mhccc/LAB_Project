# -*- coding: utf8 -*-
import pymongo
import operator
import time
import random

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
linkc = db.link
keyword_setc = db.keyword_set
scorec = db.score
pagerankc = db.pagerank

# 페이지랭크, 수치들의 합을 링크 아이디와 score 컬렉션에 저장, score와 date를 정렬하여 키워드셋 제목 아이디와 함께 pagerank 컬력센에 저장(new1 ~ new2, top1 ~ top5, ran1 ~ ran2)
def pagerank(keyword_title):
    try:
        # keyword_title을 받아 keyword_title_id를 찾음
        keyword_data = keyword_setc.find_one({"keyword_title":keyword_title})
        keyword_title_id = keyword_data["_id"]

        # keyword_title_id에 해당하는 링크들을 찾음
        link_data = linkc.find({"keyword_title_id":keyword_title_id})

        # 정렬을 위한 딕셔너리
        link_score_date = {}

        # 찾은 링크들의 키워드수,조회수,페로몬값을 계산하여 score컬렉션에 저장, 딕셔너리에 link_id와 mktime(date_split)을 저장
        for data in link_data:
            # 해당 링크가 score컬렉션에 이미 존재하면 삭제 -> 최신 score 업데이트
            scorec.remove({"link_id":data["_id"]})

            scorec.insert({"link_id":data["_id"],"keyword_title_id":data["keyword_title_id"],"score":(data["hit"] * 2) + (data["key_score"] * 2) + (data["pheromone"] * 2)})

            date_split = data["date"].split("-")

            link_score_date[data["_id"]] = [time.mktime((int(date_split[0]),int(date_split[1]),int(date_split[2]),0,0,0,0,0,0))]

        # score 컬렉션 조회
        score_data = scorec.find({"keyword_title_id":keyword_title_id})

        # 딕셔너리에 score를 저장
        for data in score_data:
            link_score_date[data["link_id"]].append(data["score"])

        # 딕셔너리를 mktime(date_split) 기준으로 정렬
        link_score_date = sorted(link_score_date.items(), key=operator.itemgetter(1), reverse=True)

        # 해당 분류가 pagerank컬렉션에 이미 존재하면 삭제 -> 최신 rank 업데이트
        pagerankc.remove({"keyword_title_id":keyword_title_id})

        # pagerank 컬렉션 생성
        pagerankc.insert({"keyword_title_id":keyword_title_id})
        
        # 변수명을 위한 정의
        no = 1

        try:
            # pagerank 컬렉션에 new1 ~ new2 저장
            for data in link_score_date:
                if no <= 2:
                    pagerankc.update({"keyword_title_id":keyword_title_id},{"$set":{"new" + str(no) + "_id":data[0]}})
                
                # top1 ~ top5 저장을 위한 순서 재배치
                [data][0][1].reverse()

                no += 1

            # new1 ~ new2 제외
            del(link_score_date[0:2])

            # 딕셔너리를 score 기준으로 정렬
            link_score_date = sorted(link_score_date, key=operator.itemgetter(1), reverse=True)

            # 변수명을 위한 정의 
            no = 1

            # pagerank 컬렉션에 top1 ~ top5 저장
            for data in link_score_date:
                if no <= 5:
                    pagerankc.update({"keyword_title_id":keyword_title_id},{"$set":{"top" + str(no) + "_id":data[0]}})

                no += 1

            # top1 ~ top5 제외
            del(link_score_date[0:5])

            # pagerank 컬렉션에 ran1 ~ ran2 저장
            for n in range(0,2):
                ran = random.randint(0,len(link_score_date)-1)

                pagerankc.update({"keyword_title_id":keyword_title_id},{"$set":{"ran" + str(n+1) + "_id":link_score_date[ran][0]}})

            print({'code' : 100, 'msg' : "True"})
            return {'code' : 100, 'msg' : "True"}

        except:
            print({'code' : 101, 'msg' : "No link", 'keyword_title' : keyword_title})
            #return {'code' : 101, 'msg' : "No link", 'keyword_title' : keyword_title}

    except:
        print({'code' : 1, 'msg' : "False", 'keyword_title' : keyword_title})
        #return {'code' : 1, 'msg' : "False", 'keyword_title' : keyword_title}

if __name__=='__main__':
    for data in keyword_setc.find():
        pagerank(data["keyword_title"])
        