from flask import Flask, redirect, request
import tweepy
import json
import time
import logging
from datetime import datetime

app = Flask(__name__)

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'
callback_url = 'https://gold-breads-occur.loca.lt/auth/twitter/callback'
session = {}

host = "0.0.0.0"
port = 8000

log_file = "user_auth.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

@app.route('/twitter/auth')
def auth_twitter():
    session_id = request.args.get('session_id')
    if session_id not in session:
        session[session_id] = {}
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth_url = auth.get_authorization_url()
    session[session_id]['request_token'] = auth.request_token
    response = {
        "code": 0,
        "message": "",
        "data": {"url": auth_url, "session_id" : session_id}
    }
    return response

@app.route('/twitter/user')
def auth_twitter_callback():
    session_id = request.args.get('session_id')
    verifier = request.args.get('oauth_verifier')
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth.request_token = session[session_id]['request_token']
    auth.get_access_token(verifier)
    api = tweepy.API(auth)
    user = api.verify_credentials()
    user_json = json.dumps(user._json)
    logging.info(user_json)
    response = {
        "code": 0,
        "message": "",
        "data": user._json
    }
    return response

if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)

