<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RegistroExpira extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registro:expira';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expiración de los registros abandonados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return 0;
        $fecha = date('Y-m-d H:i:s');
        $NuevaFecha = date("Y-m-d H:i:s", strtotime('-24 hour' , strtotime($fecha)) );
        $users = User::where('created_at', '<=', $NuevaFecha)
            ->where('profile_photo_path', '<>', null)
            ->where('email_verified_at', null)
            ->get();

        foreach($users as $user){
            $user->delete();
        }
    }
}
