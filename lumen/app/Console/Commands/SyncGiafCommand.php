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
class SyncGiafCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update:giafdb";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync webservice database and update GIAF";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $siges = SyncGiafCommand::syncFuncionario();
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }


    public function syncFuncionario()
    {
        $employees = DB::table('employees')->where('OU','ISCAC')->get();
        foreach ($employees as $employee) {

            $emp_num = $employee->employeeNumber;
            $emp_nom = $employee->name;
            $email2 = $employee->emailInst;
            // check if user exists
            $validate = DB::connection('mysql_giaf')->table('funcionario')->where('email2', $email2)->first();
            if (is_null($validate)) {
                try {
                    $connection = DB::connection('mysql_giaf')->table('funcionario')->updateOrInsert([
                        'emp_num' => $num = sprintf("%06d", $emp_num),
                        'emp_nom' => $emp_nom,
                        'email2' => $email2
                    ]);
                    Log::info('Insert employee: ' . $emp_num . ' ' . $emp_nom . ' ' . $email2);

                } catch (ClientException $e) {
                    echo $e->getRequest() . "\n";
                    Log::error('Error inserting employee : ' . $emp_num . "Error: " . $e);
                }
            }

            # id_caloborador, emp_num, emp_nome, emp_sit, emp_sec_serv, emp_carreira, emp_cat_func, emp_cat_int, email2, emp_inc_dt, data_upd, user_upd, emp_state, emp_state_desc, sexo
            //'63391', '364', 'Adriana Filipa de Jesus Silva', '116', '50011', '1', '126', '0', 'afsilva@iscac.pt', '1991-09-24 00:00:00', '1575619230', 'portaluser', '116', 'CTFP - Termo Resolutivo Certo', 'F'

            # employeeNumber, name, professionalCategory, teacher, phd, emailInst, identification, identificationType, nationality, nif, gender, ou, birthDate
            //'364', 'Adriana Filipa de Jesus Silva', 'Assistente Convidado', '1', '0', 'afsilva@iscac.pt', '13944078-0ZX9', 'CARTAO_CIDADAO_PORTUGUES', 'PT', '245115102', 'F', 'ISCAC', NULL

        }
    }

            public function syncColaborador(){
        $colaboradores = DB::table('colaboradores')->where('OU','ISCAC')->get();
        foreach ($employees as $employee) {

            $validate = DB::connection('mysql_giaf')->table('colaborador')->where('email2',$email2)->first();
            if (is_null($validate)) {
                try {
                    $connection = DB::connection('mysql_giaf')->table('funcionario')->updateOrInsert([
                        'id_caloborador' => $num = sprintf("%06d", $emp_num),
                        'emp_num' => $emp_nom,
                        'emp_nome' => $email2


                    ]);
                    Log::info('Insert employee: ' . $emp_num . ' ' . $emp_nom . ' ' .  $email2);

                } catch (ClientException $e) {
                    echo $e->getRequest() . "\n";
                    Log::error('Error inserting employee : ' . $emp_num . "Error: " . $e);
                }
            }

        }

    }
}
