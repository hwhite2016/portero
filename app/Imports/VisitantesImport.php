<?php

namespace App\Imports;
use App\Models\Persona;
use App\Models\Visitante;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class VisitantesImport implements ToModel, WithHeadingRow, WithValidation
{

    private $numRows = 0;

    public function model(array $row)
    {
        ++$this->numRows;
        return new Persona([
            'tipodocumentoid' => 1,
            'personadocumento' => $row['personadocumento'],
            'personanombre' => $row['personanombre'],
            //'personafechanacimiento' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['personafechanacimiento']),
            'personafechanacimiento' => ($row['personafechanacimiento']),
            'personacorreo' => $row['personacorreo'],
            'personacelular' => $row['personacelular']
        ]);
    }

    public function rules(): array
    {
        return [
            'personadocumento' => 'required|max:15',
            'personanombre' => 'required|max:45',
            'personafechanacimiento' => 'required',
            'personacorreo' => 'required|email',
            'personacelular' => 'nullable|max:15',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
