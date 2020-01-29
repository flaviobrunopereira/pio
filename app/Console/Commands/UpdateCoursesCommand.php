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
 * Class UpdateCourseCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UpdateCoursesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:courses";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch Courses from pio api and update DB";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $students = UpdateCoursesCommand::updateCourses();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }

    // Update DB
     public function updateCourses()
     {
         $url = env("PIO_URL") . '/asservices/rest/v1/courseservice/retrievecourses';
         $body = array(
             'ou' => "ISCAC",
             'academicSystem' => "nonio"
         );

         try {
             $response = $this->fetchData($url, $body);
             $retrieved_data = json_decode($response, true);
             $courses = $retrieved_data["courses"];
             foreach ($courses as $key => $value) {
                 $results = DB::table("courses")->updateOrInsert([
                     'codeDGES' => $value["codeDGES"],
                     'courseCode' => $value["courseCode"],
                     'degreeCode' => $value["degreeCode"],
                     'coursePublic' => $value["coursePublic"],
                     'degree' => $value["degree"],
                     'language' => $value["language"],
                     'frequencyRegime' => $value["frequencyRegime"],
                     'duration' => $value["duration"],
                     'courseName' => $value["courseName"],
                     'ects' => $value["ects"],
                     'courseActive' => $value["courseActive"],
                     'normalizedDegreeCode' => $value["normalizedDegreeCode"],
                     'codeCNAEF' => $value["codeCNAEF"],
                 ]);
                 Log::info(($results?"Updated":"Inserted") . " : " . $value['courseCode'] . "" );





             }
         } catch (ClientException $e) {
             echo $e->getRequest() . "\n";
             Log::error('Error inserting course : ' . $value['courseCode'] . "Error: " . $e);
         }
         Log::info('Courses updated.');
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
            echo $e->getRequest() . "\n";
        }
    }



}
