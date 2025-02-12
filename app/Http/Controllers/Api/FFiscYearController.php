<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FFiscYaer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FFiscYearController extends Controller
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

            $f_fisc_yaer = FFiscYaer::query();
            if (isset($filter['searchText'])) {
                $f_fisc_yaer->where('name', 'LIKE', '%' . $filter['searchText'] . '%');
            }
            $this->response["totalItems"] = $f_fisc_yaer->count();
            $this->response['data'] = $f_fisc_yaer->orderBy($sortField, $sortOrder)->paginate($perPage);
            $this->response['searchText'] = $filter['searchText'] ?? '';
            $this->response["currentPage"] = $page;
            $this->response["sortOrder"] = $sortOrder;
            $this->response["filter"] = [];
            $this->response['Title'] = Lang::get('Financial Fisc Yaer Search');
            $this->response['message'] = Lang::get('Financial Fisc Yaer Search Result');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:f_fisc_yaers,name,',
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'boolean',
            ]);
            if ($validator->fails()) {
                $this->response["errors"] = $validator->errors()->first();
                $this->response["old_data"] = $request->all();
                $this->response["message"] = Lang::get('Problem with inputs');
                return $this->errorResponse($this->response);
            } else {
                $f_fisc_yaer = new FFiscYaer();
                $f_fisc_yaer->name = $request['name'] ?? '';
                $f_fisc_yaer->start_date = $request['start_date'] ?? '';
                $f_fisc_yaer->end_date = $request['end_date'] ?? '';
                $f_fisc_yaer->status = $request['status'] ?? 0;
                $f_fisc_yaer->save();
            }
            $this->response['Title'] = Lang::get('Create Financial Fisc Yaer');
            $this->response['message'] = Lang::get('Financial Fisc Yaer Created SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        try {
            $f_fisc_yaer = FFiscYaer::find($id);
            $this->response['data'] =  $f_fisc_yaer;
            $this->response['Title'] = Lang::get('Get Financial Fisc Yaer');
            $this->response['message'] = Lang::get('Financial Fisc Yaer Fetched SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:f_fisc_yaers,name,'.$id,
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'boolean',
            ]);
            if ($validator->fails()) {
                $this->response["errors"] = $validator->errors()->first();
                $this->response["old_data"] = $request->all();
                $this->response["message"] = Lang::get('Problem with inputs');
                return $this->errorResponse($this->response);
            } else {
                $f_fisc_yaer = FFiscYaer::find($id);
                $f_fisc_yaer->name = $request['name'] ?? '';
                $f_fisc_yaer->start_date = $request['start_date'] ?? '';
                $f_fisc_yaer->end_date = $request['end_date'] ?? '';
                $f_fisc_yaer->status = $request['status'] ?? 0;
                $f_fisc_yaer->save();
            }
            $this->response['Title'] = Lang::get('Update Financial Fisc Yaer');
            $this->response['message'] = Lang::get('Financial Fisc Yaer Updated SuccessFully');
            return $this->successResponse($this->response);
        } catch (\Exception $e) {
            $this->response['error_message'] = $e->getMessage();
            return $this->errorResponse($this->response);
        }
    }
}
