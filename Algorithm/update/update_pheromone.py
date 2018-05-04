# -*- coding: utf8 -*-
import pymongo

connection = pymongo.MongoClient("localhost",27017)
db = connection.Health_One
linkc = db.link

# 페로몬 업데이트
def update_pheromone():
	try:
	    link_data = linkc.find()

	    for data in link_data:
	    	increase_pheromone = 0
	    	
	    	if data['pheromone_m'] != 0:
	    		for k in range(data['pheromone_m']):
	    			increase_pheromone += 1
	    								  #?

	    	new_pheromone = (1 - p) * data['pheromone'] + increase_pheromone
	    						 #?

	    	linkc.update({"url":data['url']},{"$set":{"pheromone":new_pheromone},{"pheromone_m":0}})

	    print({'code' : 100, 'msg' : "True"})
	    return {'code' : 100, 'msg' : "True"}

	except:
		print({'code' : 1, 'msg' : "False"})#, 'url' : url})
	    #return {'code' : 1, 'msg' : "False", 'url' : url}

if __name__=='__main__':
    update_pheromone()