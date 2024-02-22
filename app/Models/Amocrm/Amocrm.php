<?php

namespace App\Models\Amocrm;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Support\Facades\Alert;

class Amocrm extends Model
{
    use HasFactory;

    protected $table = 'amocrm';

    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = [
        'subdomain',
        'client_id',
        'client_secret',
        'code',
        'redirect_uri',
        'access_token',
        'refresh_token',
        'token_type',
        'expires_in',
        'endTokenTime',
        'created_at',
        'updated_at',
    ];

    public static function addRefreshToken()
    {
        $getRows = self::first();
        $subdomain = $getRows->subdomain;
        $client_id = $getRows->client_id;
        $client_secret = $getRows->client_secret;
        $code = $getRows->code;
        $redirect_uri = $getRows->redirect_uri;
        $access_token = $getRows->access_token;


        //если токена нет добавляем его
        if (empty($access_token)) {

            $getToken = self::createToken($subdomain, $client_id, $client_secret, $code, $redirect_uri);
            if (is_array($getToken)) {
                $getRows = Amocrm::updateOrCreate(
                    ['id' => 1],
                    $getToken
                );
                return 'Токен успешно получен и сохранен!';
            }
        }
        //токен(refresh_token)  для обновления основного токена (access_token)
        $refresh_token = $getRows->refresh_token;

        //время когда основной токен (access_token) просрочится
        $expires_in = $getRows->expires_in;
//        dd(date("d-m-Y H:i:s", $endTokenTime). '  ============  '. date("d-m-Y H:i:s", time()) );
        //если прошло время токена получаем новый
        if (empty($expires_in) || $expires_in < time()) {

            /* запрашиваем новый токен */
            $newToken = self::accessToken($subdomain, $client_id, $client_secret, $refresh_token, $redirect_uri);


//            $timeToken = $newToken['expires_in'] + time();
//
//            $newToken['expires_in'] = $timeToken;

            if (is_array($newToken)) {
                $sss = Amocrm::updateOrCreate(
                    ['id' => 1],
                    $newToken
                );
                return 'Токен успешно (ОБНОВЛЕН) и сохранен!';
            }
        }
        return 'Токен НЕ НУЖНАЕТСЯ В ОБНОВЛЕНИИ';
    }

    //получаем токены с amocrm
    public static function createToken($subdomain, $client_id, $client_secret, $code, $redirect_uri)
    {

        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
        /** Соберем данные для запроса */
        $data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
        ];
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            $error = 'Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
            return back()->withErrors([$error]);
//            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }


        $response = json_decode($out, true);

        $arrParamsAmo = [
            "access_token" => $response['access_token'],
            "refresh_token" => $response['refresh_token'],
            "token_type" => $response['token_type'],
            "expires_in" => $response['expires_in'],
            "endTokenTime" => $response['expires_in'] + time(),
        ];

        return $arrParamsAmo;
    }

    public static function accessToken($subdomain, $client_id, $client_secret, $refresh_token, $redirect_uri)
    {
        $url = 'oauth2/access_token';
        $link = "https://$subdomain.amocrm.ru/$url";

        $data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'redirect_uri' => $redirect_uri,
        ];


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];


        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            $error = 'Ошибка обновления токена: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
            return back()->withErrors([$error]);
        }

        return json_decode($out, true);
    }


    //добавление контакта
//    public static function addUnsorted()
//    {
//        self::addRefreshToken();
//        $amocrm = self::first();
//
//        $subdomain = $amocrm->subdomain;
//        $access_token = $amocrm->access_token;
//
//
//        $url = '/api/v4/leads/unsorted/1735413/link';
//        $link = "https://$subdomain.amocrm.ru/$url";
//
////        $contact = [
////            'link' => [
////                'entity_id' => 1735413,
////                'entity_type' => 'leads',
////            ]
////        ];
//        $contact = '
//                {
//                    "link": {
//                        "entity_id": 93144801,
//                        "entity_type": "leads"
//                    }
//                }
//        ';
////        dd(json_encode($contact));
//        $headers = [
//            'Authorization: Bearer ' . $access_token,
//            'Content-Type: application/json'
//        ];
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
//        curl_setopt($curl, CURLOPT_URL, $link);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_HEADER, false);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $contact);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
//        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
//        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        curl_close($curl);
//
//        $code = (int)$code;
//        $errors = [
//            400 => 'Bad request',
//            401 => 'Unauthorized',
//            403 => 'Forbidden',
//            404 => 'Not found',
//            500 => 'Internal server error',
//            502 => 'Bad gateway',
//            503 => 'Service unavailable',
//        ];
//
//        try {
//            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
//            if ($code < 200 || $code > 204) {
//                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
//            }
//        } catch (Exception $e) {
//            die('Ошибка добавлении контакта: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
//        }
//        $out = json_decode($out, true);
//        $out = $out['_embedded']['contacts'][0]['id'];
//        return $out;
//    }

    public static function addContact($number)
    {


        $amocrm = self::first();
        $subdomain = $amocrm->subdomain;
        $access_token = $amocrm->access_token;
        $getContact = self::getContact($subdomain, $access_token, $number['number']);

        if (!empty($getContact)) {
            return $getContact['_embedded']['contacts'][0]['id'];
        } else {
            $url = 'api/v4/contacts';
            $link = "https://$subdomain.amocrm.ru/$url";

            $contactProd = [
                0 => [
                    'first_name' => $number['name'],
//                    'responsible_user_id' => 0,
                    'custom_fields_values' => [
                        [
                            'field_name' => 'Телефон',
                            'field_code' => 'PHONE',
                            'values' => [
                                [
                                    'value' => $number['number'],
                                    'enum_code' => 'MOB'
                                ]
                            ]
                        ],
                        [
                            'field_name' => 'Email',
                            'field_code' => 'EMAIL',
                            'values' => [
                                [
                                    'value' => $number['email'] ?? '',
                                    'enum_code' => 'PRIV',
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $headers = [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contactProd));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $code = (int)$code;
            $errors = [
                400 => 'Bad request',
                401 => 'Unauthorized',
                403 => 'Forbidden',
                404 => 'Not found',
                500 => 'Internal server error',
                502 => 'Bad gateway',
                503 => 'Service unavailable',
            ];

            try {
                /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
                if ($code < 200 || $code > 204) {
                    throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
                }
            } catch (Exception $e) {
                die('Ошибка добавлении контакта: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
            }
            $out = json_decode($out, true);
            $out = $out['_embedded']['contacts'][0]['id'];
            return $out;
        }
    }

    //получение контакта
    public static function getContact($subdomain, $access_token, $number)
    {
//        ?query=
        $url = "api/v4/contacts";
        $link = "https://$subdomain.amocrm.ru/$url?query=$number";
//        dd($link);
        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ];
//        dd($headers);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($out, true);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return $response;
    }

    //добавление сделки
    public static function addTask($idContact, $params)
    {
        $amocrm = self::first();
        $subdomain = $amocrm->subdomain;
        $access_token = $amocrm->access_token;
//        $url = 'api/v4/leads';
        $url = '/api/v4/leads/unsorted/forms';
        $link = "https://$subdomain.amocrm.ru/$url";

        $productsTotal = $params['total'];


        $currentDate = time();
        $taskDev2 = '[
            {
                "request_id": "123",
                "source_name": "ОАО Коспромсервис",
                "source_uid": "a1fee7c0fc436088e64ba2e8822ba2b3",
                "pipeline_id": 3476194,
                "created_at": ' . $currentDate . ',
                "_embedded": {
                    "leads": [
                        {
                            "name": "Заявка БЕРУ В ДОМ",
                            "visitor_uid": "5692210d-58d0-468c-acb2-dce7f93eef87",
                            "price": ' . $productsTotal . ',
                            "custom_fields_values": [
                                {
                                    "field_id": 711795,
                                    "values": [
                                        {
                                            "value": "Дополнительное поле"
                                        }
                                    ]
                                }
                            ],
                            "_embedded": {
                                "tags": [
                                    {
                                        "name": "Тег для примера"
                                    }
                                ]
                            }
                        }
                    ],
                    "contacts": [
                        {
                            "id": ' . $idContact . '
                        }
                    ],
                    "companies": [
                        {
                            "name": "ОАО Коспромсервис"
                        }
                    ]
                },
                "metadata": {
                    "ip": "123.222.2.22",
                    "form_id": ' . $currentDate . ',
                    "form_sent_at": ' . $currentDate . ',
                    "form_name": "Форма заявки для полёта в космос",
                    "form_page": "https://beruvdom.ru/",
                    "referer": "https://beruvdom.ru/"
                }
            }
        ]';
        $taskProd = [
            [
                "request_id" => "123",
                "source_name" => "ОАО Коспромсервис",
                "source_uid" => "a1fee7c0fc436088e64ba2e8822ba2b3",
                "pipeline_id" => 3476194,
                "created_at" => $params['total'],
                "_embedded" => [
                    "leads" => [
                        [
                            "name" => "Заявка БЕРУ В ДОМ",
                            "visitor_uid" => "5692210d-58d0-468c-acb2-dce7f93eef87",
                            "price" => $productsTotal,
                            "custom_fields_values" => [
                                [
                                    "field_id" => 711795,
                                    "values" => [
                                        [
                                            "value" => $params['value']['number']
                                        ]
                                    ]
                                ]
                            ],
                            "_embedded" => [
                                "tags" => [
                                    [
                                        "name" => "beruvdom"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "contacts" => [
                        [
                            "id" => $idContact
                        ]
                    ],
                    "companies" => [
                        [
                            "name" => "ОАО Коспромсервис"
                        ]
                    ]
                ],
                "metadata" => [
                    "ip" => "123.222.2.22",
                    "form_id" => $currentDate,
                    "form_sent_at" => $currentDate,
                    "form_name" => "Форма заявки для полёта в космос",
                    "form_page" => "https://beruvdom.ru/",
                    "referer" => "https://beruvdom.ru/",
                ]
            ]
        ];

        $taskDev = [
            [
                "request_id" => "123",
                "source_name" => "ОАО Коспромсервис",
                "source_uid" => "a1fee7c0fc436088e64ba2e8822ba2b3",
                "created_at" => $currentDate,
                "_embedded" => [
                    "leads" => [
                        [
                            "name" => "Заявка БЕРУ В ДОМ",
                            "visitor_uid" => "5692210d-58d0-468c-acb2-dce7f93eef87",
                            "price" => $productsTotal,
//                            "custom_fields_values" => [
//                                [
////                                    "field_name" => 'Num12',
//                                    "field_name" => "Номер",
//                                    "field_code" => null,
//                                    "field_type" => "text",
//                                    "values" => [
//                                        [
//                                            "value" => $params['value']['number']
//                                        ]
//                                    ]
//                                ]
//                            ],
                            "_embedded" => [
                                "tags" => [
                                    [
                                        "name" => "Тег для примера"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "contacts" => [
                        [
                            "id" => $idContact
                        ]
                    ],
                    "companies" => [
                        [
                            "name" => "ОАО Коспромсервис"
                        ]
                    ]
                ],
                "metadata" => [
                    "ip" => "123.222.2.22",
                    "form_id" => $currentDate,
                    "form_sent_at" => $currentDate,
                    "form_name" => "Форма заявки для полёта в космос",
                    "form_page" => "https://beruvdom.ru/",
                    "referer" => "https://beruvdom.ru/",
                ]
            ]
        ];


        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($taskDev));
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $taskDev444);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
//        dd($curl);
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            die('Ошибка добавление сделки: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

//        $out = [$out];
        $out = strstr($out, '{');
        $out = json_decode($out, true);

        $idTask = $out['_embedded']['unsorted'][0]['_embedded']['leads'][0]['id'];

        return $idTask;
    }


    public static function addLeads($loadsId, $params)
    {
        $amocrm = self::first();
        $subdomain = $amocrm->subdomain;
        $access_token = $amocrm->access_token;
        $url = "/api/v4/leads/notes";
        $link = "https://$subdomain.amocrm.ru/$url";

        $products = $params;
        $text = '';

        $corrDate = date("d-m-Y H:i:s", time());
        if (!empty($products)){
            foreach ($products as $product) {
                $mess = '';
                if (!empty($product->attributes['productAttributes'])){
                    foreach ($product->attributes['productAttributes'] as $attr) {
                        $title = $attr['title'];
                        $value = $attr['value'];
                        $mess .= "$title : $value \n";
                    }
                }

                $quantity = $product['quantity'];
                $priceOne = $product['price'];
                $price = $product['price'] * $product['quantity'];
                $href = $product['attributes']['href'];
                $text .= "
------------------------------------------------------------------------------------------
===Ссылка на товар===
$corrDate
https://beruvdom.ru/$href
===Атрибуты===
$mess
===Количество===
$quantity
===Цена одного товара===
$priceOne р
===Общая цена===
$price р
------------------------------------------------------------------------------------------
                        ";
            }
        }


        $task2 = [
            [
                "entity_id" => $loadsId,
                "note_type" => "common",
                "params" => [
                    "text" => $text
                ]
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($task2));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return json_decode($out);
    }


    //изменение воронки
    public static function statusId()
    {


        $amocrm = self::first();
        $subdomain = $amocrm->subdomain;
        $access_token = $amocrm->access_token;

        $url = 'api/v4/leads';
        $link = "https://$subdomain.amocrm.ru/$url";


        $contactDev = [
            [
                'id' => 2438907,
                'pipeline_id' => 6727618,
                'status_id' => 56932358,
                'price' => 33332,
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contactDev));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch (Exception $e) {
            die('Ошибка добавлении контакта: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
        $out = json_decode($out, true);

        return $out;
    }


}
