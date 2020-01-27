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
 * Class SyncSigesCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class SyncSigesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:sigesdb";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync webservice database and update SIGES";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $siges = SyncSigesCommand::syncSiges();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }


    public function syncSiges()
    {
        $students = DB::table('OUEnrolledStudents')->get();
        foreach ($students as $student) {
            $id_individuo = $student->numInt;
            $nome = $student->studentName;
            $nm_completo = $student->studentName;
            $email = trim($student->emailInt, '[]"');
            $courseCode = $student->courseCode;
            $courseCode = substr_replace($courseCode, "", -1);
            $courseCode = substr_replace($courseCode, "", 0, 2);
            $courseCode = preg_replace('/^00?/', "", $courseCode);
            $netpa = ($email != 'null') ? (preg_replace('/@alumni.iscac.pt/', "", $email)) : "shit" ;
            $id_aluno = (strlen($netpa) > 10 ? substr_replace($netpa, "", 0, 3) : preg_replace('/iscac/', "", $netpa));
            if (preg_match('/^[0-9]*$/', $id_aluno)) {
                try {
                    $t_individuo = DB::connection('mysql_siges')->table('t_individuo')->updateOrInsert([
                        'ID_INDIVIDUO' => $id_individuo,
                        'NOME' => $nome,
                        'NM_COMPLETO' => $nome,
                        'EMAIL' => $email
                    ]);
                    Log::info('Updated/Insert user: ' . $id_individuo);

                } catch (ClientException $e) {
                    echo $e->getRequest() . "\n";
                    Log::error('Error inserting user : ' . $sData['numInt'] . "Error: " . $e);
                }
//
//
                try {
                    $t_alunos = DB::connection('mysql_siges')->table('t_alunos')->updateOrInsert([
                            'CD_CURSO' => $courseCode,
                            'CD_ALUNO' => $id_aluno,
                          ]
                    ,[
                        'PROTEGIDO' => 'N',
                        'AUTORIZA_PUB' => 'Y',
                        'CD_SITUA_FIN' => '1',
                        'CD_SITUA_PAR' => '1',
                        'USER_NETPA' => $netpa,
                        'SUSPENSO' => 'N',
                        'ID_INDIVIDUO' => $id_individuo,
                        'ID_ALUNO' => $id_aluno
                    ]);
                    Log::info('Updated/Insert user: ' . $netpa);
                } catch (ClientException $e) {
                    echo $e->getRequest() . "\n";
                    Log::error('Error inserting user : ' . $sData['numInt'] . "Error: " . $e);
                }
            } else
                Log::info('Error User: ' . $netpa);

        }
    }

}
