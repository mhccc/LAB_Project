import pymongo

connection = pymongo.MongoClient("localhost", 27017)

db = connection.Health_One

collection = db.keyword_set


print(collection)
def extract(scope):
    return {'operator':scope[:2], 'operand':scope[2]}

for keywordset_doc in db.keyword_set.find().sort('survey_index', pymongo.ASCENDING):
    id = keywordset_doc['_id']
    category_index = keywordset_doc['keyword_list']
    survey_index = keywordset_doc['keyword_title']


    print(id)
    print(category_index)
    print(survey_index)
