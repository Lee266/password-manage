<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogActivity;

class LogAdminActivityController extends Controller
{
    private $perpage = 10;

    public function filter(Request $request)
    {
        // Default configs
        $page = (int) $request->page ?? 1;
        $direction = 'asc'; // Order direction

        // Base query
        // Select only columns from main table
        $query = LogActivity::select(['log_activities.*', 'admins.*', 'log_activities.id as log_id'])
            ->leftJoin('admins', 'log_activities.admin_id', '=', 'admins.id');

        // Name
        if (!empty($request->name)) {
            $name = $request->name;
            $query->where('name', 'LIKE', "%{$name}%");
        }

        // Email
        if (!empty($request->email)) {
            $email = $request->email;
            $query->where('email', 'LIKE', "%{$email}%");
        }

        // Search
        if (!empty($request->search)) {
            $search = $request->search;

            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('ip', 'LIKE', "%{$search}%");
        }

        // Order filter
        if (!empty($request->direction)) {
            $direction = $request->direction;
        }

        if (!empty($request->order)) {
            $order = $request->order;
            switch ($order) {
                case 'log_id':
                    $query->orderBy('log_id', $direction);
                    break;
                case 'name':
                    $query->orderBy('name', $direction);
                    break;
                case 'email':
                    $query->orderBy('email', $direction);
                    break;
                case 'activity':
                    $query->orderBy('activity', $direction);
                    break;
                case 'ip':
                    $query->orderBy('ip', $direction);
                    break;
                case 'access_time':
                    $query->orderBy('access_time', $direction);
                    break;
                default:
                    $query->orderBy('log_id', $direction);
                    break;
            }
        } else {
            $query->orderBy('log_id', 'desc');
        }

        if (!empty($request->display)) {
            $this->perpage = $request->display;
            if ($request->display == 'All') {
                $this->perpage = 1000;
            }
        }

        // Paginated result
        $result = simplePaginate($query, $page, $this->perpage);
        return response()->json($result);
    }

    public function resources()
    {
        $result = new \stdClass;
        $result->activities = LogActivity::all();

        return response()->json($result);
    }
}
