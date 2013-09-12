<?php

namespace SWP\FrontendBundle\Service;

class TwitterService
{
    protected $connection;

    public function __construct($cusumerKey = null, $consumerSecret = null, $accessToken = null, $accessTokenSecret = null)
    {
        // nasty way to get the twitter oauth
        require_once("../vendor/abraham/twitteroauth/twitteroauth/twitteroauth.php");

        $this->connection = new \TwitterOAuth($cusumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    }

    public function getTweets($twitterUser, $numberOfTweets = 5)
    {
        if ($this->connection) {
            return $this->connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $twitterUser . "&count=" . $numberOfTweets);
        }

        return null;
    }

    public function getTweetsFriends($twitterUser, $numberOfTweets = 5)
    {
        if ($this->connection) {
            return $this->connection->get("https://api.twitter.com/1.1/statuses/home_timeline.json?screen_name=" . $twitterUser . "&count=" . $numberOfTweets);
        }

        return null;
    }
}