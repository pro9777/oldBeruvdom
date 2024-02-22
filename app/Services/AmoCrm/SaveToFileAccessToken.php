<?php

declare(strict_types=1);

namespace App\Services\AmoCrm;

use App\Contracts\Crm\SaveTokenInterface;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Token\AccessTokenInterface;

class SaveToFileAccessToken implements SaveTokenInterface
{

    public function save(AccessTokenInterface $accessToken): void
    {
        // Кодирование данных в JSON
        $jsonData = json_encode($accessToken, JSON_PRETTY_PRINT);

        // Путь к файлу
        $filePath = storage_path('./oauth_tokens/token.json');

        // Сохранение JSON данных в файл
        $result = file_put_contents($filePath, $jsonData);

        if ($result === false) {
            // Запись в лог об ошибке
            Log::error("Не удалось сохранить данные в файл: {$filePath}");
        } else {
            // Запись в лог об успешном сохранении
            Log::info("Данные успешно сохранены в файл: {$filePath}");
        }
    }
}
