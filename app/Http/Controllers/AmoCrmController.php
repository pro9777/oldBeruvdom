<?php

namespace App\Http\Controllers;

use AmoCRM\OAuth2\Client\Provider\AmoCRM;
use Exception;
use Illuminate\Support\Facades\Storage;

class AmoCrmController extends Controller
{
    public function index()
    {
        function amoAddContact($access_token, $arrContactParams) {

            $contacts['request']['contacts']['add'] = array(
                [
                    'name' => $arrContactParams["CONTACT"]["namePerson"],
                    'tags' => 'авто отправка',
                    'custom_fields'	=> [
                        // ИМЯ ПОЛЬЗОВАТЕЛЯ
                        [
                            'id'	=> 518661,
                            "values" => [
                                [
                                    "value" => $arrContactParams["CONTACT"]["namePerson"],
                                ]
                            ]
                        ],
                        // ТЕЛЕФОН
                        [
                            'id'	=> 518139,
                            "values" => [
                                [
                                    "value" => $arrContactParams["CONTACT"]["phonePerson"],
                                ]
                            ]
                        ],
                        // EMAIL
                        [
                            'id'	=> 518595,
                            "values" => [
                                [
                                    "value" => $arrContactParams["CONTACT"]["emailPerson"],
                                ]
                            ]
                        ],
                        // СООБЩЕНИЕ
                        [
                            'id'	=> 532695,
                            "values" => [
                                [
                                    "value" => $arrContactParams["CONTACT"]["messagePerson"],
                                ]
                            ]
                        ]
                    ]
                ]
            );


            /* Формируем заголовки */
            $headers = [
                "Accept: application/json",
                'Authorization: Bearer ' . $access_token
            ];

            $link='https://programmer9777.amocrm.ru/private/api/v2/json/contacts/set';

            $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
            /** Устанавливаем необходимые опции для сеанса cURL  */
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
            curl_setopt($curl,CURLOPT_URL, $link);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($contacts));
            curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl,CURLOPT_HEADER, false);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
            $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
            $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
            curl_close($curl);
            $Response=json_decode($out,true);
//            $account= $Response['response']['account'];
            echo '<b>Данные о пользователе:</b>'; echo '<pre>'; print_r($Response); echo '</pre>';

            return $Response["response"]["contacts"]["add"]["0"]["id"];

        }



        function amoAddTask($access_token, $arrContactParams, $contactId = false) {


            $arrTaskParams = [
                'add' => [
                    0 => [
                        'name'  => $arrContactParams["PRODUCT"]["nameForm"],
                        'price'         => $arrContactParams["PRODUCT"]["price"],
                        'pipeline_id'   => '9168',
                        'tags'          => [
                            'авто отправка',
                            $arrContactParams["PRODUCT"]["nameForm"]
                        ],
                        'status_id'     => '10937736',
                        'custom_fields'	=> [
                            /* ОПИСАНИЕ ЗАКАЗА */
                            [
                                'id'	=> 531865,
                                "values" => [
                                    [
                                        "value" => $arrContactParams["PRODUCT"]["descProduct"],
                                    ]
                                ]
                            ],
                            /* ИМЯ ПОЛЬЗОВАТЕЛЯ */
                            [
                                'id'	=> 525741,
                                "values" => [
                                    [
                                        "value" => $arrContactParams["PRODUCT"]["namePerson"],
                                    ]
                                ]
                            ],
                            /* ТЕЛЕФОН */
                            [
                                'id'	=> 525687,
                                "values" => [
                                    [
                                        "value" => $arrContactParams["PRODUCT"]["phonePerson"],
                                    ]
                                ]
                            ],
                            /* EMAIL */
                            [
                                'id'	=> 525739,
                                "values" => [
                                    [
                                        "value" => $arrContactParams["PRODUCT"]["emailPerson"],
                                    ]
                                ]
                            ],
                            /* СООБЩЕНИЕ */
                            [
                                'id'	=> 528257,
                                "values" => [
                                    [
                                        "value" => $arrContactParams["PRODUCT"]["messagePerson"],
                                    ]
                                ]
                            ],
                        ],

                        'contacts_id' => [
                            0 => $contactId,
                        ],
                    ],
                ],
            ];


            $link = "https://programmer9777.amocrm.ru/api/v2/leads";

            $headers = [
                "Accept: application/json",
                'Authorization: Bearer ' . $access_token
            ];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-
	undefined/2.0");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arrTaskParams));
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HEADER,false);
            curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__)."/cookie.txt");
            curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__)."/cookie.txt");
            $out = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($out,TRUE);

        }

        /* в эту функцию мы передаём текущий refresh_token */
        function returnNewToken($token) {

            $link = 'https://programmer9777.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

            /** Соберем данные для запроса */
            $data = [
                'client_id' => '912119d0-da54-4a1f-8572-c2a8d81d4814',
                'client_secret' => 'py0nOxVhQ6yb1h4QTD9auDN6xMmt2hjtvEjpSXYprc17UXBpEB23hXso5FOcdUxE',
                'grant_type' => 'refresh_token',
                'refresh_token' => $token,
                'redirect_uri' => 'https://beruvdom.ru/amo',
            ];

            /**
             * Нам необходимо инициировать запрос к серверу.
             * Воспользуемся библиотекой cURL (поставляется в составе PHP).
             * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
             */
            $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
            /** Устанавливаем необходимые опции для сеанса cURL  */
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
            curl_setopt($curl,CURLOPT_URL, $link);
            curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
            curl_setopt($curl,CURLOPT_HEADER, false);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
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

            try
            {
                /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
                if ($code < 200 || $code > 204) {
                    throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
                }
            }
            catch(\Exception $e)
            {
                die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
            }

            /**
             * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
             * нам придётся перевести ответ в формат, понятный PHP
             */

            $response = json_decode($out, true);

            if($response) {

                /* записываем конечное время жизни токена */
                $response["endTokenTime"] = time() + $response["expires_in"];

                $responseJSON = json_encode($response);

                /* передаём значения наших токенов в файл */
                $filename = "путь до файла с токеном";
                $f = fopen($filename,'w');
                fwrite($f, $responseJSON);
                fclose($f);

                $response = json_decode($responseJSON, true);
                Storage::disk('resources_views')->put('amo/amo.json', json_encode($response));
                dd($response);
                return $response;
            }
            else {
                return false;
            }

        }

//        returnNewToken('def502008061715336534e1a078090d97f128ade0ab05a1c965eec6ac620f403646955b9c3542652dd477580a70fcbfe9d35a1188ae5f692c012185c8ea20333c64ad2ecde6f65141bbd3ba237716dfc33412986a54fd4b0a4a6c268dba675a738a13f7aed9fbd25018d3e033fbda7904fe4e1673b518ab3d3150d98552709de867d13a5a80be1b2e42b1235b1700971c4caa3e87333ebd8a595a8d5cf587b0e3a0d865d879f1533e0e49f23475a64b151a1249091acf7ad9cebfa056bd5882bb4a48010dfa07b36150091dcb9bfd08930b0cb72d52495042c49d2399deda141fb6c46f52b4ae3897f2e20b4663c64b875de1751f9bc11b7280a22de42ee69934d7a932494079f55410a7a112585dc6b7e0c6ba873015ebb586a021f399a8e5fa9d9013b6fc23c78882a9565b2455111b0d17e781789623afbb4fc2b12ef46c6b10b553851977b792be299baf6ae71f5051977db4aca8cf5f8ad334fdadcb56e473b321333b3fee3c91f7aeff041aa980444da48acaedd395ba2ad44baff08eead473d4f3e1367d5c46d08dc9b36ae6a03247a6e1a41975ab92432a4aa396d3418fbf94b66807863be9625bc346216bc09efa84df352d22c196fdb2c137389f9500169c252b46628e5b79657a52fdc2be013896529707f1a2eacf90e5f5344ed15');

        function amoCRMScript($paramsTask) {

            /* получаем значения токенов из файла */
            $dataToken = file_get_contents("путь до файла с токеном");
            $dataToken = json_decode($dataToken, true);

            /* проверяем, истёкло ли время действия токена Access */
            if($dataToken["endTokenTime"] < time()) {
                /* запрашиваем новый токен */
                $dataToken = returnNewToken($dataToken["refresh_token"]);
                $newAccess_token = $dataToken["access_token"];
            }
            else {
                $newAccess_token = $dataToken["access_token"];
            }

            if($paramsTask["CONTACT"]) {
                $idContact = amoAddContact($newAccess_token, $paramsTask);
            }

            amoAddTask($newAccess_token, $paramsTask, $idContact);

        }

//        amoAddTask($token, $arrContactParams);


//        dd($arrContactParams);
















//        $subdomain = 'programmer9777'; //Поддомен нужного аккаунта
//        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
//
//        /** Соберем данные для запроса */
//        $data = [
//            'client_id' => '912119d0-da54-4a1f-8572-c2a8d81d4814',
//            'client_secret' => 'py0nOxVhQ6yb1h4QTD9auDN6xMmt2hjtvEjpSXYprc17UXBpEB23hXso5FOcdUxE',
//            'grant_type' => 'authorization_code',
//            'code' => 'def5020096d75c576bcd3f59e4021160e130743738539c223e5ea92e6ae9c02cce5cbb533604a07c1f2859fcc65d3d08d34e5ef2e901ec853e07e8e0c38fa66671aef9fba122d197c1cf571d3b9d0fc63825b80b7035cf06d41d60cc804ee62f50c4d543f2dcd07606e42ac6950b546f9de235eb7a23b0e17ea12c706f42cbb010892c4b81e50a3908472d617c59273fc838d477e39a68830cfe3c7e8e16dd12ca50a7763d1a641df3469d64a842f966f3171d5073bcdfc6018e50675a31881134a215970df01b51284c88b817f86e89f7aa3b8c71ee884009cb1edf0d2d99bb234665a385511c79f03c904c8b56ee2191322a7b338a949fe7dbf4cdf9ef1dd3cc0d382639ac9365d919f46da8343a755770e200ec9a424b9cdb89216909f28abc992518b1a88af289c2195626d87bf6426a0a56909add0a2404a8bdc5a669dd009e630e44ee4778e2b7e1e5b458c68bfcc15af45e9d22ea6d3816e9e34df523f5d3ad32a16cd175427945d8c346c848b092579aca38cd2a5f742ee937c794b583f6ae8b8b7bc96b78433844fae6ebae6f9f967f4367826bed67ef3114053488d52ae2acbd29e7360dea609be0a5bef473f37db4dff5d4542d072c1c4febfe25ba2590ff438c2ba9c92a10519304bad6a2dbb6a61865e4c3ee',
//            'redirect_uri' => 'https://beruvdom.ru/amo',
//        ];
//
//        /**
//         * Нам необходимо инициировать запрос к серверу.
//         * Воспользуемся библиотекой cURL (поставляется в составе PHP).
//         * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
//         */
//        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
//        /** Устанавливаем необходимые опции для сеанса cURL  */
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
//        curl_setopt($curl, CURLOPT_URL, $link);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
//        curl_setopt($curl, CURLOPT_HEADER, false);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
//        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
//        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        curl_close($curl);
//        /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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
//            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
//        }
//
//        /**
//         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
//         * нам придётся перевести ответ в формат, понятный PHP
//         */
//        $response = json_decode($out, true);
//
////        $access_token = $response['access_token']; //Access токен
////        $refresh_token = $response['refresh_token']; //Refresh токен
////        $token_type = $response['token_type']; //Тип токена
////        $expires_in = $response['expires_in']; //Через сколько действие токена истекает
//        $arrParamsAmo = [
//            "access_token" => $response['access_token'],
//            "refresh_token" => $response['refresh_token'],
//            "token_type" => $response['token_type'],
//            "expires_in" => $response['expires_in'],
//            "endTokenTime" => $response['expires_in'] + time(),
//        ];
//
//        $arrParamsAmo = json_encode($arrParamsAmo);
//
//        // выведем наши токены. Скопируйте их для дальнейшего использования
//        // access_token будет использоваться для каждого запроса как идентификатор интеграции
//        dd($arrParamsAmo);

    }
}
