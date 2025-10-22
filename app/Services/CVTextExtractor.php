<?php
//app/Services/CVTextExtractor.php
namespace App\Services;

use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class CVTextExtractor
{
    // Extraer texto de un archivo PDF
    public function extraerTextoPDF($path)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        return $pdf->getText();
    }

    // Extraer texto de un archivo DOCX
    public function extraerTextoDOCX($path)
    {
        $phpWord = IOFactory::load($path);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }
        return $text;
    }
}
