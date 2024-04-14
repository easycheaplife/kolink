from flask import Flask, redirect, request
import tweepy
import mysql.connector
import json
import time
import logging
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

logging.basicConfig(filename=log_file, level=logging.DEBUG)
log_file = "user_auth.log"

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
    inser_user_json(user.id, user_json)
    insert_user(user)
    response = {
        "code": 0,
        "message": "",
        "data": user._json
    }

    return response

def inser_user_json(user_id, data):
    try:
        insert_query = "INSERT INTO twitter_user_data (user_id, data) VALUES (%s, %s)"
        logging.info(insert_query)
        values = (str(user_id),  data)
        cursor.execute(insert_query, values)
        cnx.commit()
    except mysql.connector.IntegrityError as e:
        if e.errno == 1062:
            pass
        else:
            logging.error('inser_user_json failed:', e)

def insert_user(user):
    try:
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
        logging.info(insert_query)
        if user.url is None:
            user.url = ''
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


if __name__ == '__main__':
    app.run(debug=True, host=host, port=port)
    cursor.close()
    cnx.close()

