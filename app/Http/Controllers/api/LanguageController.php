<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function __invoke($language)
    {
        if (in_array($language, config('app.available_locales'))) {
            session()->put('lang', $language);
        } else {
            session()->put('lang', 'fr');
        }

        return response()->json('Locale set to ' . ($language == 'fr' ? 'French' : 'German'));
    }
}
