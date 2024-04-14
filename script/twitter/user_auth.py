from flask import Flask, redirect, request
import tweepy
import mysql.connector
import json
import time
from datetime import datetime

app = Flask(__name__)

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'
callback_url = 'https://gold-breads-occur.loca.lt/auth/twitter/callback'

host = "0.0.0.0"
port = 8000
cnx = mysql.connector.connect(
    host="localhost",
    user="root",
    password="F0BYKDqw7",
    database="kolink"
)

cursor = cnx.cursor()

def str_to_unixtime(date_string):
    date_format = "%a %b %d %H:%M:%S %z %Y"
    dt = datetime.strptime(date_string, date_format)
    return int(dt.timestamp())
    

@app.route('/')
def index():
    return '<a href="/auth/twitter">Login with Twitter</a>'

@app.route('/auth/twitter')
def auth_twitter():
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth_url = auth.get_authorization_url()
    return redirect(auth_url)

@app.route('/auth/twitter/callback')
def auth_twitter_callback():
    token = request.args.get('oauth_token')
    verifier = request.args.get('oauth_verifier')
    print(token)
    print(verifier)
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth.request_token = {
        'oauth_token': token,
        'oauth_token_secret': verifier
    }
    auth.get_access_token(verifier)
    access_token = auth.access_token
    access_token_secret = auth.access_token_secret

    api = tweepy.API(auth)
    user = api.verify_credentials()
    user_json = json.dumps(user._json)
    insert_user(user)
    return user_json

def insert_user(user):
    insert_query = """INSERT INTO twitter_user (
        user_id, name, screen_name, location, description, 
        url, followers_count, friends_count, listed_count, favourites_count, 
        utc_offset, time_zone, geo_enabled, verified, statuses_count, 
        lang, profile_background_image_url, profile_background_image_url_https, profile_image_url, profile_image_url_https, 
        created_at, updated_at) 
        VALUES (%s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, 
        %s, %s, %s, %s, %s, 
        %s, %s, %s, %s, %s, 
        %s, %s)"""
    if user.url is None:
        user.url = ''
    if user.utc_offset is None:
        user.utc_offset = 0
    if user.lang is None:
        user.lang = ''
    if user.utc_offset is None:
        user.utc_offset = ''
    if user.profile_background_image_url is None:
        user.profile_background_image_url = ''
    if user.profile_background_image_url_https is None:
        user.profile_background_image_url_https = ''
    if user.time_zone is None:
        user.time_zone = ''
    values = (str(user.id), user.name, user.screen_name, user.location, user.description,
        user.url, str(user.followers_count), str(user.friends_count), str(user.listed_count), str(user.favourites_count),
        str(user.utc_offset), user.time_zone, str(int(user.geo_enabled)), str(int(user.verified)), str(user.statuses_count),
        user.lang, user.profile_background_image_url, user.profile_background_image_url_https, user.profile_image_url, user.profile_image_url_https, 
        str(user.created_at.timestamp()), str(int(time.time())))
    print(insert_query)
    cursor.execute(insert_query, values)
    cnx.commit()

if __name__ == '__main__':
    date_string = "Tue Apr 10 14:08:55 +0000 2018"
    print(str_to_unixtime(date_string))
    app.run(debug=True, host=host, port=port)
    cursor.close()
    cnx.close()

