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
            Log::info('Should return Json');
            return json_encode($listTeachers); }
        else
            return view('listTeachers', ['data' => $listTeachers]);

    }


    /////// TESTES
    public function listTeachers2(Request $request)
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

            return json_encode($listTeachers); }

    /////// TESTES
    public function listEmployees2(Request $request)
        {
        $listTeachers = DB::table("employees")->where([['ou','ISCAC'],[ 'teacher', '0']])->orderBy('name')->get();
        return json_encode($listTeachers);
        }



    public function listCourses(Request $request)
    {
        $listCourses = DB::table("Courses")->orderBy('codecourse')->get();
        foreach ($listCourses as $course) {
            //$getQualification = DB::table("employeedetails")->where('emailInst', $teacher->email )->value('higherDegree');
            //$teacher-> habilitacao = $getQualification;
        }
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            Log::info('Should return Json');
            return json_encode($listCourses); }
        else
            return view('listCourses', ['data' => $listTeachers]);

    }


    public function listEmployees(Request $request)
    {
        $listEmployees = DB::table("employees")->orderBy('employeeNumber')->get();
        // to be improved with views
        Log::info('Request Type' . $request);
        if($request->wantsJSON()) {
            Log::info('Should return Json');
            return json_encode($listEmployees); }
        else
            return view('listEmployees', ['data' => $listEmployees]);

    }

}


