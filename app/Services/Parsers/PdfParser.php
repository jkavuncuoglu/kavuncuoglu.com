<?php

namespace App\Services\Parsers;

use Smalot\PdfParser\Parser;

class PdfParser implements ParserInterface
{
    protected array $supportedMimeTypes = [
        'application/pdf',
    ];

    public function parse(string $filePath): string
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);

        return $pdf->getText();
    }

    public function supports(string $mimeType): bool
    {
        return in_array($mimeType, $this->supportedMimeTypes);
    }
}
