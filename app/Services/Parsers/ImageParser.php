<?php

namespace App\Services\Parsers;

use thiagoalessio\TesseractOCR\TesseractOCR;

class ImageParser implements ParserInterface
{
    protected array $supportedMimeTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    // SVG is text-based and not suitable for OCR
    protected array $svgMimeTypes = [
        'image/svg+xml',
    ];

    public function parse(string $filePath): string
    {
        // Check if it's an SVG
        $mimeType = mime_content_type($filePath);
        if (in_array($mimeType, $this->svgMimeTypes)) {
            return $this->parseSvg($filePath);
        }

        // Use Tesseract OCR for raster images
        return $this->parseWithOcr($filePath);
    }

    protected function parseWithOcr(string $filePath): string
    {
        try {
            $ocr = new TesseractOCR($filePath);
            $text = $ocr->run();

            return trim($text);
        } catch (\Exception $e) {
            // If OCR fails, return empty string
            // The user can still provide a manual description
            return '';
        }
    }

    protected function parseSvg(string $filePath): string
    {
        // For SVG, we extract any text elements
        $content = file_get_contents($filePath);

        // Simple regex to extract text from SVG
        preg_match_all('/<text[^>]*>(.*?)<\/text>/si', $content, $matches);

        if (!empty($matches[1])) {
            return implode(' ', array_map('strip_tags', $matches[1]));
        }

        return '';
    }

    public function supports(string $mimeType): bool
    {
        return in_array($mimeType, array_merge($this->supportedMimeTypes, $this->svgMimeTypes));
    }
}
