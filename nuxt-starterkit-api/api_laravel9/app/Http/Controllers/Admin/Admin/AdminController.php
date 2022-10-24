<?php
namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Validation Rules
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;

class AdminController extends Controller
{
    /*
    public function validateData($validatedData, $type) {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ];
        if($type = 'edit') {
            $rules['password'] = 'min:6';
        }
        return Validator::make($validatedData, $rules);
    }
    */

    public function store(AdminCreateRequest $request)
    {
        try {
            $adminData = [
                'name' => $request->data['name'],
                'email' => $request->data['email'],
                'email_verified_at' => null,
                'password' => Hash::make($request->data['password']),
                'remember_token' => null,
            ];
            /*
            $validator = $this->validateData($adminData, 'create');

            if($validator->fails()) {
                $response[] = $validator->getMessageBag()->toArray();
                return errorResponse($response);
            }
            */

            Admin::create($adminData);

            return successResponse();
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data = Admin::find($id);
            return successResponse($data);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        try {
            $adminData = [
                'name' => $request->data['name'],
                'email' => $request->data['email'],
            ];
            if(isset($request->data['password'])) {
                $adminData['password'] = Hash::make($request->data['password']);
            }
            /*
            $validator = $this->validateData($adminData, 'edit');

            if($validator->fails()) {
                $response[] = $validator->getMessageBag()->toArray();
                return errorResponse($response);
            }
            */

            $previousData = Admin::find($id);
            $previousData->update($adminData);
            return successResponse();

        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function uniqueEmail(Request $request) {
        try {
            if($request->data['adminID'] == null) {
                $emailExist = Admin::where('email', $request->data['email'])->first();
                if($emailExist) {
                    return successResponse($emailExist->id, 'email exist', 201);
                } else {
                    return successResponse();
                }
            } else {
                $emailExist = Admin::where('email', $request->data['email'])->first();
                $emailCount = Admin::where('email', $request->data['email'])->count();
                if($emailCount == 1) {
                    if($emailExist->id == $request->data['adminID']) {
                        return successResponse();
                    } else {
                        return successResponse($emailExist->id, 'email exist', 201);
                    }
                } else if($emailCount == 0) {
                    return successResponse();
                } else {
                    return successResponse($emailExist->id, 'email exist', 201);
                }
            }
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
