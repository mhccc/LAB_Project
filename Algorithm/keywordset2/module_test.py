import createCategory
import createKeyword

#print(createCategory.create_category_string())
#print(createKeyword.create_keyword_list())

def test():
    survey_string = createCategory.servey_string
    category_string = createCategory.create_category_string()
    keyword_list = []

    print(survey_string)
    print(category_string)
    print(createKeyword.create_keyword_list(survey_string, category_string))


test()
