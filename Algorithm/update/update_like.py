# -*- coding: utf8 -*-
import sys
import pymongo

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
linkc = db.link

# like 업데이트
def update_like(url):
	try:
	    link_data = linkc.find_one({"url":url})
	    linkc.update({"url":url},{"$set":{"like":link_data["like"] + 1}})

	    print({'code' : 100, 'msg' : "True"})
	    return {'code' : 100, 'msg' : "True"}

	except:
		print({'code' : 1, 'msg' : "False", 'url' : url})
	    #return {'code' : 1, 'msg' : "False", 'url' : url}

if __name__=='__main__':
    update_like(sys.argv[1])
    