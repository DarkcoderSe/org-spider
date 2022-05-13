<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class OrganizationsExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    protected $organizations;

    public function __construct(array $organizations)
    {
        $this->organizations = $organizations;
    }

    public function array(): array
    {
        return $this->organizations;
    }

    public function headings(): array
    {
        return ["Company Name", "Company URL", "Source", "Contact Name", "LinkedIn Profile", "Job Title", "Email Address", "Headquater Address"];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12.5,
            'B' => 12.5,
            'C' => 12.5,
            'D' => 12.5,
            'E' => 12.5,
            'F' => 12.5,
            'G' => 12.5,
            'H' => 12.5
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
