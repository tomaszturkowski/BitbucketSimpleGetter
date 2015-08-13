<?php

namespace BitbucketSimpleGetter;

use GuzzleHttp\Client as Client;

/**
 * This file is part of the BitbucketSimpleGetter package.
 *
 * @author Tomasz Turkowski <tomasz.turkowski@gmail.com>
 * @url https://github.com/tomaszturkowski
 * @license MIT
 */
class Api
{
    // Bitbucket API Settings
    const BITBUCKET_API_URL = 'https://bitbucket.org/api/';
    const BITBUCKET_API_VER = '1.0';

    // Decode json result at the end
    const API_DECODE_JSON = true;

    private $username = null;
    private $password = null;
    private $bitbucketArea = null;
    private $repoOwner = null;
    private $repoName = null;
    private $repoArea = null;

    private $configRequired = ['bitbucketArea', 'repoOwner', 'repoName', 'username', 'password'];

    private $decodeJson = null;

    private $client = null;

    public function __construct(
        $bitbucketConfig,
        $decodeJson = self::API_DECODE_JSON
    ) {

        if ($this->validateCofnig($bitbucketConfig)) {
            $this->setBitbucketArea($bitbucketConfig['bitbucketArea']);
            $this->setRepoOwner($bitbucketConfig['repoOwner']);
            $this->setRepoName($bitbucketConfig['repoName']);
            $this->setUsername($bitbucketConfig['username']);
            $this->setPassword($bitbucketConfig['password']);
            $this->setDecodeJson($decodeJson);
        } else {
            throw new \Exception('Config array doesn\'t contain all required keys');
        }

    }

    /**
     * Returns base uri
     * @return string
     */
    protected function getBaseUri()
    {
        return self::BITBUCKET_API_URL . self::BITBUCKET_API_VER . '/' . $this->getBitbucketArea() . '/' . $this->getRepoOwner() . '/' . $this->getRepoName() . '/';
    }

    /**
     * Getter for Guzzle Client
     * @return Client|null
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client(['base_uri' => $this->getBaseUri()]);
        }

        return $this->client;
    }

    /**
     * Returns respond from API query
     * @param string $repoArea
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function queryApi($repoArea)
    {
        return $this->getClient()->get($repoArea, $this->getAuth());
    }

    /**
     * Returns array with username and password for basic auth
     * @return array
     */
    private function getAuth()
    {
        return ['auth' => [$this->username, $this->password]];
    }

    /**
     * Returns content of body from the result of API query
     * @param string|null $repoArea
     * @return json_object|string
     */
    protected function getResponse($repoArea)
    {
        $response = $this->queryApi($repoArea)->getBody()->getContents();

        if ($this->getDecodeJson()) {
            $response = json_decode($response);
        }

        return $response;
    }

    public function query($repoArea)
    {
        return $this->getResponse($repoArea);
    }

    /**
     * @return string
     */
    protected function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    protected function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    protected function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    protected function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    protected function getRepoOwner()
    {
        return $this->repoOwner;
    }

    /**
     * @param string $repoOwner
     */
    protected function setRepoOwner($repoOwner)
    {
        $this->repoOwner = $repoOwner;
    }

    /**
     * @return string
     */
    protected function getRepoName()
    {
        return $this->repoName;
    }

    /**
     * @param string $repoName
     */
    protected function setRepoName($repoName)
    {
        $this->repoName = $repoName;
    }

    /**
     * @return string
     */
    protected function getRepoArea()
    {
        return $this->repoArea;
    }

    /**
     * @param string $repoArea
     */
    protected function setRepoArea($repoArea)
    {
        $this->repoArea = $repoArea;
    }

    /**
     * @return string
     */
    protected function getBitbucketArea()
    {
        return $this->bitbucketArea;
    }

    /**
     * @param string $bitbucketArea
     */
    protected function setBitbucketArea($bitbucketArea)
    {
        $this->bitbucketArea = $bitbucketArea;
    }

    /**
     * @return bool
     */
    protected function getDecodeJson()
    {
        return $this->decodeJson;
    }

    /**
     * @param bool $decodeJson
     */
    protected function setDecodeJson($decodeJson)
    {
        $this->decodeJson = $decodeJson;
    }

    /**
     * @return array
     */
    protected function getConfigRequired()
    {
        return $this->configRequired;
    }

    /**
     * @param $bitbucketConfig
     * @return bool
     */
    protected function validateConfig($bitbucketConfig)
    {
        if(0 === count(array_diff($this->getConfigRequired(), array_keys($bitbucketConfig))))
        {
            return true;
        }

        return false;
    }


}