<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenRequest;
use App\Models\Url;
use App\Services\UrlService;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::where('user_id', auth()->id())->latest()->get();
        return view('urls.index', compact('urls'));
    }

    public function store(UrlShortenRequest $request, UrlService $urlService){

        $url = $urlService->getUrlIfExists($request->input('long_url'));
        if(!$url){
            $url = $urlService->createShortUrl($request->validated());
        }

        return redirect(route('urls.index'))->with('success', 'URL shortened successfully!');
    }

    public function redirectOriginalUrl($shortCode)
    {
        $shortUrl = Url::where('short_code',$shortCode)->first();

        $shortUrl->increment('visits');

        return redirect($shortUrl->long_url);
    }
}
