<?php

namespace App\Services\Parsers;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\ListItem;
use PhpOffice\PhpWord\Element\ListItemRun;

class WordParser implements ParserInterface
{
    protected array $supportedMimeTypes = [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function parse(string $filePath): string
    {
        $phpWord = IOFactory::load($filePath);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            $text .= $this->extractTextFromElements($section->getElements());
        }

        return trim($text);
    }

    protected function extractTextFromElements(iterable $elements): string
    {
        $text = '';

        foreach ($elements as $element) {
            if ($element instanceof Text) {
                $text .= $element->getText() . ' ';
            } elseif ($element instanceof TextRun) {
                $text .= $this->extractTextFromElements($element->getElements());
                $text .= "\n";
            } elseif ($element instanceof ListItem || $element instanceof ListItemRun) {
                $text .= '- ' . $this->extractTextFromElements($element->getElements ?? []);
                $text .= "\n";
            } elseif ($element instanceof Table) {
                foreach ($element->getRows() as $row) {
                    foreach ($row->getCells() as $cell) {
                        $text .= $this->extractTextFromElements($cell->getElements());
                        $text .= "\t";
                    }
                    $text .= "\n";
                }
            } elseif (method_exists($element, 'getText')) {
                $text .= $element->getText() . ' ';
            } elseif (method_exists($element, 'getElements')) {
                $text .= $this->extractTextFromElements($element->getElements());
            }
        }

        return $text;
    }

    public function supports(string $mimeType): bool
    {
        return in_array($mimeType, $this->supportedMimeTypes);
    }
}
