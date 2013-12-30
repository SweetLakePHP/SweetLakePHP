<?php

namespace SWP\FrontendBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Doctrine\Common\Cache\FilesystemCache;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\DefaultCacheStorage;

class TwitterService
{
    protected $client;

    public function __construct($consumerKey = null, $consumerSecret = null, $accessToken = null, $accessTokenSecret = null, $rootDir, $environment)
    {
        $this->client = new Client('https://api.twitter.com/{version}', array(
            'version' => '1.1'
        ));

        // Add the cache plugin to the client object
        $this->client->addSubscriber(new CachePlugin(array(
            'storage' => new DefaultCacheStorage(
                new DoctrineCacheAdapter(
                    new FilesystemCache($rootDir . '/cache/' . $environment . '/guzzle')
                ),
                'twitter-',  // Key prefix
                3600 // TTL
            )
        )));

        // Sign all requests with the OauthPlugin
        $this->client->addSubscriber(new OauthPlugin(array(
            'consumer_key'    => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token'           => $accessToken,
            'token_secret'    => $accessTokenSecret
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
