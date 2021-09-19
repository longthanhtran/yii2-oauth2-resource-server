# Yii2 based OAuth2 Resource Server

## Introduction.

The package is a wrapper with League's OAuth2 Server package to implement
Resource Server function. This take bearer `access_token` and validates against
define OAuth2 authz server before accepting the request.

Current support grant to communicate with OAuth2 authz server is
`client_credentials`

## Setup.

### Parameters.

* Prepare the pair of `clientId` and `clientSecret` inside
  `@app/config/params.php` file. Authorization Server url also has it detail.

```php
...
  'resourceServer' => [
    'authzServerUrl' => 'your-oauth-authz-server-url',
  ],
  'clientCredentials' => [
    'clientId' => 'your-client-id',
    'clientSecret' => 'your-client-secret',
  ]
...
```

### OAuthRequester component

* Inside `@app/config/web.php`, put component definition for `OAuthRequest`

```php
...
  'oauthRequester' => [
    'class' => 'longthanhtran\oauth2\filters\OAuthRequester'
  ]
...
```

## Usage

From your (rest) controller, attach the `RequestValidator` in behaviors
function, e.g

```php
public function behaviors()
{
  $behaviors = parent::behaviors();

  $behaviors['authenticator'] = [
    'class' => 'longthanhtran\oauth2\filters\RequestValidator'
  ];

  return $behaviors;
}
```

