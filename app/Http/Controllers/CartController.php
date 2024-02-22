<?php

namespace App\Http\Controllers;

use App\Jobs\SendAmoCrmJob;
use App\Models\calculator\CalculatorValue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
//        dd(Route::getCurrentRoute()->getPath());
//        dd(session('key'));
        return view('cart.cart');
    }

    //оформление заказа
    public function addOrder(Request $request)
    {
        if (empty(session('timeForm'))) {
            $request->session()->put('timeForm', time());
            $request->session()->save();
        }

        if (time() >= session('timeForm')) {
            $request->session()->put('timeForm', time() + 5);
            $request->session()->save();
            \Cart::session(session('_token'));

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'number' => 'required',
            ]);

            if ($validate->passes()) {
                $params = [
                    'value' => $request->all(),
                    'total' => \Cart::session(Session::get('_token'))->getSubTotal(),
                    'products' => \Cart::session(Session::get('_token'))->getContent(),
                ];

                $prodEmail = 'order@beruvdom.ru';
                $devEmail = 'programmer9777@gmail.com';
                dispatch(
                    new SendAmoCrmJob(
                        name: $params['value']['name'],
                        number: $params['value']['number'],
                        leadName: 'Корзина',
                        products: $params['products'],
                        price: $params['total'],
                    )
                );
                dd(1);
//                Mail::to($prodEmail)->send(new Feedback($params)); //order@beruvdom.ru

//                $addRefreshToken = Amocrm::addRefreshToken();
//
//                $idContact = Amocrm::addContact($params['value']);
//
//                $idTask = Amocrm::addTask($idContact, $params);
//                if (!empty($params['products'])){
//                    Amocrm::addLeads($idTask, $params['products']);
//                }

                \Cart::session(Session::get('_token'))->clear();
                return response()->json(['success' => true]);
            }
            return response()->json(['error' => $validate->errors()]);
        } else {
            return response()->json(['error' => 'time']);
        }
    }

    //валидация полей
    public function validateInput(Request $request)
    {
        //валидация данных
        $validate_arr = [];
        if (!empty($request->all()['req'])) {
            foreach ($request->all()['req'] as $item) {
                $validate_arr[$item['name']] = ['required'];
            }
        }
        $inputs = [];
        $attributes = [];

        if (!empty($request->all()['data'])) {
            foreach ($request->all()['data'] as $item) {
                $inputs = array_merge($inputs, [$item['name'] => $item['value']]);
                $attributes = array_merge($attributes, [$item]);
            }
        }
        session(['productAttributes' => $attributes]);
        $validate = Validator::make(($inputs), $validate_arr);

        if ($validate->passes()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => $validate->errors()]);
    }


    //перерасчет калькулятора
    public function priceCalculation(Request $request)
    {
        session(['price_calculator' => 0]);
        $ids_values = $request->ids_values;
        $product = Product::find($request->id);
        if (!empty($product)) {
            if (!empty($ids_values)) {
                //получаем текущий товар

                //получаем формулу товара
                $product_formula = $product->calculator_formula['formula'];

                //vyberite_cvet_stekla*(sirina+vysota/1000000)+vyberite_cvet_furnitury+dostavka+montaz
                $product_formula_arr = explode(' ', $product_formula);
//                dump($product_formula_arr);
                foreach ($product_formula_arr as $id => $value) {
                    foreach ($ids_values as $value_input) {
                        if ($value == $value_input['name']) {
                            $product_formula_arr[$id] = (int)$value_input['value'];
                            if (!$value_input['value']) {
                                $calculator_value = CalculatorValue::find($value_input['id']);
                                $product_formula_arr[$id] = $calculator_value->price;
                            }
                            break;
                        } else {
                            if (!is_numeric(
                                    $value
                                ) && $value != '*' && $value != '=' && $value != '/' && $value != '(' && $value != ')' && $value != '+') {
                                $product_formula_arr[$id] = 0;
                            }
                        }
                    }
                }


                $formula_result = implode($product_formula_arr);

                $total_price = '';
                //проверка на символ равно
                $ravno = strpos($formula_result, '=');
                if ($ravno != false) {
                    //делим строку на массив
                    $pieces = explode('=', $formula_result);

                    //получаем значение левой части формулы перед равно
                    $total_left = '';
                    eval('$total_left = ' . $pieces[0] . ';');

                    //удаляем все после точки и 1 символа 15.3659895 = 15.3
                    $total_left = bcdiv($total_left, 1, 1);
                    //округляем число в большую сторону
                    $total_left = ceil($total_left);
                    //Кол-во упаковок округленные в большую сторону
                    $numberOfPackages = $total_left;

                    //после округления продолжаем вычислять формулу
                    eval('$total_price = ' . $total_left . $pieces[1] . ';');
                    $total_price = $total_price * $request->qty;

                    //записываем в сессию сумму цену
                    session(['price_calculator' => ceil($total_price)]);

                    //получаем Необходимо ламината м2
                    $metersSquared = $total_price / $product->price;
                    $metersSquared = bcdiv($metersSquared, 1, 1);
                    return response()->json([
                        'total_price' => ceil($total_price),
                        'numberOfPackages' => $numberOfPackages,
                        'metersSquared' => $metersSquared
                    ]);
                } else {
                    eval('$total_price = ' . $formula_result . ';');
                }

                $total_price = $total_price * $request->qty;
                session(['price_calculator' => ceil($total_price)]);
                return response()->json([
                    'total_price' => ceil($total_price)
                ]);
            } else {
                $total_price = $product->price * $request->qty;
                session(['price_calculator' => ceil($total_price)]);
                return response()->json(['total_price' => ceil($total_price)]);
            }
        }
    }

    //добавление товара в корзину
    public function addToCart(Request $request)
    {
        //получаем добавляемый в корзину товар
        $product = Product::where('id', $request->id)
            ->with('attachment')
            ->first();

        //проверяем не пусто ли цена у продукта
        if (!empty($product->price)) {
            $price = $product->price;
        }

        //проверяем не пусто ли price_calculator в сессии
        if (!empty(session('price_calculator'))) {
            $price = session('price_calculator');
        }

        //получаем количетсва товара
        $qty = (int)$request->qty ?? 1;


        $cart_id = $product->id . '.' . $price / $request->qty;
        $img = '';

        //получаем фотку добавленного товара
        foreach ($product->attachment as $image) {
            if ($image->group == 'product_gallery') {
                $img = $image->relativeUrl;
            }
        }

        if (empty($img)) {
            foreach ($product->attachment as $image) {
                if ($image->group == 'product_photo') {
                    $img = $image->relativeUrl;
                }
            }
        }

//        dump($img);
        $img = !empty($img) ? $img : 'no_image.jpg';
        \Cart::session(session('_token'));
        if ($price > 0) {
            \Cart::add([
                'id' => $cart_id, // inique row ID
                'name' => $product->title,
                'price' => $price,
                'quantity' => $qty,
                'attributes' => [
                    'img' => $img,
                    'idProduct' => $product->id,
                    'href' => $product->category->alias . '/' . $product->alias,
                    'productAttributes' => session('productAttributes'),
                ]
            ]);
        }
    }


    //изменить товар в корзине
    public function updateToCart(Request $request)
    {
        $cart_id = session('_token');
        \Cart::session(session('_token'));

        \Cart::update($request->id, [
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ]);
        $cart = \Cart::session($cart_id)->get($request->id);
        $price = $cart->price * $request->qty;
        $total = \Cart::session($cart_id)->getSubTotal();
        $qty = \Cart::session($cart_id)->getTotalQuantity();

        return response()->json(['price' => $price, 'total' => $total, 'qty' => $qty]);
    }

    public function deleteToCart(Request $request)
    {
        if ($request->ajax()) {
            $cart_id = session('_token');
            \Cart::session($cart_id)->remove($request->id);
            return $this->getCart();
        }
    }

    public function getCart()
    {
        \Cart::session(session('_token'));
        $carts = \Cart::getContent();
//        dd($carts);
        return view('cart.cart_modal', compact('carts'));
    }

    public function getCartQty()
    {
        $qty = \Cart::session(session('_token'))->getTotalQuantity();
        return $qty;
    }


}
