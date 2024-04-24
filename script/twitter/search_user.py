from twikit import Client
import os
import pandas as pd
import mysql.connector
import json
import time
import logging
import sys
from datetime import datetime

args = sys.argv
if len(sys.argv) < 2:
    print('param error! please input python3 search_user.py gamefi')
    sys.exit()

client = Client('en-US')

## You can comment this `login`` part out after the first time you run the script (and you have the `cookies.json`` file)
client.login(
    auth_info_1 = os.getenv("TW_USER_NAME"),
    password = os.getenv("TW_PWD"),
)

client.save_cookies('cookies.json');
client.load_cookies(path='cookies.json');

host = "0.0.0.0"
port = 8000
cnx = mysql.connector.connect(
    host="localhost",
    user="root",
    password="F0BYKDqw7",
    database="kolink"
)
cursor = cnx.cursor()

log_file = "search_user.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)


def str_to_unixtime(date_string):
    date_format = "%a %b %d %H:%M:%S %z %Y"
    dt = datetime.strptime(date_string, date_format)
    return int(dt.timestamp())

def insert_user(user):
    try:
        insert_query = """INSERT INTO twitter_user (
            user_id, name, screen_name, location, description, 
            url, followers_count, friends_count, listed_count, favourites_count, 
            utc_offset, time_zone, geo_enabled, verified, statuses_count, 
            lang, profile_background_image_url, profile_background_image_url_https, profile_image_url, profile_image_url_https, 
            following_count, media_count, description_urls, created_at, updated_at) 
            VALUES (%s, %s, %s, %s, %s,
            %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s)"""
        logging.info(insert_query)
        if user.url is None:
            user.url = ''
        values = (str(user.id), user.name, user.screen_name, user.location, user.description,
            user.url, str(user.followers_count), '0', str(user.listed_count), str(user.favourites_count),
            '0', '', '0', str(int(user.verified)), str(user.statuses_count),
            '', '', '', user.profile_image_url, '', 
            str(user.following_count), str(user.media_count), str(json.dumps(user.description_urls)), str(str_to_unixtime(user.created_at)), str(int(time.time())))
        cursor.execute(insert_query, values)

        insert_data_query = "UPDATE twitter_user_data SET insert_flag = 1 where user_id = " + str(user.id) 
        logging.info(insert_data_query)
        cursor.execute(insert_data_query)
        cnx.commit()
    except mysql.connector.IntegrityError as e:
        if e.errno == 1062: 
            pass
        else:
            logging.error('inser_user_json failed:', e)

tweets_to_store = [];
logging.info("search keyward:" + str(args[1])) 
search_count = 100
result = client.search_user(args[1], search_count)
for user in result:
    logging.info(user.__dict__)
    insert_user(user)
    tweets_to_store.append({  
        'id':user.id,
        'name':user.name,
        'screen_name':user.screen_name,
        'following_count':user.following_count,
        'followers_count':user.followers_count,
        'statuses_count':user.statuses_count,
        'favourites_count':user.favourites_count,
        'listed_count':user.listed_count,
        'media_count':user.media_count,
        'profile_image_url':user.profile_image_url,
        'url':user.url,
        'description_urls':user.description_urls,
        'description':user.description,
        'location':user.location,
        'created_at':user.created_at,
    })
df = pd.DataFrame(tweets_to_store) 
df.to_csv('tweets.csv', index=False) 
logging.info(df.sort_values(by='followers_count', ascending=False)) 
logging.info(json.dumps(tweets_to_store, indent=4))  

cursor.close()
cnx.close()

