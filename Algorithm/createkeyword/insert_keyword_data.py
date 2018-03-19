# -*- coding: utf8 -*-
import pymongo


#커넥션 생성
connection = pymongo.MongoClient('localhost', 27017)
db = connection.Health_One



def insert_keyword_data():

    #성별
    db.keyword_set.insert_one(
    {
        u'category_index' : 0,
        u'survey_index' : 10,
        u'scope' : '==0',
        u'keyword_title' : u'남성',
        u'keyword_list' : [u'남성병', u'남자 건강', u'남자를 위한 음식']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 0,
        u'survey_index' : 10,
        u'scope' : '==1',
        u'keyword_title' : u'여성',
        u'keyword_list' : [u'여성병', u'여자 건강', u'여자를 위한 음식']
    })

    #나이
    db.keyword_set.insert_one(
    {
        u'category_index' : 1,
        u'survey_index' : 11,
        u'scope' : '==0',
        u'keyword_title' : u'청소년',
        u'keyword_list' : [u'청소년 건강의', u'청소년 건강에']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 1,
        u'survey_index' : 11,
        u'scope' : '==1',
        u'keyword_title' : u'청년',
        u'keyword_list' : [u'청년 건강의', u'청년 건강에', u'성인병의', u'성인병에']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 1,
        u'survey_index' : 11,
        u'scope' : '==2',
        u'keyword_title' : u'중년',
        u'keyword_list' : [u'중년 건강의', u'중년 건강에', u'중년 질환의', u'중년 질환에']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 1,
        u'survey_index' : 11,
        u'scope' : '==3',
        u'keyword_title' : u'노년',
        u'keyword_list' : [u'노년 건강의', u'노년 건강에', u'치매의', u'치매에', u'골다공증의', u'골다공증에', u'관절염의', u'관절염에']
    })

    #식사
    db.keyword_set.insert_one(
    {
        u'category_index' : 2,
        u'survey_index' : 12,
        u'scope' : '==1',
        u'keyword_title' : u'소식',
        u'keyword_list' : [u'1일 1식', u'하루 한끼']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 2,
        u'survey_index' : 12,
        u'scope' : '>=4',
        u'keyword_title' : u'과식',
        u'keyword_list' : [u'하루 세끼 이상']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 2,
        u'survey_index' : 13,
        u'scope' : '==1',
        u'keyword_title' : u'불규칙적 식사',
        u'keyword_list' : [u'규칙적 식사의', u'규칙적 식사에', u'불규칙 식사의']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 2,
        u'survey_index' : 14,
        u'scope' : '==1',
        u'keyword_title' : u'야식',
        u'keyword_list' : [u'잦은 야식의', u'야식 위험성', u'습관성 야식']
    })

    #음주
    db.keyword_set.insert_one(
    {
        u'category_index' : 3,
        u'survey_index' : 15,
        u'scope' : '>=4',
        u'keyword_title' : u'잦은 음주',
        u'keyword_list' : [u'잦은 음주의', u'잦은 음주에']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 3,
        u'survey_index' : 16,
        u'scope' : '==1',
        u'keyword_title' : u'과음',
        u'keyword_list' : [u'한국인 적정 음주량', u'과음 위험성', u'숙취에 좋은 음식']
    })

    #흡연
    db.keyword_set.insert_one(
    {
        u'category_index' : 4,
        u'survey_index' : 17,
        u'scope' : '==2',
        u'keyword_title' : u'흡연',
        u'keyword_list' : [u'흡연의 위험성', u'흡연 암']
    })

    #운동
    db.keyword_set.insert_one(
    {
        u'category_index' : 5,
        u'survey_index' : 19,
        u'scope' : '<=100',
        u'keyword_title' : u'유산소 운동부족',
        u'keyword_list' : [u'유산소 운동부족', u'유산소 운동의 필요성']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 5,
        u'survey_index' : 19,
        u'scope' : '>=500',
        u'keyword_title' : u'유산소 운동과다',
        u'keyword_list' : [u'과도한 유산소 운동']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 5,
        u'survey_index' : 21,
        u'scope' : '<=100',
        u'keyword_title' : u'무산소 운동부족',
        u'keyword_list' : [u'무산소 운동부족', u'무산소 운동의 필요성']
    })
    db.keyword_set.insert_one(
    {
    u'category_index' : 5,
        u'survey_index' : 21,
        u'scope' : '>=500',
        u'keyword_title' : u'무산소 운동과다',
        u'keyword_list' : [u'과도한 무산소 운동']
    })

    #질병
    db.keyword_set.insert_one(
    {
        u'category_index' : 6,
        u'survey_index' : 22,
        u'scope' : '==1',
        u'keyword_title' : u'고혈압',
        u'keyword_list' : [u'고혈압의', u'고혈압에', u'혈압 관리']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 6,
        u'survey_index' : 23,
        u'scope' : '==1',
        u'keyword_title' : u'당뇨',
        u'keyword_list' : [u'당뇨의', u'당뇨에', u'혈당 관리', u'저당 식단']
    })

    #암
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 24,
        u'scope' : '==1',
        u'keyword_title' : u'간암',
        u'keyword_list' : [u'간암의', u'간암에', u'암 식단']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 25,
        u'scope' : '==1',
        u'keyword_title' : u'위암',
        u'keyword_list' : [u'위암의', u'위암에', u'암 식단']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 26,
        u'scope' : '==1',
        u'keyword_title' : u'폐암',
        u'keyword_list' : [u'폐암의', u'폐암에', u'암 식단']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 27,
        u'scope' : '==1',
        u'keyword_title' : u'갑상선암',
        u'keyword_list' : [u'갑상선암의', u'갑상선암에', u'암 식단']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 28,
        u'scope' : '==1',
        u'keyword_title' : u'유방암',
        u'keyword_list' : [u'유방암의', u'유방암에', u'암식단']
    })
    db.keyword_set.insert_one(
    {
        u'category_index' : 7,
        u'survey_index' : 29,
        u'scope' : '==1',
        u'keyword_title' : u'기타암',
        u'keyword_list' : [u'암 식단']
    })



insert_keyword_data()
