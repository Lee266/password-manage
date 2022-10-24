<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

use App\Models\Sample;
use App\Models\Postcode;
use App\Models\Test;
class SampleController extends Controller
{
    //
    public function validateData($validatedData, $type) {
        $rules = [
            'name' => 'required|max:255',
        ];
        return Validator::make($validatedData, $rules);
    }

    public function store(Request $request)
    {
        try{
            $dataSample = [
                'name' => $request->data['name'],
                'avatar' => null,
                'birthday' => $request->data['birthday'],
                'hobby' => implode(",",$request->data['hobby']),
                'gender' => $request->data['gender'],
                'postcode' => $request->data['postcode'],
                'prefecture_id' => null,
                'address' => $request->data['address'],
                'active_hour' => $request->data['activehour'],
                'email' => $request->data['email'],
                'password' => Hash::make($request->data['password']),
                'price' => $request->data['price'],
            ];
    
            $validator = $this->validateData($dataSample, 'create');

            if($validator->fails()) {
                $response[] = $validator->getMessageBag()->toArray();
                return errorResponse($response);
            }
            Sample::create($dataSample);

            return successResponse();
        }catch(Exception $e){
            return errorResponse($e->getMessage());
        }

    }
    public function create()
    {
        $data = [];
        // $data['postcode'] = Postcode::all();
        return successResponse($data);
    }
    public function search(Request $request)
    {
        // $params = $request->all();
        $data = Postcode::where('postcode',$request->q)->get();
        // var_dump($request->all());
        return successResponse($data);
    }
    public function edit($id)
    {
        try {
            $data = Sample::find($id);
            return successResponse($data);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
