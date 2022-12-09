<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Config;

class BaseController extends Controller
{

    public function rule($request)
    {
    	$query = Config::where('config_type', $request);
        return $query->config_value;
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function filter($query, $request)
    {
        // filters
        $filters = $request->filters ? $request->filters : null;
        if ($filters) {
            foreach ($filters as $filter) {
                // if value not null
                if ($filter['value']) {
                    if ($filter['type'] == "like") $filter['value'] = '%' . $filter['value'] . '%';
                    $query->where($filter['field'], $filter['type'], $filter['value']);
                }
            }
        }

        // sorting
        $sorters = $request->sorters ? $request->sorters : null;
        if ($sorters) {
            foreach ($sorters as $sorter) {
                if ($sorter["dir"] == "desc") {
                    $query = $query->orderBy($sorter["field"], 'DESC');
                } else {
                    $query = $query->orderBy($sorter["field"]);
                }
            }
        }

        // paginate and size
        if ($request->size && $request->page) {
            $query->paginate($request->size);
        }

        return $query->get();
    }


}
