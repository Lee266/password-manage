<?php
namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminListController extends Controller
{
    private $perpage = 10;

    public function filter(Request $request)
    {
        // Default configs
        $page = (int) $request->page ?? 1;
        $direction = 'asc'; // Order direction

        // Base query
        // Select only columns from main table
        $query = Admin::select('admins.*')
            ->with(['role', 'company']);

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

        // Company Name
        if (!empty($request->company)) {
            $companyName = $request->company;
            $query->whereHas('company', function ($company) use ($companyName) {
                $company->where('name', 'LIKE', "%{$companyName}%");
            });
        }

        // Address
        if (!empty($request->address)) {
            $address = $request->address;
            $query->whereHas('company', function ($company) use ($address) {
                $company->where('address', 'LIKE', "%{$address}%");
            });
        }

        // Search
        if (!empty($request->search)) {
            $search = $request->search;

            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");

            $query->orWhereHas('company', function ($company) use ($search) {
                $company->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('city', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Role filter
        if (!empty($request->role)) {
            $roleID = (int) $request->role;
            $query->whereHas('role', function ($role) use ($roleID) {
                $role->where('id', $roleID);
            });
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
                case 'role':
                    $query->leftJoin('admin_roles', 'admins.admin_role_id', '=', 'admin_roles.id')
                        ->orderBy('admin_roles.name', $direction);
                    break;
                case 'company':
                    $query->leftJoin('companies', 'admins.company_id', '=', 'companies.id')
                        ->orderBy('companies.name', $direction);
                    break;
                case 'telp':
                    $query->leftJoin('companies', 'admins.company_id', '=', 'companies.id')
                        ->orderBy('companies.phone', $direction);
                    break;
                case 'residence':
                    $query->leftJoin('companies', 'admins.company_id', '=', 'companies.id')
                        ->orderBy('companies.address', $direction);
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
        $result = new \stdClass;
        $result->roles = AdminRole::all();
        $result->companies = Company::all();

        return response()->json($result);
    }
}
