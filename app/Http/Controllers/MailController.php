<?php

namespace App\Http\Controllers;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\BadTypeException;
use App\Contracts\Crm\AddLeadInterface;
use App\Contracts\Crm\GetAmoCRMApiClientInterface;
use App\Jobs\SendAmoCrmJob;
use App\Services\AmoCrm\AddLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{


    public function __construct(
        private AddLeadInterface $addLead
    )
    {}


    public function sendEmail(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'consent' => 'required',
        ]);


        if ($validate->passes()) {

            $leadName = $request->get('from');
            $name = $request->get('name');
            $number = $request->get('number');


            $this->addLead->add(name: $name, number: $number, leadName: $leadName . ' BVD');

//            $prodEmail = 'order@beruvdom.ru';
//            $devEmail = 'programmer9777@gmail.com';
//            dispatch(new SendAmoCrmJob($params));

//            Mail::to($prodEmail)->send(new Feedback($params));//order@beruvdom.ru

//            $addRefreshToken = Amocrm::addRefreshToken();
//
//            $idContact = Amocrm::addContact($params['value']);
//
//            $idTask = Amocrm::addTask($idContact, $params);

            return response()->json(['success' => true]);
        }
        return response()->json(['error' => $validate->errors()]);

    }
}
