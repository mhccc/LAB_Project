# -*- coding: utf8 -*-

import pymongo
import json
from operator import eq
from pymongo import MongoClient

#커넥션 생성
connection = MongoClient('localhost', 27017)
db = connection.Health_One


#scope에서 비교연산자와 피연산자를 dict자료형으로 추출
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 키워드셋 추출
def create_keyword_list():
    #임의의 자가진단결과
    survey_string = '000000000101201301000000010100'
    #진단결과로 추출된 키워드 리스트
    result_keyword_list = []

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


    #키워드셋 리스트 출력
    print(result_keyword_list)


    #커넥션 종료
    connection.close();

#키워드셋 추출
create_keyword_list()
