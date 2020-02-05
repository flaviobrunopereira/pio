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
                $results = DB::table("OUEnrolledStudents")->updateOrInsert(
                    [
                        'numInt' => $value['numInt'],
                        'courseCode' => $value['courseCode']
                    ]
                    ,
                    [
                        'numSGA' => $value['numSGA'],
                        'studentName' => $value['studentName'],
                        'emailInt' => json_encode($value['emailInt'], JSON_UNESCAPED_SLASHES), //implode if array
                        'emailAlt' => json_encode($value['emailAlt'], JSON_UNESCAPED_SLASHES),
                        #"created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
                ]);
                if ($results == 0)
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
            $detailStudents = UpdateStudentsCommand::academicStudents();
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
        $students = DB::table("OUEnrolledStudents")->select('numInt', 'numSGA', 'courseCode', 'studentName')->get();
        $students = json_decode($students, true);

        $url = 'https://pio.intranet.ipc.pt/asservices/rest/v1/studentservice/retrievestudentdetail';



            foreach ($students as $student => $value) {
                Log::debug("Course " .  $value['courseCode'] . "   " . isset($value["courseCode"]));
                if (isset($value["courseCode"])) {
                $body = array(
                    'ou' => "ISCAC",
                    'courseCode' => $value["courseCode"],
                    'numSGA' => $value["numSGA"],
                    'withPhoto' => true
                );
                $response = $this->fetchData($url, $body);
                $sData = json_decode($response, true);
                Log::debug('Fetching details of user: ' . $value["numSGA"] . " " . $value["courseCode"]);
                Log::debug('Fetching details of user: ' . $sData['numInt'] . " " . $sData['numSGA']);
                Log::debug('Fetching details of user: ' . $sData['courseCode'] . " " . $sData['status']);
                try {
                    $details = DB::table("student_detail")->updateOrInsert(
                        [
                            'numInt' => $sData['numInt'],
                            'courseCode' => $sData['courseCode']
                        ]
                        ,
                        [
                            'numSGA' => $sData['numSGA'],
                            'photo' => $sData['photo'],
                             'name' => $sData['name'],
                            'course' => $sData['course'],
                            'status' => $sData['status'],
                            'emailInt' => json_encode($sData['emailInst']),
                            'emailAlt' => json_encode($sData['emailAlt'])
                    ]);
                    Log::debug('Got details of user: ' . $sData['numInt'] . " " . $sData['name']);
                } catch (Exception $e) {
                    Log::error('Error inserting user : ' . $sData['numInt'] . " " . $sData['name'] . ". Error: " . $e);
                    Log::debug('Fetching details of user: ' . $value["numSGA"] . " " . $value["courseCode"]);
                    Log::debug('Fetching details of user: ' . $sData['numInt'] . " " . $sData['numSGA']);
                    Log::debug('Fetching details of user: ' . $sData['courseCode'] . " " . $sData['status']);
                }
            }
         else {
            Log::debug("No course " .  $value['numSGA'] . " " . $value['numInt']);
        }}
    }

    public function contactsStudents()
    {
        $students = DB::table("OUEnrolledStudents")->select('numInt', 'numSGA', 'courseCode')->get();
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
            if ($sData["name"] != NULL) {
                try {
                    $details = DB::table("student_contact")->updateOrInsert(
                        [
                            'numInt' => $numInt,
                            'identification' => $sData['identification'],
                            'nif' => $sData['nif'],
                        ],
                        [
                        'name' => $sData['name'],
                        'emailInt' => $sData['emailInt'],
                        'emailAlt' => $sData['emailAlt'],
                        'civilState' => $sData['civilState'],
                        'gender' => $sData['gender'],
                        'birthDate' => $sData['birthDate'],
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
                } catch (Exception $e) {
                    // echo $e->getRequest() . "\n";
                    Log::error('Error inserting user : ' . $numInt . "Error: " . $e);
                }
            } else
                Log::error('Error inserting user : ' . $numInt . "Error: ");
        }
    }

    public function academicStudents()
    {
        $students = DB::table("OUEnrolledStudents")->select('numInt', 'numSGA', 'courseCode')->get();
        $students = json_decode($students, true);
        $url = env("PIO_URL") . '/asservices/rest/v1/studentservice/retrievestudentacademicdata';
        foreach ($students as $student => $value) {
            $body = array(
                'ou' => "ISCAC",
                'courseCode' => $value['courseCode'],
                'numSGA' => $value['numSGA']
            );
            $response = $this->fetchData($url, $body);
            $academicDetails = json_decode($response, true);
            $academicDetails = $academicDetails["academicData"][0];
            try {
                $details = DB::table("student_academic")->updateOrInsert(
                    [
                        'numSGA' => $value['numSGA'],
                        'courseCode' => $academicDetails['courseCode']
                    ],
                    [
                    'curricularYear' => $academicDetails['curricularYear'],
                    'admissionDate' => $academicDetails['admissionDate'],
                    'mobility' => $academicDetails['mobility'],
                    'lastLectiveYear' => $academicDetails['lastLectiveYear'],
                    'conclusionDate' => $academicDetails['conclusionDate'],
                    'studyCycle' => $academicDetails['studyCycle'],
                    'avgFinalGrade' => $academicDetails['avgFinalGrade'],
                    'admissionDescription' => $academicDetails['admissionDescription'],
                    'courseName' => $academicDetails['courseName'],
                    'studyCycleCode' => $academicDetails['studyCycleCode'],
                    'registrationDate' => $academicDetails['registrationDate'],
                    'admissionLectiveYear' => $academicDetails['admissionLectiveYear']
                ]);
                Log::info('Fetching academic stats of user: ' . $value['numSGA']);;
            } catch (ClientException $e) {
                Log::error('Error inserting user : ' . $value['numSGA'] . "Error: " . $e->getRequest());
            }
        }
    }


    private function fetchData($url, $body)
    {
        $client = new Client();
        $username = env("PIO_USERNAME");
        $password = env("PIO_PASSWORD");
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
