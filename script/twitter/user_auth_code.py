
import tweepy

consumer_key = 'OUdXhQ3o52StkWakpcOCLew8s'
consumer_secret = 'jqdlE388wxf8YutH5O06Fjsa157sJTy0R9h8SNVepf65tYrxWl'

auth = tweepy.OAuthHandler(consumer_key, consumer_secret, callback='oob')
try:
    redirect_url = auth.get_authorization_url()
    print(redirect_url)
except tweepy.TweepError:
    print('Error! Failed to get request token.')

verifier = input('Please enter the verifier code: ')
try:
    token = auth.get_access_token(verifier)
    print(token)
except tweepy.TweepError:
    print('Error! Failed to get access token.')

api = tweepy.API(auth)
user = api.verify_credentials()
print(user)

