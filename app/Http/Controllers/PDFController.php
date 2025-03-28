<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idols;
use Illuminate\Http\Request;
use FPDF;

class PDFController extends Controller
{
    public function generadorPDF(Request $request)
    {
        $ID = $request->ID;

        $queryPDF = Idols::select(['nombre', 'edad', 'datos_curiosos', 'actividad'])
                        ->where('id', $ID)
                        ->get(); // Usamos first() en lugar de get() para obtener un solo registro

        if (!$queryPDF) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Agregar texto al PDF con los datos
        $pdf->Cell(0, 10, 'Informacion del Idol:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nombre: ' . $queryPDF, 0, 1);


        $pdfContent = $pdf->Output('S'); // 'S' devuelve el PDF como string

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }
}
