<?php

namespace App\Libraries;

use tFPDF;

class AlphaPDF extends tFpdf
{
    protected $extgstates = [];

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    public function SetAlpha($alpha, string $bm = 'Normal'): void
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(['ca' => $alpha, 'CA' => $alpha, 'BM' => '/'.$bm]);
        $this->SetExtGState($gs);
    }

    public function AddExtGState($parms): int
    {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n]['parms'] = $parms;

        return $n;
    }

    public function SetExtGState($gs): void
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    protected function _enddoc()
    {
        if (! empty($this->extgstates) && $this->PDFVersion < '1.4') {
            $this->PDFVersion = '1.4';
        }

        parent::_enddoc();
    }

    public function _putextgstates(): void
    {
        $counter = count($this->extgstates);
        for ($i = 1; $i <= $counter; $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_put('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_put(sprintf('/ca %.3F', $parms['ca']));
            $this->_put(sprintf('/CA %.3F', $parms['CA']));
            $this->_put('/BM '.$parms['BM']);
            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    protected function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_put('/ExtGState <<');
        foreach ($this->extgstates as $k => $extgstate) {
            $this->_put('/GS'.$k.' '.$extgstate['n'].' 0 R');
        }

        $this->_put('>>');
    }

    protected function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }
}
