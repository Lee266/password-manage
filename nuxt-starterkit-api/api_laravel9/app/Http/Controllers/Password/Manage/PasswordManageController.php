<?php

namespace App\Http\Controllers\Password\Manage;

use App\Http\Controllers\Controller;
use App\Models\PasswordManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminRole;

class PasswordManageController extends Controller
{
    /**
     * Validator for password manage
     * 
     */
    protected function validator(array $data, $type) {
        return validator::make($data, [
            'website' => 'string',
            'username' => 'string',
            'password' => 'string',
            'site_name' => 'string', 
            'email' => 'string',
            'note' => 'string',
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, PasswordManage $passwordManage)
    {
        $requestData = $request->all();
        $passwordManageData = [
            'website' => $requestData["data"]["website"],
            'username' => $requestData["data"]["username"],
            'password' => $requestData["data"]["password"],
            'site_name' => $requestData["data"]["site_name"],
            'email' => $requestData["data"]["email"],
            'note' => $requestData["data"]["note"],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $createData = PasswordManage::create($passwordManageData);
        try {
            if ($createData) {
                return successResponse();
            }else {
                return errorResponse();
            }
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\PasswordManage  $passwordManage
     * @return \Illuminate\Http\Response
     */
    public function show(PasswordManage $passwordManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\PasswordManage  $passwordManage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = PasswordManage::find($id);
            return successResponse($data);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\PasswordManage  $passwordManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        try {
            $passwordManageData = [
                'website' => $requestData["data"]["website"],
                'username' => $requestData["data"]["username"],
                'site_name' => $requestData["data"]["site_name"],
                'email' => $requestData["data"]["email"],
            ];
            if (isset($request->data['password'])) {
                $passwordManageData['password'] = $requestData["data"]["password"];
            }
            
            
            /*
            $validator = $this->validateData($adminData, 'edit');

            if($validator->fails()) {
                $response[] = $validator->getMessageBag()->toArray();
                return errorResponse($response);
            }
            */

            $previousData = PasswordManage::where('id', $id)->update($passwordManageData);
            return successResponse();

        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\PasswordManage  $passwordManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PasswordManage $passwordManage)
    {
        $id = $request->id;
        try {
            //code...
            $passwordManage->where('id', $id)->delete();
            $resetData = PasswordManage::get();
            return successResponse($resetData);
        } catch (Exception $e) {
            //throw $th;
            return errorResponse($e->getMessage());
        }
    }

    private $perpage = 10;
    public function filter(Request $request){
        $page = (int) $request->page ?? 1;
        $direction = 'asc';

        $query = PasswordManage::select('password_manages.*');

        if (!empty($request->website)) {
            $website = $request->website;
            $query->where('website', 'LIKE', "%{$website}%");
        }

        if (!empty($request->email)) {
            $email = $request->email;
            $query->where('email', 'LIKE', "%{$email}%");
        }

        if (!empty($request->siteName)) {
            $siteName = $request->siteName;
            $query->where('site_name', 'LIKE', "%{$site_name}%");
        }

        if (!empty($request->username)) {
            $username = $request->username;
            $query->where('username', 'LIKE', "%{$username}%");
        }

        if (!empty($request->direction)) {
            $direction = $request->direction;
        }
        
        if (!empty($request->order)) {
            $order = $request->order;
            switch ($order) {
                case 'website':
                case 'username':
                    $query->orderBy($order, $direction);
                    break;
                case 'password':
                    break;
                case 'site_name':
                    $query->orderBy($order, $direction);
                    break;
                case 'email':
                    $query->orderBy($order, $direction);
                    break;
                default:
                    $query->orderBy('id', $direction);
                    break;
            }
        }

        if (!empty($request->display)) {
            $this->perpage = $request->display;
            if ($request->display == 'All') {
                $this->perpage = 1000;
            }
        }

        $result = simplePaginate($query, $page, $this->perpage);
        return response()->json($result);
    }

    public function resources() {
        $result = new \stdClass;
        $result->roles = AdminRole::all();
        $result->passwordManages = PasswordManage::all();

        return response()->json($result);
    }
}
