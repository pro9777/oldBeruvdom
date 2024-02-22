<?php

declare(strict_types=1);

namespace App\Contracts\Crm;

use AmoCRM\Client\AmoCRMApiClient;

interface GetAmoCRMApiClientInterface
{

    /**
     * Получение токена
     *
     * @return AmoCRMApiClient
     */
    public function get(): AmoCRMApiClient;

}
