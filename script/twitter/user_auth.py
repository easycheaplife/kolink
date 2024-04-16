from flask import Flask, redirect, request
import tweepy
import json
import time
import logging
from datetime import datetime

app = Flask(__name__)

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'
callback_url = 'http://localhost:8888/oauth'
session = {}

host = "0.0.0.0"
port = 8010

log_file = "user_auth.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

@app.route('/twitter/auth', methods=['GET'])
def auth_twitter():
    response = {
        "code": 0,
        "message": "",
        "data": {}
    }
    session_id = request.args.get('session_id', 0)
    response['data']['session_id'] = session_id
    if session_id not in session:
        session[session_id] = {}
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
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
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth.request_token = session[session_id]['request_token']
    auth.get_access_token(verifier)
    api = tweepy.API(auth)
    user = api.verify_credentials()
    logging.info(json.dumps(user._json))
    response['data'] = user._json
    return response

if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)

