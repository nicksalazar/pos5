<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\Documents;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImportExport implements  FromView, ShouldAutoSize
{
    use Exportable;

    public function records($records) {
        $this->records = $records;

        return $this;
    }

    public function view(): View {
        return view('tenant.reports.imports.report_excel', [
            'records'=> $this->records,
        ]);
    }


}
