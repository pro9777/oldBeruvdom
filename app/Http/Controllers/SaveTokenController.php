<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Contracts\Crm\SaveTokenInterface;
use Exception;

class SaveTokenController
{

    public function __construct(
        private SaveTokenInterface $saveToken,
        private AmoCRMApiClient $apiClient
    ){}

    public function index()
    {


        if (isset($_GET['referer'])) {
            $this->apiClient->setAccountBaseDomain($_GET['referer']);
        }

        /**
         * Ловим обратный код
         */
        try {
            $accessToken = $this->apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);

            $this->saveToken->save($accessToken);
            return $accessToken;

        } catch (Exception $e) {
            die((string)$e);
        }
    }
}
