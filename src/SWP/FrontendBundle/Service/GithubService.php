<?php

namespace SWP\FrontendBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Doctrine\Common\Cache\FilesystemCache;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\DefaultCacheStorage;

class GithubService
{
    protected $client;
    protected $username;
    protected $repository;

    public function __construct($username, $repository, $rootDir, $environment)
    {
        $this->username   = $username;
        $this->repository = $repository;

        $this->client = new Client('https://api.github.com');

        // Add the cache plugin to the client object
        $this->client->addSubscriber(new CachePlugin(array(
            'storage' => new DefaultCacheStorage(
                new DoctrineCacheAdapter(
                    new FilesystemCache($rootDir . '/cache/' . $environment . '/guzzle')
                ),
                'github-',  // Key prefix
                18000 // TTL
            )
        )));
    }

    public function getAllContributors()
    {
        return $this->client->get('repos/' . $this->username . '/' . $this->repository . '/contributors')->send()->getBody();
    }
}
