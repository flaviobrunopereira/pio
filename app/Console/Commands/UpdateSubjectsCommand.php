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
 * Class UpdateSubjectsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UpdateSubjectsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:Subjects";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch Subjects from pio api and update DB";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $students = UpdateSubjectsCommand::updateSubjects();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }

    // Update DB
     public function updateSubjects()
     {
         $url = env("PIO_URL") . '/asservices/rest/v1/courseservice/retrievesubjects';
         $body = array(
             'ou' => "ISCAC",
             'academicSystem' => "nonio"
         );
         try {
             $response = $this->fetchData($url, $body);
             $retrieved_data = json_decode($response, true);
             $subjects = $retrieved_data["subjects"];
             foreach ($subjects as $key => $value) {
                 $results = DB::table("subjects")->updateOrInsert([
                     'courseCode' => $value['courseCode'],
                     'language' => $value['language'],
                     'planCode' => $value['planCode'],
                     'branchCode' => $value['branchCode'],
                     'subjectCode' => $value['subjectCode'],
                     'subjectName' => $value['subjectName'],
                     'curricularYear' => $value['curricularYear'],
                     'period' => $value['period'],
                     'ects' => $value['ects'],
                     'mandatory' => $value['mandatory'],
                     'internship' => $value['internship'],
                 ]);
                 Log::info('Updated/Inserted Course : ' . $value['courseCode'] . '' );

             }
         } catch (ClientException $e) {
             echo $e->getRequest() . "\n";
             Log::error('Error inserting Course : ' . $value['numSGA'] . "Error: " . $e);
         }
         Log::info('Table: Subjects updated.');
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
