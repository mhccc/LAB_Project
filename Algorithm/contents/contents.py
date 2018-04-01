# -*- coding: utf8 -*-
import sys
import pprint
import pymongo
from operator import eq
from bson import ObjectId

#커넥션 생성
connection = pymongo.MongoClient('localhost', 27017)
db = connection.Health_One



#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 keyword_set 컬렉션을 순회하며 해당되는 pagerank 도큐먼트를 추출
def contents(survey_string, category_string):
    #추출된 pagerank 도큐먼트를 저장할 리스트
    pagerank_docs = []
    #link 도큐먼트를 저장할 딕셔너리
    link_doc = {}
    #link 도큐먼트들의 리스트를 저장할 리스트를
    result = []

    try:
        #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
        for keywordset_doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
            id = keywordset_doc['_id']
            category_index = keywordset_doc['category_index']
            survey_index = keywordset_doc['survey_index']
            scope = extract(keywordset_doc['scope'])
            keyword_title = keywordset_doc['keyword_title']
            keyword_list = keywordset_doc['keyword_list']
            last_update = keywordset_doc['last_update']

            #category_string이 1인 항목만 추출
            if eq(category_string[category_index], '1'):
                #DB에 저장된 조건이 '=='일 때
                if eq(scope['operator'], '=='):
                    if int(survey_string[survey_index]) == int(scope['operand']):
                        pagerank_docs.append(db.pagerank.find_one({'keyword_title_id':id}))

                #DB에 저장된 조건이 '<='일 때
                elif eq(scope['operator'], '<='):
                    if int(survey_string[survey_index]) <= int(scope['operand']):
                        pagerank_docs.append(db.pagerank.find_one({'keyword_title_id':id}))

                #DB에 저장된 조건이 '>='일 때
                elif eq(scope['operator'], '>='):
                    if int(survey_string[survey_index]) >= int(scope['operand']):
                        pagerank_docs.append(db.pagerank.find_one({'keyword_title_id':id}))

        #각 pagerank 도큐먼트가 담고있는 link들의 정보를 link 컬렉션에서 추출하여 JSON 형태로 반환
        for pagerank_doc in pagerank_docs:
            link_doc['id'] = pagerank_doc['_id']
            link_doc['keyword_title'] = db.keyword_set.find_one({'_id':pagerank_doc['keyword_title_id']})['keyword_title']
            link_doc['new1'] = db.link.find_one({'_id':pagerank_doc['new1_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['new2'] = db.link.find_one({'_id':pagerank_doc['new2_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['top1'] = db.link.find_one({'_id':pagerank_doc['top1_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['top2'] = db.link.find_one({'_id':pagerank_doc['top2_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['top3'] = db.link.find_one({'_id':pagerank_doc['top3_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['top4'] = db.link.find_one({'_id':pagerank_doc['top4_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['top5'] = db.link.find_one({'_id':pagerank_doc['top5_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['ran1'] = db.link.find_one({'_id':pagerank_doc['ran1_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            link_doc['ran2'] = db.link.find_one({'_id':pagerank_doc['ran2_id']}, {'_id':0, 'title':1, 'url':1, 'hit':1})
            result.append(link_doc)

        print({'code': 100, 'msg': 'True', 'result': result})
        return {'code' : 100, 'msg' : 'True', 'result': result}

    except:
        print({'code': 1, 'msg': 'False'})
        return {'code': 1, 'msg': 'False'}



if __name__=='__main__':
    contents(sys.argv[1], sys.argv[2])
