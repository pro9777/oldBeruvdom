<?php

namespace App\Jobs;

use App\Models\Attachmentable;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Orchid\Attachment\File;
use Symfony\Component\DomCrawler\Crawler;

class ImportSkallaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->skalla();
        Log::info('Импорт скалла выполнена успешно.');
    }

    public function skalla()
    {
        $client = new Client();
        $xmlUrl = 'https://skalla.ru/tstore/yml/145436574cc9ab6719ee21acae820869.yml';

        $response = $client->get($xmlUrl);

        $xmlData = $response->getBody()->getContents();

        $xmlArray = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NSCLEAN);

        $products = [];
        foreach ($xmlArray->shop->offers->offer as $offer) {
            $vendorCode = (string)$offer->vendorCode;
            $product = [
                'id' => (string)$offer['id'],
                'name' => (string)$offer->name,
                'vendorCode' => str_replace(' ', '', $vendorCode),
                'description' => html_entity_decode((string)$offer->description, ENT_XML1),
                'picture' => (string)$offer->picture,
                'url' => (string)$offer->url,
                'price' => (int)$offer->price,
                'categoryId' => (string)$offer->categoryId,
            ];

            $products[] = $product;
        }
        $this->importRemove(45, $products);

        //собираем все категории
        $categories = [];
        $xmlObject = simplexml_load_string($xmlData);
        foreach ($xmlObject->shop->categories->category as $category) {
            $id = (string)$category['id'];
            $value = strtolower((string)$category);
            if ($value === 'fjord') $value = 'stone-fjord';
            $categories[$id] = $value;
        }

        //проходимся по всем товарам
        foreach ($products as $item) {

//            dd($item);
            $parent = Category::where('alias', $categories[$item['categoryId']])->pluck('id')->first() ?? '';
            if (empty($parent)) continue;

            //получаем alias
            $alias = str_slug($item['name'], '-');
            //получаем цену
            $price = $item['price'];
            $priceFormat = number_format($price, 0, '', ' ');
            $url = $item['url'];
            $client = new Client();
            $response = $client->get($url); // Замените ссылку на нужную веб-страницу
            $getBody = $response->getBody()->getContents();
            $crawler = new Crawler($getBody);
            $selectedElement = $crawler->filter('.t762__descr'); // Замените на ваш CSS-селектор
            $html = $selectedElement->html();
            $appendToHtml = '<div style="font-size: 24px; font-weight: 800; ">' . $priceFormat . 'р. <span style="opacity: .5; font-size: .8em;">/1 m²</span></div>';

            // Ищем все <span> элементы в HTML
            $spanElements = preg_match_all('/<span[^>]*>/', $html);
            if ($spanElements >= 3) {
                // Вставляем после первого <span>
                $html = preg_replace('/<\/span>/', '</span>' . $appendToHtml, $html, 1);
            } else {
                // Вставляем перед первым <span>
                $html = preg_replace('/<span[^>]*>/', "$appendToHtml$0", $html, 1);
            }

            //удаляем br и вставляем там где надо
            $html = preg_replace('/<br\s*\/?>/', '', $html);
            $html = preg_replace('/<strong>/', '<br><strong>', $html);
            $html = preg_replace('/<br\s*\/?>/', '', $html, 1);
            //создаем массив с данными о товаре
            $arr = [
                'title' => $item['name'], //название
                'parent_id' => $parent,  //id родителя
                'price' => $price,  //id родителя
                'alias' => $alias,  //ссылка
                'brend' => 'Skalla', //бренд
                'status' => '1',    //статус
                'keywords' => $html, //описание
                'description2' => $item['description'], //описание
            ];

            //валидация данных
            $validator = Validator::make($arr, [
                'title' => [
                    'required', //обязательно
                    //проверяем существует ли такое название
                    //                    Rule::unique('products', 'title')->ignore('dvoreckiy' . $item['@attributes']['id'], 'articular')
                ],
                'alias' => [
                    'required', //обязательно
                    //проверяем существует ли такая ссылка
                    //                    Rule::unique('products', 'alias')->ignore('dvoreckiy' . $item['@attributes']['id'], 'articular')
                ],
            ]);

            //выводим ошибки валидации
            if ($validator->fails()) {
                // Обработка ошибок валидации
                // Например, вернуть JSON-ответ с ошибками
                return response()->json(['errors' => $validator->errors()], 346);
            }

            try {
                $product = Product::updateOrCreate([
                    'articular' => str_replace(' ', '', $item['vendorCode'])
                ], array_merge($arr, []));

                $product_photo = $product->attachment()->where('group', 'product_photo')->get();
                // Удалите каждую фотографию
                foreach ($product_photo as $attachment) {
                    $attachment->delete();
                }

                //сохраняем фотографию в общую папку
                $fileName = $this->saveFile($item['picture']);

                $filePath = storage_path("app/public/photos/$fileName"); // Путь к фотографии

                $uploadedFile = new UploadedFile($filePath, basename($filePath));

                $file = new File($uploadedFile, 'products', 'product_photo');

                $attachment = $file->allowDuplicates()->load();

                Attachmentable::query()
                    ->create([
                        'attachmentable_type' => 'App\Models\Product',
                        'attachmentable_id' => $product->id,
                        'attachment_id' => $attachment->id,
                    ]);

            } catch (\Exception $e) {
                \Log::error('Произошла ошибка при создании/обновлении продукта: ' . $e->getMessage());
            }
        }

        //удаляем временные файлы с папки photos
        $directory = storage_path('app/public/photos/', true); // Замените на путь к вашей папке

        \Illuminate\Support\Facades\File::deleteDirectory($directory, true);
    }

    public function importRemove($id_category, $products)
    {
        // Получите категорию с id 20
        $category_children = Category::find($id_category)->children()->pluck('id')->toArray();

        //vendorCodes всех товаров которые есть
        $vendorCodes = array_column($products, "vendorCode");

        //удаляем все товары которые уже не актуальные
        $products = Product::whereIn('parent_id', $category_children) //только те которых входит в нужную категорию
        ->whereNotIn('articular', $vendorCodes) //все которые в наш массив
        ->delete();
    }

    public function saveFile($url): string
    {
        //получаем файл
        $photoContent = file_get_contents($url);
        //название файла из 20 символов
        $filename = Str::random(20) . '.jpg';

        // Сохраняем фотографию в указанном диске и папке
        Storage::disk('public')->put('photos/' . $filename, $photoContent);

        //возвращаем название файла
        return $filename;
    }
}
