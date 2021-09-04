<?php

namespace App\Exports;

use App\Models\Invitado;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvitadosExport implements FromCollection
{
    protected $reservaid;

    public function __construct(array $reservaid)
    {
        $this->reservaid = $reservaid;
    }

    public function collection()
    {

        $invitados = Invitado::where('reservaid', $this->reservaid)
        ->select('invitadodocumento','invitadonombre', 'invitadoedad', 'invitadocelular')
        ->get();

        return $invitados;
    }
}
