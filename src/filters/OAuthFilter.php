<?php

namespace longthanhtran\oauth2\filters;


use yii\base\ActionFilter;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Yii;

class OAuthFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $publicKeyPath = Yii::$app->params['resourceServer']['publicKey'];

        $resourceServer = new ResourceServer(
            new AccessTokenRepository(),
            $publicKeyPath
        );

        try {
            $resourceServer->validateAuthenticatedRequest(
                new ServerRequest(
                    Yii::$app->getRequest()
                )
            );
        } catch (OAuthServerException $authServerException) {
            $response = Yii::$app->response;
            $response->statusCode = $authServerException->getHttpStatusCode();
            $response->data = [ 'error' => $authServerException->getMessage() ];

            return false;
        }

        return parent::beforeAction($action);
    }
}
