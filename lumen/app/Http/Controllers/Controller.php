<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Log;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    //$router->get('post', 'DataController@postRequest');
    //$router->get('students', 'DataController@studentsRequest');


}


class DataController extends BaseController
{

    // Update Students
    public function updateStudents()
    {
        $client = new Client();
        $url = 'https://pio.intranet.ipc.pt/asservices/rest/v1/studentservice/retrieveouenrolledstudents';
        $username = "iscac";
        $password = "fhhjmc344&&Hopdp45";
        $body = array(
            'ou' => "ISCAC",
            'lectiveYear' => "201920"
        );
        $options = array(
            'auth' => [
                $username,
                $password
            ],
            'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json', 'Charset' => 'utf-8'],
            'json' => $body,
            'debug' => false,
            'verify' => false
        );

        try {
            $request = $client->post($url, $options);
            $response = $request->getBody();
            $retrieved_data = json_decode($response, true);
            $students = $retrieved_data["students"];
            foreach ($students as $key => $value) {
                $results = DB::table("OUEnrolledStudents")->updateOrInsert([
                    'numInt' => $value['numInt'],
                    'numSGA' => $value['numSGA'],
                    'studentName' => $value['studentName'],
                    'courseCode' => $value['courseCode'],
                    'emailInt' => json_encode($value['emailInt']), //implode if array
                    'emailAlt' => json_encode($value['emailAlt']),
                    'status' => $value['status']
                ]);
                Log::info('Updated/Insert user: ' . $value['numInt']);;
            }
        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
            Log::error('Error inserting user : ' . $value['numInt'] . "Error: " . $e);
        }
    }



    //fetch details of all students
    // should have parallel
    public function detailStudents()
    {
        $students = DB::table("OUEnrolledStudents")->select('numSGA', 'courseCode')->get();
        $students = json_decode($students, true);
        $url = 'https://pio.intranet.ipc.pt/asservices/rest/v1/studentservice/retrievestudentdetail';
        foreach ($students as $student => $value) {
            $body = array(
                'ou' => "ISCAC",
                'courseCode' => $value["courseCode"],
                'numSGA' => $value["numSGA"],
                'withPhoto' => true
            );

            $response = $this->fetchData($url, $body);
            $sData = json_decode($response, true);
            if($sData['name']!=NULL) {
                echo $student;
            try {

                $details = DB::table("retrieveStudentDetail")->updateOrInsert([
                    'photo' => $sData['photo'],
                    'numInt' => $sData['numInt'],
                    'numSGA' => $sData['numSGA'],
                    'name' => $sData['name'],
                    'courseCode' => $sData['courseCode'],
                    'course' => $sData['course'],
                    'status' => $sData['status'],
                    'emailInt' => json_encode($sData['emailInst']),
                    'emailAlt' => json_encode($sData['emailAlt'])
                ]);
                Log::info('Updated/Insert user: ' . $sData['numInt']);;

            } catch (ClientException $e) {
                echo $e->getRequest() . "\n";
                Log::error('Error inserting user : ' . $sData['numInt'] . "Error: " . $e);
            }
            }
            else
                Log::error('Error inserting user : ' . $sData['numInt'] . "Error: ");
        }
    }


    private function cleanSQL($data)
    {
        if ($data == '') {
            $data = null;
        } else {
            //$data = html_entity_decode(json_encode($data));
            $data = json_encode($data);
            $data = trim($data, '"');
        }
        return $data;
    }


    private function studentsInsert($data)
    {
        $results = app('OUEnrolledStudents')->insert(
            $data["students"]
        );
        echo json_encode($results);
    }

    // Update Teachers
    public function retrieveTeachers()
    {
        $url = 'https://pio.intranet.ipc.pt/asservices/rest/v1/teacherservice/retrieveteachers';
        $body = array(
            'ou' => "ISCAC",
            'academicSystem' => "nonio"
        );
        try {
            $response = $this->fetchData($url, $body);
           $retrieved_data = json_decode($response, true);
            $teachers = $retrieved_data["teachers"];
            foreach ($teachers as $key => $value) {
                $results = DB::table("Teachers")->updateOrInsert([
                    'name' => $value['name'],
                    'numSGA' => $value['numSGA'],
                    'email' => $value['email']
                ]);
                Log::info('Updated/Insert user: ' . $value['numSGA']);

            }
        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
            Log::error('Error inserting teacher : ' . $value['numSGA'] . "Error: " . $e);
        }
        echo "Upload Data done";
    }


// Fucntion to fecth data
    private function fetchData($url, $body)
    {
        $client = new Client();
        $username = "iscac";
        $password = "fhhjmc344&&Hopdp45";
        $options = array(
            'auth' => [
                $username,
                $password
            ],
            'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json', 'Charset' => 'utf-8'],
            'json' => $body,
            'debug' => false,
            'verify' => false
        );
        try {
            $request = $client->post($url, $options);
            $response = $request->getBody();
            return $response;
        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
        }
    }

    public function listStudents()
    {
        // to be improved with views
        // $listStudents = DB::table("OUEnrolledStudents")->get();
        // return $listStudents;
        $echo = "none";
        return $echo;
    }


}




