from twikit import Client
from flask import Flask, redirect, request
import os
import pandas as pd
import mysql.connector
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



@app.route('/twitter/get_user', methods=['GET'])
def get_user():
    screen_name = request.args.get('screen_name')
    user = client.get_user_by_screen_name(screen_name)
    logging.info("screen name" + screen_name)
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


if __name__ == '__main__':
    app.run(debug=False, host=host, port=port)
