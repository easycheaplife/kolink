from flask import Flask, redirect, request
import tweepy

app = Flask(__name__)

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'
callback_url = 'https://gold-breads-occur.loca.lt/auth/twitter/callback'

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
    verifier = request.args.get('oauth_verifier')
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback_url)
    auth.request_token = {
        'oauth_token': request.args.get('oauth_token'),
        'oauth_token_secret': request.args.get('oauth_verifier')
    }
    auth.get_access_token(verifier)
    access_token = auth.access_token
    access_token_secret = auth.access_token_secret

    api = tweepy.API(auth)
    user = api.verify_credentials()
    print(user)
    return f"Logged in as {user.screen_name}"

if __name__ == '__main__':
    app.run()
