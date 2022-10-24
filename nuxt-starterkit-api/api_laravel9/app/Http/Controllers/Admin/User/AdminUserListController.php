<?php
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserListController extends Controller
{
    private $perpage = 10;

    public function filter(Request $request)
    {
        // Default configs
        $page = (int) $request->page ?? 1;
        $direction = 'asc'; // Order direction

        // Base query
        // Select only columns from main table
        $query = User::select('users.*');

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
                ->orWhere('email', 'LIKE', "%{$search}%");
        }

        // Order filter
        if (!empty($request->direction)) {
            $direction = $request->direction;
        }

        if (!empty($request->order)) {
            $order = $request->order;
            switch ($order) {
                case 'name':
                case 'email':
                    $query->orderBy($order, $direction);
                    break;
                case 'created':
                    $query->orderBy('created_at', $direction);
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

        // Paginated result
        $result = simplePaginate($query, $page, $this->perpage);
        return response()->json($result);
    }

    public function resources()
    {
        // Add your resource data here
        // Usually for select options, etc

        $result = new \stdClass;

        // $result->roles = UserRole::all();
        // $result->companies = Company::all();

        return response()->json($result);
    }
}
