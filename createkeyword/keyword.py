# -*- coding: utf8 -*-

import pymongo
import json
from operator import eq
from pymongo import MongoClient

#커넥션 생성
connection = MongoClient('localhost', 27017)
db = connection.Health_One

#진단결과로 추출된 키워드 리스트
result_keyword_list = []


#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}
#MongoDB에서 키워드리스트 추출
def create_keyword_list(survey_string, category_string):
    #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
    for doc in db.keyword_set.find().sort('index', pymongo.ASCENDING):
        index = doc['index']
        scope = extract(doc['scope'])
        keyword_list = doc['keyword_list']

        #DB에 저장된 조건이 '=='일 때
        if eq(scope['operator'], '=='):
            if int(survey_string[index]) == int(scope['operand']):
                result_keyword_list.append(keyword_list)

        #DB에 저장된 조건이 '<='일 때
        elif eq(scope['operator'], '<='):
            if int(survey_string[index]) <= int(scope['operand']):
                result_keyword_list.append(keyword_list)

        #DB에 저장된 조건이 '>='일 때
        elif eq(scope['operator'], '>='):
            if int(survey_string[index]) >= int(scope['operand']):
                result_keyword_list.append(keyword_list)

    #키워드셋 리스트 리턴
    return result_keyword_list


#MongoDB에 키워드 추가
def insert_keyword_list(index, scope, keyword):
    #매개변수 인덱스와 스코프에 해당하는 도큐먼트에 키워드를 추가 (만족하는 도큐먼트 없으면 토큐먼트를 생성)
    db.keyword_set.update_many({'$and':[{'index':index}, {'scope':scope}]}, {'$push':{'keyword_list':keyword}}, upsert=True)


insert_keyword_list(10, "==1", "테스트키워드1")
