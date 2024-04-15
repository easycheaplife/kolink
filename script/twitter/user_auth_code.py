from flask import Flask, redirect, request
import tweepy
import json
import time
import logging
from datetime import datetime

app = Flask(__name__)

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'

session = {}

host = "0.0.0.0"
port = 8000

log_file = "user_auth_code.log"
logging.basicConfig(filename=log_file, level=logging.DEBUG)

@app.route('/')
def index():
    response = {
        "code": 0,
        "message": "",
        "data": []
    }
    return response 

@app.route('/code/twitter')
def code_twitter():
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback='oob')
    try:
        redirect_url = auth.get_authorization_url()
        logging.info(redirect_url)
    except tweepy.TweepError:
        print('Error! Failed to get request token.')
    session['request_token'] = auth.request_token
    response = {
        "code": 0,
        "message": "",
        "data": { "redirect_url" : redirect_url}
    }
    return response 

@app.route('/auth/twitter')
def auth_twitter():
    verifier_code = request.args.get('code')
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback='oob')
    try:
        auth.request_token = session['request_token']
        auth.get_access_token(verifier_code)
    except Exception as e:
        logging.error('Error! Failed to get access token.', e)
        return "Error! Failed to get access token"

    api = tweepy.API(auth)
    user = api.verify_credentials()
    user_json = json.dumps(user._json)
    response = {
        "code": 0,
        "message": "",
        "data": user._json
    }
    return response

if __name__ == '__main__':
    app.run(debug=False, host=host, port=port)

