<?php

namespace App\Imports;

use App\Models\Invitado;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class InvitadosImport implements ToModel, WithHeadingRow, WithValidation
{
    private $numRows = 0;

    public function model(array $row)
    {
        ++$this->numRows;
        return new Invitado([
            'reservaid' => session('reservaid'),
            'invitadodocumento' => $row['invitadodocumento'],
            'invitadonombre' => $row['invitadonombre'],
            'invitadoedad' => ($row['invitadoedad']),
            'invitadocelular' => $row['invitadocelular']
        ]);
    }

    public function rules(): array
    {
        return [
            'invitadodocumento' => 'required|max:30',
            'invitadonombre' => 'required|max:60',
            'invitadoedad' => 'required|max:10',
            'invitadocelular' => 'nullable|max:15',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
