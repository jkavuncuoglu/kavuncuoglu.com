<?php

namespace App\Services\Parsers;

class TextParser implements ParserInterface
{
    protected array $supportedMimeTypes = [
        'text/plain',
        'text/markdown',
        'text/x-markdown',
    ];

    public function parse(string $filePath): string
    {
        return file_get_contents($filePath);
    }

    public function supports(string $mimeType): bool
    {
        return in_array($mimeType, $this->supportedMimeTypes);
    }
}
