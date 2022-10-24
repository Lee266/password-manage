<?php

namespace App\Http\Controllers\Admin\Sample;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

//models used
use App\Models\Sample;
use App\Models\ImageSample;
use App\Models\Postcode;
use App\Models\Test;
use App\Mail\SampleMail;

// Validation Rules
use App\Http\Requests\Admin\SampleCreateRequest;

class SampleController extends Controller
{
    /*
    public function validateData($validatedData, $type) {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email'
        ];
        return Validator::make($validatedData, $rules);
    }
    */

    public function store(SampleCreateRequest $request)
    {
        $data = $request->all();
        try {
            
            //create sample data first
            $dataSample = [
                'name' => $data['name'],
                'avatar' => null,
                'birthday' => Carbon::parse($data['birthday']),
                'hobby' => $data['hobby'],
                'gender' => $data['gender'],
                'postcode' => $data['postcode'],
                'prefecture_id' => $data['prefectureId'],
                'address' => $data['address'],
                'active_hour' => $data['activehour'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'price' => $data['price'],
            ];
            
            /*
            $validator = $this->validateData($dataSample, 'create');

            if($validator->fails()) {
                $response[] = $validator->getMessageBag()->toArray();
                return errorResponse($response);
            }
            */

            $createSample = Sample::create($dataSample);
            $lastSampleId = $createSample->id;

            //Store Single Image
            if(isset($request->file) && $request->file!=="null"){
                //getting image extension and create new name for file upload
                $image = $request->file;
                $nameImage = preg_replace('/\s+/', '', 'test_').time(); // test is for file name saved, can change to any name
                $newName = $nameImage.'.'.$image->getClientOriginalExtension();
                
                //set new data for sample table
                $data['avatar'] = $newName;
                $updateSample = $createSample->update($data);

                //make folder first
                Storage::makeDirectory('samples/'.$lastSampleId);
                //save file
                Storage::putFileAs('samples/'.$lastSampleId, $image, $newName);
            }

            //Store Multiple Image
            if(isset($request->multipleImages) && $request->multipleImages!=="null"){

                //loop through the course data first befor update the main table
                foreach ($request->multipleImages as $index => $image) {
                    //getting image extension and create new name for file upload
                    $nameImage = preg_replace('/\s+/', '', 'test_').time(); // test is for file name saved, can change to any name
                    $newName = $nameImage.'.'.$image->getClientOriginalExtension();
                    
                    $dataimage['sample_id'] = $lastSampleId;
                    $dataimage['filename'] = $newName;
                    $createimageSample = ImageSample::create($dataimage);
                    $lastSampleImageId = $createimageSample->id;

                    //make folder first
                    Storage::makeDirectory('samples/'.$lastSampleId.'/subImages');
                    //save file
                    Storage::putFileAs('samples/'.$lastSampleId.'/subImages/'.$lastSampleImageId, $image, $newName);
                }
            }
            
            // Send email
            $mailData = [
                'title' => 'Welcome ' . $data['name'],
                'body' => 'This is testing email using mailhog.'
            ];
             
            Mail::to($data['email'])->send(new SampleMail($mailData));

            return successResponse();
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function create()
    {
        $data = [];
        $data['postcode'] = Postcode::select('id','prefecture')->get();
        return successResponse($data);
    }
    
    public function search(Request $request)
    {
        $data = Postcode::select('id','prefecture')->where('postcode',$request->q)->get();
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
