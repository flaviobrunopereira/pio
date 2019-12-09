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
            $students = UpdateEmployeesCommand::updateEmployees();
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
                    'ou' => $value['ou']
                    //'birthDate' => $time,
                ]);
                Log::info('Updated/Insert user: ' . $value['employeeNumber']);

            }
        } catch (ClientException $e) {
            echo $e->getRequest() . "\n";
            Log::error('Error inserting employee : ' . $value['employeeNumber'] . "Error: " . $e);
        }
        Log::info("Table: employees updated");
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
