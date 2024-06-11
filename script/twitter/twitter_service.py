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

get_user_data_res = {
        "code": 0,
        "data": {
            "created_at": "Tue Mar 09 11:18:06 +0000 2021",
            "description": "@sunflowerlabs_ \u8054\u5408\u521b\u59cb\u4eba\u4e28 \u4e00\u3001\u4e8c\u7ea7\u6295\u7814\u4e28 #BTC \u5b9a\u6295\u73a9\u5bb6\u4e28 #OKX \u65b0\u6ce8\u518c\u7528\u6237\u5373\u53ef\u83b7\u5f9720%\u53cd\u4f63\uff1ahttps://t.co/mVckwjWVOX \n\n\u4e2a\u4eba\u5a92\u4f53\uff1a\u4e28\u5e01\u5b89\u5e7f\u573a\u4e28YouTube\u4e28\u559c\u9a6c\u62c9\u96c5\u4e28\u516c\u4f17\u53f7\u4e28\n\nTG\u793e\u533a\uff1ahttps://t.co/56iEksFc5m",
            "id": "1369245899344412678",
            "location": "https://discord.gg/52V2ACtwDg",
            "name": "Mr.Bai \u767d\u5148\u751f",
            "profile_image_url": "https://pbs.twimg.com/profile_images/1632736378697154560/8aK2weJM_normal.jpg",
            "public_metrics": {
                "favorite_count_total": 4784,
                "followers_count": 49882,
                "following_count": 1039,
                "like_count": 1349,
                "listed_count": 38,
                "reply_count_total": 1763,
                "retweet_count_total": 70182,
                "tweet_count": 2359,
                "view_count_total": 485670
                },
            "url": "https://t.co/5cOkCgZRsX",
            "username": "Baisircrypto"
            },
        "message": ""
        }

@app.route('/twitter/login', methods=['GET'])
def login():
## You can comment this `login`` part out after the first time you run the script (and you have the `cookies.json`` file)
    client.login(
        auth_info_1 = os.getenv("TW_USER_NAME"),
        password = os.getenv("TW_PWD"),
    )
    client.save_cookies('cookies.json');
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    return response 

@app.route('/twitter/get_user', methods=['GET'])
def get_user():
    screen_name = request.args.get('screen_name')
    client.load_cookies(path='cookies.json');
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
    client.load_cookies(path='cookies.json');
    result = client.get_user_followers(user_id, count=count)
    users = []
    for user in result:
        users.append({'user_id' : user.id, 'name' : user.name, 'username' : user.screen_name})
    response['data']['list'] = users
    return response

@app.route('/twitter/get_user_data', methods=['GET'])
def get_user_data():
    debug = request.args.get('debug', 0)

    if debug:
        return get_user_data_res

    screen_name = request.args.get('screen_name')
    client.load_cookies(path='cookies.json');
    user = client.get_user_by_screen_name(screen_name)
    logging.info("get_user_data,screen name" + screen_name)

    tweet_all = []
    tweets = user.get_tweets('Tweets', count=40)
    for tweet in tweets:
        tweet_all.append(tweet)
    more_tweets = tweets.next()
    for tweet in more_tweets:
        tweet_all.append(tweet)

    reply_count_total = 0
    favorite_count_total = 0
    view_count_total = 0
    retweet_count_total = 0
    tweet_ids = []
    for tweet in tweet_all:
        if tweet.view_count is None:
            tweet.view_count = '0'
        favorite_count_total = favorite_count_total + tweet.favorite_count
        reply_count_total = reply_count_total + tweet.reply_count
        view_count_total = view_count_total + int(tweet.view_count)
        retweet_count_total = retweet_count_total + tweet.retweet_count
        tweet_ids.append(tweet.id)

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
        "favorite_count_total" : favorite_count_total, 
        "reply_count_total" : reply_count_total, 
        "view_count_total" : view_count_total, 
        "retweet_count_total" : retweet_count_total, 
    }
    user_json = {
         "id" : user.id,
         "name" : user.name,
         "username" : user.screen_name,
         "description" : user.description,
         "profile_image_url" : user.profile_image_url,
         "url" : user.url,
         "public_metrics" : public_metrics,
         'tweet_ids' : tweet_ids,
         "location" : user.location,
         "created_at" : user.created_at,
    } 
    response['data'] = user_json
    logging.info(user_json)
    return response
    
if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)
