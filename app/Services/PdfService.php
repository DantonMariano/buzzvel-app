<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public function generatePdf($data)
    {
        $pdf = Pdf::loadView('pdf.template', ['holidays' => $data]);
        return $pdf->download('holiday-plans.pdf');
    }
}
