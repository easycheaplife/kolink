from flask import Flask, redirect, request
import tweepy
import json
import time
import logging
from datetime import datetime

app = Flask(__name__)

consumer_key = 'gfJSbufYP2dDLGx9A4nYrUBQf'
consumer_secret = 'W7qE8naK1D3v6zXn6njkkL30M7EQAk39klGkZmFbY4Wl8yRNTh'
callback_url = 'http://localhost:8888/oauth'
session = {}

host = "0.0.0.0"
port = 8010

log_file = "user_auth.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

auth_res = {
		"code": 0,
		"data": {
			"auth_url": "https://api.twitter.com/oauth/authorize?oauth_token=b4BX7QAAAAABtAVoAAABjuWOOlY",
			"session_id": "f8a54afb-56e9-4149-9854-2dbf9c331a9d"
			},
		"message": ""
		}

user_res = {
		"code": 0,
		"data": {
			"contributors_enabled": False,
			"created_at": "Tue Apr 10 14:08:55 +0000 2018",
			"default_profile": True,
			"default_profile_image": True,
			"description": "hi",
			"entities": {
				"description": {
					"urls": []
					}
				},
			"favourites_count": 0,
			"follow_request_sent": False,
			"followers_count": 0,
			"following": False,
			"friends_count": 7,
			"geo_enabled": False,
			"has_extended_profile": False,
			"id": 983708407558361088,
			"id_str": "983708407558361088",
			"is_translation_enabled": False,
			"is_translator": False,
			"lang": None,
			"listed_count": 0,
			"location": "",
			"name": "cleansky",
			"needs_phone_verification": False,
			"notifications": False,
			"profile_background_color": "F5F8FA",
			"profile_background_image_url": None,
			"profile_background_image_url_https": None,
			"profile_background_tile": False,
			"profile_image_url": "http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png",
			"profile_image_url_https": "https://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png",
			"profile_link_color": "1DA1F2",
			"profile_sidebar_border_color": "C0DEED",
			"profile_sidebar_fill_color": "DDEEF6",
			"profile_text_color": "333333",
			"profile_use_background_image": True,
			"protected": True,
			"screen_name": "cleansky2020",
			"statuses_count": 0,
			"suspended": False,
			"time_zone": None,
			"translator_type": "none",
			"url": None,
			"utc_offset": None,
			"verified": False,
			"withheld_in_countries": []
			},
		"message": ""
}

@app.route('/twitter/auth', methods=['GET'])
def auth_twitter():
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    session_id = request.args.get('session_id', 0)
    redirect_uri = request.args.get('redirect_uri', callback_url)
    response['data']['session_id'] = session_id
    if session_id not in session:
        session[session_id] = {}
    return auth_res
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback = redirect_uri)
    auth_url = auth.get_authorization_url()
    session[session_id]['request_token'] = auth.request_token
    response['data']['auth_url'] = auth_url
    return response

@app.route('/twitter/user', methods=['GET'])
def auth_twitter_callback():
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    session_id = request.args.get('session_id')
    verifier = request.args.get('oauth_verifier')
    redirect_uri = request.args.get('redirect_uri', callback_url)
    return user_res
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback = redirect_uri)
    auth.request_token = session[session_id]['request_token']
    auth.get_access_token(verifier)
    api = tweepy.API(auth)
    user = api.verify_credentials()
    logging.info(json.dumps(user._json))
    response['data'] = user._json
    return response

if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)

