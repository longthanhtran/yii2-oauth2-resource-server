<?php

namespace longthanhtran\oauth2\filters;


use League\OAuth2\Server\Exception\OAuthServerException;
use GuzzleHttp\Client;
use Yii;


class OAuthRequester
{
    private $client;
    private $cache;

    public function __construct()
    {
        $this->cache = Yii::$app->cache;

        $this->client = new Client([
            'base_uri' => Yii::$app->params['resourceServer']['authzServerUrl'],
            'timeout'  => 2.0
        ]);
    }

    /**
     * Ask OAuth2 authz server if the $token is valid
     * @param string $token
     * @return boolean
     */
    public function tokenValid($token)
    {
        $bearerToken = $this->cache->getOrSet(
            'bearerToken',
            function() {
                return $this->getNewAccessToken();
            },
            300
        );

        $response = $this->client->request('POST', 'validate', [
            'headers' => [
                'Authorization' => "Bearer ${bearerToken}",
            ],
            'form_params' => [
                'access_token' => $token
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents())->token_valid;
        }

        return false;
    }

    private function getNewAccessToken()
    {
        $clientId     = Yii::$app->params['clientCredentials']['clientId'];
        $clientSecret = Yii::$app->params['clientCredentials']['clientSecret'];

        $response = $this->client->request('POST', 'token', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'grant_type'    => 'client_credentials',
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $responseObject =$response->getBody()->getContents();
            return json_decode($responseObject)->access_token;
        }

        throw new OAuthServerException();
    }
}
