<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MediumService
{
    private const MEDIUM_USERNAME = '@jkavuncuoglu';
    private const CACHE_KEY = 'medium_posts';
    private const CACHE_TTL = 3600; // 1 hour
    private const MAX_POSTS = 6;

    public function getPosts(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->fetchPosts();
        });
    }

    private function fetchPosts(): array
    {
        try {
            $url = 'https://medium.com/feed/' . self::MEDIUM_USERNAME;
            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                return [];
            }

            return $this->parseRss($response->body());
        } catch (\Exception $e) {
            Log::warning('Failed to fetch Medium posts: ' . $e->getMessage());

            return [];
        }
    }

    private function parseRss(string $xml): array
    {
        libxml_use_internal_errors(true);
        $feed = simplexml_load_string($xml);

        if ($feed === false) {
            return [];
        }

        $posts = [];
        $count = 0;

        foreach ($feed->channel->item as $item) {
            if ($count >= self::MAX_POSTS) {
                break;
            }

            $namespaces = $item->getNamespaces(true);
            $contentNs = $namespaces['content'] ?? null;
            $encoded = $contentNs ? (string) $item->children($contentNs)->encoded : '';

            $thumbnail = $this->extractThumbnail($encoded ?: (string) $item->description);
            $excerpt = $this->extractExcerpt($encoded ?: (string) $item->description);

            $tags = [];
            foreach ($item->category as $category) {
                $tags[] = (string) $category;
            }

            $pubDate = (string) $item->pubDate;
            $date = $pubDate ? date('M j, Y', strtotime($pubDate)) : '';

            $posts[] = [
                'title'     => (string) $item->title,
                'url'       => (string) $item->link,
                'date'      => $date,
                'thumbnail' => $thumbnail,
                'excerpt'   => $excerpt,
                'tags'      => array_slice($tags, 0, 3),
            ];

            $count++;
        }

        return $posts;
    }

    private function extractThumbnail(string $html): ?string
    {
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $html, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function extractExcerpt(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        if (strlen($text) > 160) {
            $text = substr($text, 0, 160);
            $lastSpace = strrpos($text, ' ');
            if ($lastSpace !== false) {
                $text = substr($text, 0, $lastSpace);
            }
            $text .= '…';
        }

        return $text;
    }
}
