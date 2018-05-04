# -*- coding: utf8 -*-
import sys
import pymongo
from operator import eq

#커넥션 생성
connection = pymongo.MongoClient('localhost', 27017)
db = connection.Health_One



#scope에서 비교연산자와 피연산자를 dict자료형으로 추출 (create_keyword_list에서 호출)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

#MongoDB에서 전체키워드리스트 추출
def keywordset(survey_string, category_string):
    #키워드가 저장 될 리스트
    result_keyword_list = []

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



if __name__=='__main__':
    keywordset(sys.argv[1], sys.argv[2])
