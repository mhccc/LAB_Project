# -*- coding: utf8 -*-
import sys
import pymongo

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
linkc = db.link

# 조회수 업데이트
def update_hit(url):
    link_data = linkc.find_one({"url":url})
    linkc.update({"url":url},{"$set":{"hit":link_data["hit"]+1}})

if __name__=='__main__':
    update_hit(sys.argv[1])
    