<?php

namespace App\Http\Controllers;

use App\Models\SemanticNetworkWord;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\TestFixture\func;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $words = Word::query()->inRandomOrder()->limit(5)->get();
        return view('home.semantic-network', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $inputs = $request->except('_token');

        try {
            foreach ($inputs as $key => $value) {
                $word = Word::query()->where('word', str_replace('_', ' ', $key))->first();
                $value = array_filter($value);
                DB::transaction(static function () use ($word, $value) {
                    foreach ($value as $item) {
                        $semantic = SemanticNetworkWord::query()->create(['semantic' => $item]);
                        $word?->semantics()->attach($semantic->id);
                    }
                });
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->with('step', 'complete');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
