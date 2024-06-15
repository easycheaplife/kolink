import requests
import os


api_key = os.getenv("GEMINI_API_KEY")
print(api_key)
url = "https://gemini.googleapis.com/v1/text/generate"

headers = {"Authorization": f"Bearer {api_key}", "Content-Type": "application/json"}
data = {
        "prompt": "Write a short story about a robot who falls in love with a human.",
        "model": "gemini-pro",
        "temperature": 0.7
        }

response = requests.post(url, headers=headers, json=data)

if response.status_code == 200:
    print(response.json()['generated_text'])
else:
    print(f"Error: {response.status_code}")
