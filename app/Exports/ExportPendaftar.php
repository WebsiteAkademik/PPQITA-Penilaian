<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ExportPendaftar implements FromCollection
{
    protected $pendaftars;

    public function __construct(Collection $pendaftars)
    {
        $this->pendaftars = $pendaftars;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->pendaftars;
    }
}
