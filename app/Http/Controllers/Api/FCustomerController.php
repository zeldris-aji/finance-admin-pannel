<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FCustomerController extends Controller
{
    protected $response = [];
    public $filter = [
        "searchText" => "",
        "sizePerPage" => 25,
        "sortOrder" => "desc",
        "sortField" => "id",
        "active" => "all",
    ];

    public function search(Request $request, $page = 1)
    {
        try {
            $filter = $request->all();
            $perPage = isset($filter["sizePerPage"]) ? $filter["sizePerPage"] : $this->filter["sizePerPage"];
            $sortField = isset($filter["sortField"]) ? $filter["sortField"] : $this->filter["sortField"];
            $sortOrder = isset($filter["sortOrder"]) ? $filter["sortOrder"] : $this->filter["sortOrder"];

            $customers = FCustomer::query();
            if (isset($filter['searchText'])) {
                $customers->where('name', 'LIKE', '%' . $filter['searchText'] . '%');
            }
            $this->response["totalItems"] = $customers->count();
            $this->response['data'] = $customers->orderBy($sortField, $sortOrder)->paginate($perPage);
            $this->response['searchText'] = $filter['searchText'] ?? '';
            $this->response["currentPage"] = $page;
            $this->response["sortOrder"] = $sortOrder;
            $this->response["filter"] = [];
            $this->response['Title'] = Lang::get('Customer Search');
            $this->response['message'] = Lang::get('Customer Search Result');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }


    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'code' => 'required',
                'name' => 'required',
                'number' => 'required',
                'address' => 'nullable',
                'parent_name' => 'nullable',
                'number_two' => 'nullable',
                'status' => 'boolean',
            ]);
            if ($validator->fails()) {
                $this->response["errors"] = $validator->errors()->first();
                $this->response["old_data"] = $request->all();
                $this->response["message"] = Lang::get('Problem with inputs');
                return $this->errorResponse($this->response);
            } else {
                $customer = new FCustomer();
                $customer->code = $request['code'] ?? '';
                $customer->name = $request['name'] ?? '';
                $customer->number = $request['number'] ?? '';
                $customer->address = $request['address'] ?? '';
                $customer->parent_name = $request['parent_name'] ?? '';
                $customer->number_two = $request['number_two'] ?? '';
                $customer->save();
            }
            $this->response['Title'] = Lang::get('Create Customer');
            $this->response['message'] = Lang::get('Customer Created SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }


    public function edit($id)
    {
        try {
            $customer = FCustomer::find($id);
            $this->response['data'] =  $customer;
            $this->response['Title'] = Lang::get('Get Customer');
            $this->response['message'] = Lang::get('Customer Fetched SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'number' => 'required',
                'address' => 'nullable',
                'parent_name' => 'nullable',
                'number_two' => 'nullable',
                'status' => 'boolean',
            ]);
            if ($validator->fails()) {
                $this->response["errors"] = $validator->errors()->first();
                $this->response["old_data"] = $request->all();
                $this->response["message"] = Lang::get('Problem with inputs');
                return $this->errorResponse($this->response);
            } else {
                $customer = FCustomer::find($id);
                $customer->name = $request['name'] ??  $customer->name;
                $customer->number = $request['number'] ?? $customer->number;
                $customer->address = $request['address'] ?? $customer->address;
                $customer->parent_name = $request['parent_name'] ??  $customer->parent_name;
                $customer->number_two = $request['number_two'] ?? $customer->number_two;
                $customer->save();
            }
            $this->response['Title'] = Lang::get('Update Customer');
            $this->response['message'] = Lang::get('Customer Updated SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }

}
