<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Url;
use Illuminate\Validation\ValidationException;

class UrlService
{
    private $maxCodeGenerateAttempt;
    private $shortCodeLength;

    public function __construct()
    {
        $this->maxCodeGenerateAttempt = config('url-shortening.maxCodeGenerateAttempt', 10);
        $this->shortCodeLength = config('url-shortening.shortCodeLength', 6);
    }

    public function getUrlIfExists($longUrl): ?Url
    {
        $record = Url::where('user_id',auth()->id())->where('long_url', $this->formatUrl($longUrl))->whereNotNull('short_code')->first();
        return $record;
    }

    public function createShortUrl($data): ?Url
    {
        $record = Url::create([
            'user_id' => auth()->id(),
            'title' => $this->formatUrl($data['title']),
            'long_url' => $this->formatUrl($data['long_url']),
            'short_code' => $this->generateUniqueCode()
        ]);
        return $record;
    }

    private function generateUniqueCode(): string
    {
        $maxAttempts = $this->maxCodeGenerateAttempt;
        while ($maxAttempts-- > 0) {
            $code = Str::random($this->shortCodeLength);

            if (!Url::where('short_code', $code)->exists()) {
                return $code;
            }
        }

        throw ValidationException::withMessages([
            'short_code' => 'A unique short code cannot be generated. Please try again.',
        ]);
    }

    public function formatUrl($rawUrl): string
    {
        return rtrim(trim($rawUrl), '/');
    }
}
