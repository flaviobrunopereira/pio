<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Log;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;





/**
 * Class UpdateTeachersCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UpdateEmployeesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:employees";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch employees from pio api and update DB";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
    //        $students = UpdateEmployeesCommand::updateEmployees();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
        try {
            $students = UpdateEmployeesCommand::detailsEmployees();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }

    // Update DB
    public function updateEmployees()
    {
        $url = env("PIO_URL") .  "/hrservices/rest/v1/employeeservice/retrieveemployees";
        $body = array(
            'ou' => ""
        );
        try {
            $response = $this->fetchData($url, $body);
            $retrieved_data = json_decode($response, true);
            $employees = $retrieved_data["employees"];

            foreach ($employees as $key => $value) {
                $time = date($value['birthDate']);
                $results = DB::table("employees")->updateOrInsert([
                    'employeeNumber' => $value['employeeNumber'],
                    'name' => $value['name'],
                    'professionalCategory' => $value['professionalCategory'],
                    'teacher' => $value['teacher'],
                    'phd' => $value['phd'],
                    'emailInst' => $value['emailInst'],
                    'identification' => $value['identification'],
                    'identificationType' => $value['identificationType'],
                    'nationality' => $value['nationality'],
                    'nif' => $value['nif'],
                    'gender' => $value['gender'],
                    'ou' => $value['ou'],
                ]);


                Log::info('Updated/Insert user: ' . $value['employeeNumber']);

            }
        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
            Log::error('Error inserting employee : ' . $value['employeeNumber'] . "Error: " . $e);
        }
        Log::info("Table: employees updated");
    }



    public function detailsEmployees()
    {
        $employees = DB::table("employees")->select('employeeNumber')->where('ou','ISCAC')->get();
        foreach ($employees as $employee) {
            $url = env("PIO_URL") .  "/hrservices/rest/v1/employeeservice/retrieveemployeedetail";
        $body = array(
            'ou' => "ISCAC",
            'numInt'=> sprintf("%06d",$employee->employeeNumber)
        );
        try {
            $response =$this->fetchData($url, $body);
            $value = json_decode($response, true);
                $results = DB::table("employeedetails")->updateOrInsert([
                    'employeeNumber' => $value['numInt'],
                    'name' => $value['name'],
                    'gender' => $value['gender'],
                    'categoryProf' => $value['categoryProf'],
                    'nif' => $value['nif'],
                    'type' => $value['type'],
                    'emailAlt' => $value['emailAlt'],
                    'emailInst' => $value['emailInst'],
                    'voip' => $value['voip'],
                    'ouName' => $value['ouName'],
                    'career' => $value['career'],
                    'higherDegree'=>$value['academicData']['higherDegree']['degree'],
                    'higherDegree_course'=>$value['academicData']['higherDegree']['course'],
                    'higherDegree_establishment'=>$value['academicData']['higherDegree']['eduEstablishment'],
                    'higherDegree_codeOCDE'=>$value['academicData']['higherDegree']['codeOCDE'],
                    'higherDegree_OCDE'=>$value['academicData']['higherDegree']['descOCDE'],
                    'qualificationCode'=>$value['professionalQualification']['lastQualification']['qualificationCode'],
                    'qualificationTitle'=>$value['professionalQualification']['lastQualification']['qualificationTitle'],
                    'qualificationDesc'=>$value['professionalQualification']['lastQualification']['qualificationDesc'],
                    'lastServiceCode'=>$value['serviceData']['lastService']['serviceCode'],
                    'lastServiceName'=>$value['serviceData']['lastService']['serviceName'],
                    'lastjobTitle'=>$value['serviceData']['lastService']['jobTitle'],
                    'lastServiceType'=>$value['serviceData']['lastService']['serviceType'],
                    'lastTeachingserviceCode'=>$value['teachingServiceData']['lastService']['serviceCode'],
                    'lastTeachingServiceName'=>$value['teachingServiceData']['lastService']['serviceName'],
                    'lastTeachingjobTitle'=>$value['teachingServiceData']['lastService']['jobTitle'],
                    'lastTeachingServiceType'=>$value['teachingServiceData']['lastService']['serviceType'],
                    'active'=>$value['active']
                ]);
               Log::info('Updated/Insert user: ' . $value['numInt']);

        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
            Log::error('Error inserting employee : ' . $value['employeeNumber'] . "Error: " . $e);
        }


    }
        Log::info("Table: employeedetails updated");
    }


    // Fetch Data

    private function fetchData($url, $body)
    {
        $client = new Client();
        $username = env("PIO_USERNAME");
        $password = env("PIO_PASSWORD") ;
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
            Log::error($e->getRequest());
        }
    }



}
