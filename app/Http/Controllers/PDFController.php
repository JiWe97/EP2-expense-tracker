<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    //
    public function generatePDF()
    {
        $data = ['title' => 'Welcome to Laravel PDF Generation'];


        $pdf = PDF::loadView('pdf', $data);

        return $pdf->stream('document.pdf');
        // return $pdf->download('document.pdf');
    }
}
