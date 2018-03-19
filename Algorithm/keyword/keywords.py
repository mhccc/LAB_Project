# -*- coding: utf8 -*-
import sys
import pymongo
import json
from operator import eq

#커넥션 생성
connection = pymongo.MongoClient('localhost', 27017)
db = connection.Health_One





#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 전체키워드리스트 추출
def create_keyword_list(survey_string, category_string):
    #키워드가 저장 될 리스트
    result_keyword_list = []

    #인덱스 오름차순으로 각 도큐먼트를 한개씩 조회
    for doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
        category_index = doc['category_index']
        survey_index = doc['survey_index']
        scope = extract(doc['scope'])
        keyword_list = doc['keyword_list']

        #category_string이 1인 항목만 추출
        if eq(category_string[category_index], '1'):
            #DB에 저장된 조건이 '=='일 때
            if eq(scope['operator'], '=='):
                if int(survey_string[survey_index]) == int(scope['operand']):
                    result_keyword_list.append(keyword_list)

            #DB에 저장된 조건이 '<='일 때
            elif eq(scope['operator'], '<='):
                if int(survey_string[survey_index]) <= int(scope['operand']):
                    result_keyword_list.append(keyword_list)

            #DB에 저장된 조건이 '>='일 때
            elif eq(scope['operator'], '>='):
                if int(survey_string[survey_index]) >= int(scope['operand']):
                    result_keyword_list.append(keyword_list)

    #키워드셋 리스트 출력 및 리턴
    print(result_keyword_list)
    return result_keyword_list



#MongoDB에 키워드를 추가
def insert_keyword_list(category_index, survey_index, scope, keyword_list):

    #문자열 카테고리를 해당되는 인덱스로 변환
    if eq(category_index, '성별'):
        category_index = 0
    elif eq(category_index, '연령'):
        category_index = 1
    elif eq(category_index, '식습관'):
        category_index = 2
    elif eq(category_index, '음주'):
        category_index = 3
    elif eq(category_index, '흡연'):
        category_index = 4
    elif eq(category_index, '운동'):
        category_index = 5
    elif eq(category_index, '질병'):
        category_index = 6
    elif eq(category_index, '암'):
        category_index = 7

    #매개변수 인덱스와 스코프에 해당하는 도큐먼트에 키워드를 추가 (해당하는 도큐먼트 없으면 토큐먼트를 새로 생성)
    db.keyword_set.update({'$and':[{'category_index':category_index}, {'survey_index':survey_index}, {'scope':scope}]}, {'$addToSet':{'keyword_list':{'$each':keyword_list}}}, upsert=True)


#리스트 비교를 위한 메소드
def cmp(a, b):
    return (a > b) - (a < b)

#MongoDB에서 키워드를 삭제
def delete_keyword_list(category_index, survey_index, scope, keyword_list):

    if eq(category_index, '성별'):
        category_index = 0
    elif eq(category_index, '연령'):
        category_index = 1
    elif eq(category_index, '식습관'):
        category_index = 2
    elif eq(category_index, '음주'):
        category_index = 3
    elif eq(category_index, '흡연'):
        category_index = 4
    elif eq(category_index, '운동'):
        category_index = 5
    elif eq(category_index, '질병'):
        category_index = 6
    elif eq(category_index, '암'):
        category_index = 7

    #매개변수 인덱스와 스코프에 해당하는 도큐먼트에 키워드를 삭제
    db.keyword_set.update({'$and':[{'category_index':category_index}, {'survey_index':survey_index}, {'scope':scope}]}, {'$pull':{'keyword_list':{'$in':keyword_list}}})
    #모든 키워드가 삭제되어 비게되면 해당 도큐먼트를 삭제
    update_doc = db.keyword_set.find_one({'$and':[{'category_index':category_index}, {'survey_index':survey_index}, {'scope':scope}]})
    if cmp(update_doc['keyword_list'], []) == 0:
        db.keyword_set.remove(update_doc)






if __name__=='__main__':
    create_keyword_list(sys.argv[1], sys.argv[2])
    insert_keyword_list(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4])
    delete_keyword_list(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4])

#코드 실행
#print(create_keyword_list('111111111102410311202001000000', '11000000'))
#insert_keyword_list('성별', 10, '<=13', ['테스트키워드1', '테스트키워드2', '테스트키워드3', '테스트키워드4', '테스트키워드5', '테스트키워드6'])
#delete_keyword_list('성별', 10, '<=13', ['테스트키워드1', '테스트키워드2', '테스트키워드3', '테스트키워드4'])
