from flask import Flask, redirect, request
import tweepy
import json
import random
import time
import logging
from datetime import datetime
import secrets
import string


app = Flask(__name__)

host = "0.0.0.0"
port = 9020

log_file = "youtube_service.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

auth_res = {
		"code": 0,
		"data": {
			"access_token": "ya29.a0AXooCgt2VMZqnETCliiw19cRzz372i3uo1ZUl29pY8pQA_ZXHCnmHI6Xbu68D0pCBbMk63ub6p5OcQ8wpmaZzjvxOTDvwvFXhVBC-fMQfaxSTPmQsrdGhI7ao7V1Ly8pd9anmCMnxthv8PomxD5NQKO-PUxg3-vsmQaCgYKAfwSARISFQHGX2Midt_OvEa9Y2dcdkTE4ywnyA0169",
			"expires_in": 3566,
			"scope": "https://www.googleapis.com/auth/youtube.readonly",
			"token_type": "Bearer"
			},
		"message": ""
		}

user_res = {
		"code": 0,
		"data": {
			"kind": "youtube#channelListResponse",
			"etag": "HZ9-wCvz6aoRY4hQh5dPc2NLhAE",
			"pageInfo": {
				"totalResults": 1,
				"resultsPerPage": 5
				},
			"items": [
				{
					"kind": "youtube#channel",
					"etag": "sva4SIlWobCvLGgrBK-y5fVWTZo",
					"id": "UChZyavSS3MaPFI6zz5PO8JQ",
					"snippet": {
						"title": "Bob Johnson",
						"description": "",
						"customUrl": "@user-1q2w3d4r",
						"publishedAt": "2017-04-21T06:07:12Z",
						"thumbnails": {
							"default": {
								"url": "https://yt3.ggpht.com/ytc/AIdro_lBMgPNLORc2UqrIG_EHLLzbNin8v1R6wzb69fi43w=s88-c-k-c0x00ffffff-no-rj",
								"width": 88,
								"height": 88
								},
							"medium": {
								"url": "https://yt3.ggpht.com/ytc/AIdro_lBMgPNLORc2UqrIG_EHLLzbNin8v1R6wzb69fi43w=s240-c-k-c0x00ffffff-no-rj",
								"width": 240,
								"height": 240
								},
							"high": {
								"url": "https://yt3.ggpht.com/ytc/AIdro_lBMgPNLORc2UqrIG_EHLLzbNin8v1R6wzb69fi43w=s800-c-k-c0x00ffffff-no-rj",
								"width": 800,
								"height": 800
								}
							},
						"localized": {
							"title": "Sam Smith",
							"description": ""
							}
						},
					"statistics": {
						"viewCount": "0",
						"subscriberCount": "0",
						"hiddenSubscriberCount": False,
						"videoCount": "0"
						}
					}
				]
			},
		"message": ""
	}

def generate_id():
    alphabet = string.ascii_uppercase + string.digits
    random_string = ''.join(secrets.choice(alphabet) for _ in range(24))
    return random_string

def generate_name():
    first_names = ["Alice", "Bob", "Charlie", "David", "Eva", "Frank"]
    last_names = ["Smith", "Johnson", "Brown", "Lee", "Garcia", "Wang"]
    first_name = random.choice(first_names)
    last_name = random.choice(last_names)
    return first_name + " " + last_name

@app.route('/youtube/auth', methods=['GET'])
def auth():
	return auth_res['data']

@app.route('/youtube/user', methods=['GET'])
def user():
	user_res['data']['items'][0]['id'] = generate_id()
	user_res['data']['items'][0]['snippet']['title'] = generate_name()
	user_res['data']['items'][0]['snippet']['localized']['title'] = user_res['data']['items'][0]['snippet']['title']
	user_res['data']['items'][0]['statistics']['viewCount'] = random.randint(1, 999)
	user_res['data']['items'][0]['statistics']['subscriberCount'] = random.randint(1, 999)
	user_res['data']['items'][0]['statistics']['videoCount'] = random.randint(1, 999)
	return user_res['data']

if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)

