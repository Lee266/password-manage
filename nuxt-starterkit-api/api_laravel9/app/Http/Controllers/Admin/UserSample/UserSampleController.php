<?php
namespace App\Http\Controllers\Admin\UserSample;

use App\Http\Controllers\Controller;
use App\Models\UserSample;

class UserSampleController extends Controller
{
    public function filter()
    {
        $query = UserSample::with(['admin']);
        $result = $query->get();

        return successResponse($result);
    }
}
