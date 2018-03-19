# -*- coding: utf8 -*-
import sys
import pymongo

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
serveyc = db.servey

def category(user_idx, servey_string):
        '''
        category_string

        index 0 : 성별,
        index 1 : 나이대,
        index 2 : 규칙적인 식사(야식 포함),
        index 3 : 음주,
        index 4 : 흡연,
        index 5 : 운동(유산소 운동,무산소 운동),
        index 6 : 질병(고혈압,당뇨)
        index 7 : 암(간암,위암,폐암,갑상선암,유방암,기타암)
        '''
        # category_string 초기화
        category_string = "11000000"

        # 규칙적인 식사 (불규칙적인 식사면)
        if servey_string[13] != "0" :
                category_string = category_string[:2] + "1" + category_string[3:]
        # 음주 (과음이면)
        if servey_string[16] != "0" :
                category_string = category_string[:3] + "1" + category_string[4:]
        # 흡연 (금연 또는 흡연이면)
        if servey_string[17] != "0" :
                category_string = category_string[:4] + "1" + category_string[5:]
        # 운동 (무산소 또는 유산소 운동이 100분 미만, 500분 초과면)
        if int(servey_string[18:20]) < 10 or int(servey_string[18:20]) > 50 or int(servey_string[20:22]) < 10 or int(servey_string[20:22]) > 50 :
                category_string = category_string[:5] + "1" + category_string[6:]
        # 질병 (고혈압 또는 당뇨가 있다면)
        if servey_string[22:24].find("1") != -1 :
                category_string = category_string[:6] + "1" + category_string[7:]
        # 암 (암이 있다면)
        if servey_string[24:].find("1") != -1 :
                category_string = category_string[:7] + "1"

        # 설문정보 servey컬렉션에 저장
        serveyc.insert({"user_idx":user_idx,"servey_idx":servey_string[:10],"servey_string":servey_string,"category_string":category_string})


###################################################################################################################################################################################
'''
# 자가진단결과 (0~36, 37자리 문자열)
1111111111 0 2 4 1 0 3 1 1 2020 01 000000
           * *   *     * * **** ** ******
         성별 나이 식사  음주 흡연 운동 질병 암
'''
if __name__=='__main__':
    category(sys.argv[1], sys.argv[2])
    