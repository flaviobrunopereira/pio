<?php
namespace App\Http\Controllers;

use App\Test;
use GuzzleHttp\Exception\ClientException;
use Log;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\IncompatibleReturnValueException;
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

    public function listStudent(Request $request, $id = null)
     {
        $detail = DB::table("student_detail")->where('numSGA', $id)->first();
        $contact = DB::table("student_contact")->where('numInt', $detail->numInt)->first();
        $academic = DB::table("student_academic")->where('numSGA', $id)->first();
        $merged = array_merge((array)$detail, (array)$contact);
        $merged = array_merge((array)$merged, (array)$academic);
         if($request->wantsJSON()) {
             return json_encode($merged, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
         }
         else {
             return view('listStudent', ['data' => json_encode($merged)]);
         }
    }

    public function listStudents(Request $request)
    {
         $listStudents = DB::table("student_detail")->orderBy('name')->get();
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            Log::info('Should return Json');
            return json_encode($listStudents); }
        else{
            foreach ($listStudents as $item){
                if(($item->photo))
                $item->photo = "<img width=100px height=100px src='" . $item->photo. "'/>";

    }
            return view('listStudents', ['data' => $listStudents]);

    }}

    public function listTeachers(Request $request)
    {
        $listTeachers = DB::table("Teachers")->orderBy('name')->get();
        foreach ($listTeachers as $teacher) {

            $getQualification = DB::table("employeedetails")
                ->where('emailInst', $teacher->email)
                ->first();

            if(is_null($getQualification)) {
                Log::info($teacher->email . ' : No details available.');
            }
            else {
                //print_r($getQualification);
                // Adicionar propriedades ao objecto
                $teacher->higherDegree = $getQualification->higherDegree;
                $teacher->categoryProf = $getQualification->categoryProf;
                $teacher->higherDegree_course = $getQualification->higherDegree_course;
                $teacher->employeeNumber = $getQualification->employeeNumber;
                $teacher->active = $getQualification->active ? "Activo": "Inativo";
            }

        }
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            return json_encode($listTeachers); }
        else
            return view('listTeachers', ['data' => $listTeachers]);

    }


    /////// TESTES
    public function listEmployees2(Request $request)
        {
        $listTeachers = DB::table("employees")->where([['ou','ISCAC'],[ 'teacher', '0']])->orderBy('name')->get();
        return json_encode($listTeachers);
        }



    public function listCourses(Request $request)
    {
        $listCourses = DB::table("courses")->orderBy('courseCode')->get();
         Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            return json_encode($listCourses); }
         else
            return view('listCourses', ['data' => $listCourses]);

    }


    public function listEmployees(Request $request)
    {
       // $listEmployees = DB::table("employees")->orderBy('employeeNumber')->get();
        $listEmployees = DB::table("employees")->where([['ou','ISCAC'],[ 'teacher', '0']])->orderBy('name')->get();
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJson()) {
            return json_encode($listEmployees); }
        else
            return view('listEmployees', ['data' => $listEmployees]);

    }

}


