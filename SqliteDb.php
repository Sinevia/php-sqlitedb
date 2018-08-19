<?php

class SqliteDb {

    private $apiUrl = null;
    private $apiKey = null;

    function __construct($apiUrl, $apiKey) {        
        $this->setApiUrl($apiUrl);
        $this->setApiKey($apiKey);
    }

    function exec($sql) {
        $http = new Sinevia\HttpClient($this->getApiUrl());
        $result = $http->post([
            'api_key' => $this->getApiKey(),
            'sql' => $sql,
        ]);
        if ($http->getResponseStatus() != 200) {
            return ['status' => 'error', 'message' => 'Response not 200, but ' . $http->getResponseStatus()];
        }
        $responseJson = $http->getResponseBody();
        $response = json_decode($responseJson, true);
        if ($response == false) {
            return ['status' => 'error', 'message' => 'Response not JSON, but ' . $responseJson];
        }
        return $result;
    }

    function getApiUrl() {
        return $this->apiUrl;
    }

    function getApiKey() {
        return $this->apiKey;
    }

    function setApiUrl($apiUrl) {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
        return $this;
    }

}
