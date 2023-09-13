<?php

namespace App\Libraries;

class PDF extends \App\Libraries\PDF_TOC
{
    protected $numbers = false;

    function Numbering()
    {
        return $this->numbers;
    }

    function SetNumbering($val)
    {
        $this->numbers = $val;
    }

    // Page footer
    function Footer()
    {
        if ($this->Numbering()) {
            // Position at 0.5 cm from bottom
            $this->SetY(-10);
            // Arial italic 8
            $this->SetFont('Arial', '', 8);
            // Page number
            $this->Cell(0, 3.5, $this->PageNo(), 0, 0, 'R');
        }
    }
}