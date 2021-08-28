<?php

namespace App\Console\Commands;

use App\Models\EventCalendar;
use Illuminate\Console\Command;

class EventoCalendario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evento:calendario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizacion diaria de los eventos del calendario';

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
        $evento = EventCalendar::whereFecha($fecha)->get();
        foreach($evento as $ev){
            $ev->update([
                'fecha' => date('Y-m-d' , strtotime($ev->fecha." + 7 days")),
                'start' => date('Y-m-d H:i:s' , strtotime($ev->start." + 7 days")),
                'end' => date('Y-m-d H:i:s' , strtotime($ev->end." + 7 days")),
                'backgroundColor'=>'#3788D8',
            ]);
        }
    }
}
