# Facebook-Messenger-Auto-Reply-using-PHP-NLP

# Configurations
update config.php with your database and Facebook App configurations.
```php
    'host' => '',
    'username' => '',
    'password' => '',
    'databse' => '',
    'hubVerifyToken' => 'hub verify token you set',
    'page_id' => 'your page ID obtained from app settings',
    'accessToken' => 'access token provided for the app',
    'admin_sender_ID' => 'To obtain the sender ID, send a message to the bot, then check the database for your sender ID'
```


# Functionality
- The bot will recieve a message
- It will tokenize the message to check the cosine smilarity and try to get the most suitable answer from the database.
- It will send the query response obtained after searching wikipedia for the word or set of words recieved, if the cosine similarity is lower.
- The admin user can teach the bot by providing some example responses. This method can be used to train the bot for specific responses. Even you can put an imoji to the response. Currently the bot can not understand imojis other than "thumbsup".

# How to train
Send a message like this,
```
learn <Question>,<Answer> 
```
Example:
```
learn what are the types of services you offer?, We provide industrial level web application development and API integration services.
```
# Responses
```
Training: 'what are the types of services you offer?'
```
```
Message: 'send me the services you offer?'
```
```
Response: 'We provide industrial level web application development and API integration services.'
```
# Wikipedia API
```
https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exlimit=max&format=json&exsentences=1&origin=*&exintro=&explaintext=&generator=search&gsrlimit=23&gsrsearch=chess
```
# Demo
Master Wiki (Messenger) : http://m.me/wikipedia.lk

Master Wiki (Web): http://masterwiki.lankahot.net/

# Contributions
Please contribute to make this more creative. For the repository and do the changes, then send me a pull request mentioning your changes and results. Feel free contact me for any clarifications. 