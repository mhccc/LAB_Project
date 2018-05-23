# -*- coding: utf8 -*-

import pymongo
import json
from operator import eq
from pymongo import MongoClient

#커넥션 생성
connection = MongoClient('localhost', 27017)
db = connection.Health_One





#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 전체키워드리스트 추출
def create_keyword_list(survey_string, category_string):
    #키워드가 저장 될 리스트
    result_keyword_list = []

    #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
    for doc in db.keyword_set.find().sort('index', pymongo.ASCENDING):
        category = doc['category']
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



#MongoDB에 키워드를 추가
def insert_keyword_list(category, index, scope, keywords):
    #매개변수 인덱스와 스코프에 해당하는 도큐먼트에 키워드를 추가 (해당하는 도큐먼트 없으면 토큐먼트를 새로 생성)
    db.keyword_set.update({'$and':[{'category':category}, {'index':index}, {'scope':scope}]}, {'$addToSet':{'keyword_list':{'$each':keywords}}}, upsert=True)



#MongoDB에서 키워드를 삭제
def delete_keyword_list(category, index, scope, keywords):
    #매개변수 인덱스와 스코프는 프론트에서 도큐먼트 조회 시 유지되는 데이터로 전달받음
    db.keyword_set.update({'$and':[{'category':category}, {'index':index}, {'scope':scope}]}, {'$pull':{'keyword_list':{'$in':keywords}}})



#전체키워드리스트에서 사용자가 선택한 카테고리의 키워드 추출
def extract_keyword_list(keywords):
    return null





#코드 실행
print(create_keyword_list('111111111102410311202001000000', '11000000'))
#insert_keyword_list(0, 10, '<=13', ['테스트키워드1', '테스트키워드2', '테스트키워드3'])
#delete_keyword_list(0, 10, '<=16', ['테스트키워드1', '테스트키워드2'])
