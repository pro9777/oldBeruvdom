<?php

namespace App\Services\AmoCrm;


use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\Unsorted\FormsUnsortedCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Enum\Tags\TagColorsEnum;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use AmoCRM\Models\Unsorted\FormsMetadata;
use AmoCRM\Models\Unsorted\FormUnsortedModel;
use App\Contracts\Crm\AddLeadInterface;
use App\Contracts\Crm\GetAmoCRMApiClientInterface;
use Illuminate\Support\Facades\Log;

class AddLead implements AddLeadInterface
{
    public function __construct(
        private GetAmoCRMApiClientInterface $amoCRMApiClient,
    ) {
    }

    /**
     * @param string $name
     * @param string $number
     * @param string $leadName
     * @param int $price
     * @param string $SourceName
     *
     * @return FormUnsortedModel
     * @throws AmoCRMApiException
     * @throws \AmoCRM\Exceptions\AmoCRMMissedTokenException
     * @throws \AmoCRM\Exceptions\AmoCRMoAuthApiException
     * @throws \AmoCRM\Exceptions\BadTypeException
     */
    public function add(
        string $name,
        string $number,
        string $leadName,
        int $price = 0,
        string $tagName = '',
        string $SourceName = 'Beruvdom.ru'
    ): FormUnsortedModel {
        $apiClient = $this->amoCRMApiClient->get();

        $unsortedService = $apiClient->unsorted(); // Получение сервиса для работы с неразобранными сделками

        $formsUnsortedCollection = new FormsUnsortedCollection(); // Создание коллекции для неразобранных сделок
        $formUnsorted = new FormUnsortedModel(); // Создание модели неразобранной сделки
        $formMetadata = new FormsMetadata(); // Создание объекта метаданных формы
        $formMetadata
            ->setFormId(time()) // Установка идентификатора формы
            ->setFormName('Обратная связь') // Установка названия формы
            ->setFormPage('BERUVDOM.RU') // Установка URL страницы, на которой размещена форма
            ->setFormSentAt(time()) // Установка времени отправки формы
            ->setReferer('https://beruvdom.ru/') // Установка источника перехода пользователя
            ->setIp('192.168.0.1'); // Установка IP адреса пользователя


        //Настройка сделки и контакта для неразобранного лида
        $unsortedLead = new LeadModel(); // Создание модели сделки
        $unsortedLead->setName($leadName) // Установка названия сделки
        ->setPrice($price); // Установка цены сделки

        if ($tagName) {
            // Создание и настройка коллекции тегов для сделки
            $tagsCollection = new TagsCollection();
            $tag = new TagModel();
            $tag->setName($tagName); // Установка имени тега
            $tagsCollection->add($tag);
            $tag->setColor(TagColorsEnum::LIGHT_RED);
            // Добавление коллекции тегов к сделке
            $unsortedLead->setTags($tagsCollection);
        }


        // Создание фильтра для поиска контактов по номеру телефона
        //БАГ //+798883698889 записывает не правильно пишет +7798883698889
        $number = str_replace([' ', '+'], '', $number); // Номер телефона

        // Проверяем, если в слове ровно 11 цифр, удаляем первую цифру
        if (strlen($number) == 11) {
            $number = substr($number, 1);
        }

        try {
            // Создаем фильтр для поиска
            $filter = new ContactsFilter();
            $filter->setQuery($number);


            // Выполняем запрос к API для поиска контактов с указанным номером телефона
            $contact = $apiClient->contacts()->get($filter)[0];
        } catch (AmoCRMApiNoContentException $e) {
            $contact = null; // Установка $contact в null или выполнение другой логики
        }

        $number_count = mb_strlen($number, "UTF-8"); // Количество символов в номере
        // Проверка есть ли номер телефона
        if ($contact) {
            $unsortedContact = $contact;
        } else {
            //Настройка контакта
            $unsortedContact = new ContactModel(); // Создание модели контакта
            $unsortedContact->setName($name); // Установка имени контакта
            $contactCustomFields = new CustomFieldsValuesCollection(
            ); // Создание коллекции пользовательских полей для контакта
            $phoneFieldValueModel = new MultitextCustomFieldValuesModel(
            ); // Создание модели значения пользовательского поля
            $phoneFieldValueModel->setFieldCode('PHONE'); // Установка кода поля (телефон)
            $phoneFieldValueModel->setValues(
                (new MultitextCustomFieldValueCollection())
                    ->add((new MultitextCustomFieldValueModel())->setValue("+7$number"))
            );
            $unsortedContact->setCustomFieldsValues(
                $contactCustomFields->add($phoneFieldValueModel)
            ); // Добавление пользовательского поля к контакту
        }

        $unsortedContactsCollection = new ContactsCollection(); // Создание коллекции контактов
        $unsortedContactsCollection->add($unsortedContact); // Добавление контакта в коллекцию

        // Добавление неразобранная лида в amoCRM
        $formUnsorted
            ->setSourceName($SourceName) // Установка названия источника лида
            ->setSourceUid('my_unique_uid') // Установка уникального идентификатора источника
            ->setCreatedAt(time()) // Установка времени создания лида
            ->setMetadata($formMetadata) // Установка метаданных формы
            ->setLead($unsortedLead) // Привязка сделки к неразобранному лиду
            ->setPipelineId(7811966) // Установка идентификатора воронки
            ->setContacts($unsortedContactsCollection); // Добавление контактов к лиду


        $formsUnsortedCollection->add($formUnsorted); // Добавление неразобранной сделки в коллекцию

        try {
            $formsUnsortedCollection = $unsortedService->add(
                $formsUnsortedCollection
            ); // Попытка добавить неразобранные сделки в amoCRM
        } catch (AmoCRMApiException $e) {
            // Запись в лог
            Log::error("Ошибка при добавлении неразобранных сделок в amoCRM: {$e->getMessage()}", [
                'exception' => $e,
            ]);
            // Дополнительно можно обработать ошибку, например, отправить уведомление, перенаправить пользователя, и т.д.
        }
        $formUnsorted = $formsUnsortedCollection->first(); // Получение первой сделки из коллекции после добавления

        return $formUnsorted;
    }
}
