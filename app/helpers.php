<?php

use App\Models\User;
use Illuminate\Support\Str;
use VStelmakh\UrlHighlight\Highlighter\HtmlHighlighter;
use VStelmakh\UrlHighlight\UrlHighlight;

if (! function_exists('clickify')) {
    function clickify(string $text, string $classes = ''): string
    {
        $urlHighlight = new UrlHighlight(
            highlighter: new HtmlHighlighter(attributes: ['class' => $classes])
        );

        if ($urlHighlight->isUrl($text) && Str::endsWith($text, '.gif')) {
            return '<a href="'.$text.'">'.$text.'</a><img src="'.$text.'" alt="GIF">';
        }

        return strip_tags($urlHighlight->highlightUrls($text), '<a>');
    }
}

if (! function_exists('user')) {
    function user(): User
    {
        abort_if(is_null($user = auth()->user()), 403);

        return $user;
    }
}
