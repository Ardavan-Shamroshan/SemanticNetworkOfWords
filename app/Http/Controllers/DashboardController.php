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
        $id = auth()->id();
        $words = Word::query()
            // ->where('showed', '<', $mostShowed)
            ->whereDoesntHave('users', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->inRandomOrder()
            ->take(5)
            ->get();

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
                auth()->user()->words()->attach($word->id);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->with('step', 'complete');
    }
}
