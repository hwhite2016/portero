<?php

namespace App\Console\Commands;

use App\Models\Reserva;
use Illuminate\Console\Command;

class ReservaExpira extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reserva:expira';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expiracion de las reservas pasadas';

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
        $fecha = date('Y-m-d');
        $horafin = date('H:i:s');
        $reservas = Reserva::where('reservafecha', '<=', $fecha)
            ->where('reservahorafin', '<', $horafin)
            ->get();
        foreach($reservas as $reserva){
            $reserva->update([
                'reservaestado' => 0,
            ]);
        }
    }
}
