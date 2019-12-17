<?php
namespace App\Http\Controllers;

use App\Test;
use Log;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function index()
    {
        return view('json_form');
    }

    public function store(Request $request)
    {
        $data = $request->only('name', 'email', 'mobile_number');
        $test['token'] = time();
        $test['data'] = json_encode($data);
        Test::insert($test);
        return Redirect::to("laravel-json")->withSuccess('Great! Successfully store data in json format in datbase');

    }


    public function listStudents(Request $request)
    {
         $listStudents = DB::table("student_detail")->orderBy('name')->get();
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            Log::info('Should return Json');
            return json_encode($listStudents); }
        else
            return view('listStudents', ['data' => $listStudents]);

    }

}


