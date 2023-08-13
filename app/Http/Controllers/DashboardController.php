<?php

namespace App\Http\Controllers;

use App\Models\SemanticNetworkWord;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mostVisitedWord = Word::query()->orderBy('showed', 'desc')->first();
        $lessVisitedWord = Word::query()->orderBy('showed')->first();
        $words = Word::query()->orderBy('showed', 'desc')->inRandomOrder()->get();

        foreach ($words as $key => $value) {
            if ($value->showed == $mostVisitedWord->showed || $value->showed > $lessVisitedWord->showed)
                $words->forget($key);
        }

        if ($words->isEmpty())
            $words = Word::query()->inRandomOrder()->limit(5)->get();
        else $words->take(5);


        return view('home.semantic-network', compact('words'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');

        try {
            foreach ($inputs as $key => $value) {
                $word = Word::query()->where('word', str_replace('_', ' ', $key))->first();
                $value = array_filter($value);
                DB::transaction(static function () use ($word, $value) {
                    foreach ($value as $item) {
                        $semantic = SemanticNetworkWord::query()->create(['semantic' => $item]);
                        $word?->semantics()->attach($semantic->id);
                        $semantic?->users()->attach(auth()->id(), ['word_id' => $word->id]);
                    }
                });
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->with('step', 'complete');
    }
}
