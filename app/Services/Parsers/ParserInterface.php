<?php

namespace App\Services\Parsers;

interface ParserInterface
{
    /**
     * Parse the file and extract text content.
     *
     * @param string $filePath Full path to the file
     * @return string Extracted text content
     */
    public function parse(string $filePath): string;

    /**
     * Check if this parser supports the given MIME type.
     *
     * @param string $mimeType
     * @return bool
     */
    public function supports(string $mimeType): bool;
}
