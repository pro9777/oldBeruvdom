<?php

namespace App\Services\AmoCrm;

use AmoCRM\Collections\NotesCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\NoteType\CommonNote;
use AmoCRM\Models\Unsorted\FormUnsortedModel;
use App\Contracts\Crm\AddNotesInterface;
use App\Contracts\Crm\GetAmoCRMApiClientInterface;
use Darryldecode\Cart\CartCollection;
use Illuminate\Support\Facades\Log;

/** Добавление примечания */
class AddNotesProducts implements AddNotesInterface
{

    public function __construct(
        private GetAmoCRMApiClientInterface $amoCRMApiClient,
    ) {
    }


    public function add(FormUnsortedModel $formUnsortedModel, CartCollection $products): NotesCollection
    {
        $apiClient = $this->amoCRMApiClient->get();

        // Создаем новый объект коллекции примечаний.
        $notesCollection = new NotesCollection();

        // Создаем новый объект примечания сервисного сообщения.
        $serviceMessageNote = new CommonNote();

        $text = '';
        foreach ($products as $product) {
            // Формирование строки с атрибутами продукта
            $attributesMessage = '';
            if (!empty($product->attributes['productAttributes'])) {
                foreach ($product->attributes['productAttributes'] as $attr) {
                    $attributesMessage .= "{$attr['title']} : {$attr['value']} \n";
                }
            }

            // Де структуризация данных продукта для упрощения доступа
            $quantity = $product['quantity'];
            $priceOne = $product['price'];
            $totalPrice = $priceOne * $quantity;
            $href = $product['attributes']['href'];

            // Формирование итогового сообщения о продукте
            $text .= <<<TEXT
------------------------------------------------------------------------------------------
===Ссылка на товар===
https://beruvdom.ru/{$href}
===Атрибуты===
$attributesMessage
===Количество===
$quantity
===Цена одного товара===
{$priceOne} р
===Общая цена===
{$totalPrice} р
------------------------------------------------------------------------------------------

TEXT;
        }

        // Id сделки
        $idLead = $formUnsortedModel->getLead()->getId();
        // Устанавливаем ID сущности для примечания, текст примечания, сервис-источник и ID создателя.
        $serviceMessageNote->setEntityId($idLead)
            ->setText($text)
            ->setCreatedBy(0);


        // Добавляем в коллекцию созданные примечания.
        $notesCollection->add($serviceMessageNote);


        // Пытаемся отправить коллекцию примечаний через API в AmoCRM для сущности типа "Сделки".
        try {
            $leadNotesService = $apiClient->notes(EntityTypesInterface::LEADS);
            $leadNotesService->add($notesCollection);
            return $notesCollection;
        } catch (AmoCRMApiException $e) {
            // Записываем ошибку в лог и прерываем выполнение.
            Log::error("Ошибка при отправке коллекции примечаний через API в AmoCRM: " . $e->getMessage(), [
                'exception' => $e
            ]);

            return $e;
        }
    }
}
