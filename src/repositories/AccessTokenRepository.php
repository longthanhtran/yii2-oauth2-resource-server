<?php

namespace longthanhtran\oauth2\repositories;


use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Yii;


class AccessTokenRepository implements AccessTokenRepositoryInterface
{

    public function getNewToken(ClientEntityInterface $clientEntity,
                                array $scopes,
                                $userIdentifier = null)
    {
        // No implementation for Resource Server
    }

    public function persisNewAccessToken(
        AccessTokenEntityInterface $accessTokenEntity
    )
    {
        // No implementation for Resource Server
    }

    public function revokeAccessToken($tokenId)
    {
        // No implementation for Resource Server
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $oauthRequester = Yii::$app->oauthRequester;

        return ! $oauthRequester->tokenValid($tokenId);
    }
}
