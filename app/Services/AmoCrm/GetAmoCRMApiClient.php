<?php

declare(strict_types=1);

namespace App\Services\AmoCrm;

use AmoCRM\Client\AmoCRMApiClient;
use App\Contracts\Crm\GetAmoCRMApiClientInterface;
use App\Contracts\Crm\SaveTokenInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class GetAmoCRMApiClient implements GetAmoCRMApiClientInterface
{

    public function __construct(
        private SaveTokenInterface $saveToken
    )
    {
    }

    public function get(): AmoCRMApiClient
    {
        $clientId = env('AMOCRM_CLIENT_ID');
        $clientSecret = env('AMOCRM_CLIENT_SECRET');
        $redirectUri = env('AMOCRM_REDIRECT_URI');
        $baseDomain = env('BASE_DOMAIN');

        // Путь к файлу
        $filePath = storage_path('./oauth_tokens/token.json');
        $accessToken = json_decode(file_get_contents($filePath), true);

        $accessTokenObject = new AccessToken([
            'access_token' => $accessToken['access_token'],
            'refresh_token' => $accessToken['refresh_token'],
            'expires' => $accessToken['expires'],
        ]);

        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

        $apiClient->setAccessToken($accessTokenObject)
            ->setAccountBaseDomain($baseDomain)
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken) {
                    $this->saveToken->save($accessToken);
                }
            );
        return $apiClient;
    }
}
