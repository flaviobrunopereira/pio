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
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UpdateStudentsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:students";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch students from pio api and update DB";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $students = UpdateStudentsCommand::updateStudents();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }

    // Update DB
    public function updateStudents()
    {
        $url = env("PIO_URL") . '/asservices/rest/v1/studentservice/retrieveouenrolledstudents';
        $body = array(
            'ou' => "ISCAC",
            'lectiveYear' => "201920"
        );

        try {
            $response = $this->fetchData($url, $body);
            //$response = $request->getBody();
            $retrieved_data = json_decode($response, true);
            $students = $retrieved_data["students"];
            foreach ($students as $key => $value) {
                $results = DB::table("OUEnrolledStudents")->updateOrInsert([
                    'numInt' => $value['numInt'],
                    'numSGA' => $value['numSGA'],
                    'studentName' => $value['studentName'],
                    'courseCode' => $value['courseCode'],
                    'emailInt' => json_encode($value['emailInt']), //implode if array
                    'emailAlt' => json_encode($value['emailAlt'])
                ]);
                if($results==0)
                Log::info('Inserted new user into database: ' . $value['numInt'] . " " . $results);;
            }
        } catch (ClientException $e) {
            Log::error('Error inserting user : ' . $value['numInt'] . "Error: " . $e);
        }


        try {
            $detailStudents = UpdateStudentsCommand::detailStudents();
        } catch (Exception $e) {
            Log::error("Error: " . $e);
        }

        try {
            $contactStudents = UpdateStudentsCommand::contactsStudents();
        } catch (Exception $e) {
            Log::error("Error: " . $e);
        }
    }



    public function detailStudents()
    {
        $students = DB::table("OUEnrolledStudents")->select('numInt','numSGA','courseCode')->get();
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
                    Log::info('Fetching details of user: ' . $sData['numInt']);;
                } catch (ClientException $e) {
                    Log::error('Error inserting user : ' . $sData['numInt'] . "Error: " . $e);
                }
            }
            else
                Log::error('Error inserting user : ' . $sData['numInt'] . "Error: ");
        }
    }

    public function contactsStudents()
    {
        $students = DB::table("OUEnrolledStudents")->select('numInt','numSGA','courseCode')->get();
        $students = json_decode($students, true);
        $students = array_unique(array_column($students, 'numInt'));
        $url = env("PIO_URL") . '/asservices/rest/v1/studentservice/retrievepersonaldata';
        foreach ($students as $student => $numInt) {
            $body = array(
                'ou' => "ISCAC",
                'numInt' => $numInt
            );
            $response = $this->fetchData($url, $body);
            $sData = json_decode($response, true);
            if($sData["name"]!=NULL) {
                try {
                    $details = DB::table("students_contacts")->updateOrInsert([
                        'name' => $sData['name'],
                        'emailInt' => $sData['emailInt'],
                        'emailAlt' => $sData['emailAlt'],
                        'civilState' => $sData['civilState'],
                        'gender' => $sData['gender'],
                        'birthDate' => $sData['birthDate'],
                        'identification' => $sData['identification'],
                        'nif' => $sData['nif'],
                        'residence' => $sData['residence'],
                        'postCode' => $sData['postCode'],
                        'locale' => $sData['locale'],
                        'placeOfBirth' => $sData['placeOfBirth'],
                        'nationality' => $sData['nationality'],
                        'phone' => $sData['phone'],
                        'mobilePhone' => $sData['mobilePhone'],
                        'allowNotifications' => $sData['allowNotifications'],
                    ]);
                    Log::info('Fetching contacts of user: ' . $numInt);;
                } catch (ClientException $e) {
                   // echo $e->getRequest() . "\n";
                    Log::error('Error inserting user : ' . $numInt . "Error: " . $e);
                }
            }
            else
                Log::error('Error inserting user : ' . $numInt . "Error: ");
        }
    }

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
            Log::error('Error inserting user : ' . $numInt . "Error: " . $e->getRequest());
        }
    }
}
