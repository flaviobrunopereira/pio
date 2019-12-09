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
class UpdateTeachersCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:teachers";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch teachers from pio api and update DB";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $students = UpdateTeachersCommand::updateTeachers();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }

    // Update DB
     public function updateTeachers()
     {
         $url = env("PIO_URL") . '/asservices/rest/v1/teacherservice/retrieveteachers';
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
         Log::info('Table: teachers updated.');
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
