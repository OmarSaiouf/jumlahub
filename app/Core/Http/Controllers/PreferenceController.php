<?php

namespace App\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreferenceController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'language' => 'nullable|exists:languages,code',
            'currency' => 'nullable|exists:currencies,code',
        ]);

        if ($request->filled('language')) {
            Cookie::queue('language', $request->language, 60 * 24 * 30);
        }

        if ($request->filled('currency')) {
            Cookie::queue('currency', $request->currency, 60 * 24 * 30);
        }

        return back();
    }
}