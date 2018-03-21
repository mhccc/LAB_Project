# -*- coding: utf8 -*-
import sys
import pymongo

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
linkc = db.link

# 페로몬 업데이트
def update_pheromone(url):
	try:
	    link_data = linkc.find_one({"url":url})
	    linkc.update({"url":url},{"$set":{"pheromone":link_data["pheromone"]+0.15}})

	    print(True)
	
	except:
		print(False)

if __name__=='__main__':
    update_pheromone(sys.argv[1])
    