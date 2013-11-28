<?php

namespace SWP\FrontendBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class TwitterService
{
    protected $client;

    public function __construct($consumerKey = null, $consumerSecret = null, $accessToken = null, $accessTokenSecret = null)
    {
        $this->client = new Client('https://api.twitter.com/{version}', array(
            'version' => '1.1'
        ));

        // Sign all requests with the OauthPlugin
        $this->client->addSubscriber(new OauthPlugin(array(
            'consumer_key'  => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token'       => $accessToken,
            'token_secret'  => $accessTokenSecret
        )));
    }

    public function getTweets($twitterUser, $numberOfTweets = 5)
    {
        return $this->client->get("statuses/user_timeline.json?screen_name=" . $twitterUser . "&count=" . $numberOfTweets)->send()->getBody();
    }

    public function getTweetsFriends($twitterUser, $numberOfTweets = 5)
    {
        return $this->client->get("statuses/home_timeline.json?screen_name=" . $twitterUser . "&count=" . $numberOfTweets)->send()->getBody();
    }
}
