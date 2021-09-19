<?php

namespace longthanhtran\oauth2\Psr7;


class ServerRequest extends \GuzzleHttp\Psr7\ServerRequest
{
    public function __construct(Request $request)
    {
        parent::__construct(
            $request->method,
            $request->url,
            $request->headers->toArray(),
            $request->rawBody
        );
    }

    public function getParsedBody()
    {
        return Yii::$app->request->getBodyParams();
    }

    public function getQueryParams(): array
    {
        return Yii::$app->request->getQueryParams();
    }
}
