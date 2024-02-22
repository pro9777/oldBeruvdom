<?php

declare(strict_types=1);

namespace App\Contracts\Crm;

use League\OAuth2\Client\Token\AccessTokenInterface;

/** Интерфейс сохранения токена */
interface SaveTokenInterface
{
    /**
     * Сохранение токена
     *
     * @param AccessTokenInterface $accessToken
     * @return void
     */
    public function save(AccessTokenInterface $accessToken): void;
}
