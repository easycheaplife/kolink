from twikit import Client
from flask import Flask, redirect, request
import os
import json
import time
import logging
import sys
from datetime import datetime

app = Flask(__name__)

client = Client('en-US')
host = "0.0.0.0"
port = 8020

## You can comment this `login`` part out after the first time you run the script (and you have the `cookies.json`` file)
client.login(
    auth_info_1 = os.getenv("TW_USER_NAME"),
    password = os.getenv("TW_PWD"),
)

client.save_cookies('cookies.json');
client.load_cookies(path='cookies.json');

log_file = "twitter_service.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

get_user_followers_res = {
        "code": 0,
        "data": {
            "list": [
                {
                    "name": "Kevinshao",
                    "user_id": "949852985038745600",
                    "username": "kevinshao6"
                    },
                {
                    "name": "patrick.eth",
                    "user_id": "1766004311547695104",
                    "username": "rui905747990826"
                    },
                {
                    "name": "Pixel",
                    "user_id": "1513032078832836608",
                    "username": "Spoonicks_eth"
                    },
                {
                    "name": "web3.0withaname",
                    "user_id": "1353504283",
                    "username": "lighostweb3"
                    },
                {
                    "name": "kolinksystem",
                    "user_id": "1780514896670756865",
                    "username": "kolinksyst61929"
                    },
                {
                    "name": "Selfmade mfers",
                    "user_id": "1472975587148926978",
                    "username": "selfmademfers"
                    },
                {
                    "name": "Etta Toor",
                    "user_id": "1697888320242450432",
                    "username": "EttaToor90332"
                    }
                ]
            },
        "message": ""
        }

@app.route('/twitter/get_user', methods=['GET'])
def get_user():
    screen_name = request.args.get('screen_name')
    user = client.get_user_by_screen_name(screen_name)
    logging.info("get_user,screen name" + screen_name)
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    public_metrics = {
        "followers_count" : user.followers_count,
        "following_count" : user.following_count,
        "listed_count" : user.listed_count,
        "like_count" : user.favourites_count,
        "tweet_count" : user.statuses_count,
    }
    user_json = {
         "id" : user.id,
         "name" : user.name,
         "username" : user.screen_name,
         "description" : user.description,
         "profile_image_url" : user.profile_image_url,
         "url" : user.url,
         "public_metrics" : public_metrics,
         "location" : user.location,
         "created_at" : user.created_at,
    } 
    response['data'] = user_json
    logging.info(user_json)
    return response

@app.route('/twitter/get_user_followers', methods=['GET'])
def get_user_followers():
    user_id = request.args.get('user_id', '1772822956034621440')
    count = request.args.get('count', 200)
    debug = request.args.get('debug', 0)

    if debug:
        return get_user_followers_res

    logging.info('get_user_followers,user_id:' + str(user_id) + ' count:' + str(count))
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    result = client.get_user_followers(user_id, count=count)
    users = []
    for user in result:
        users.append({'user_id' : user.id, 'name' : user.name, 'username' : user.screen_name})
    response['data']['list'] = users
    return response

if __name__ == '__main__':
    app.run(debug=False, host=host, port=port)
