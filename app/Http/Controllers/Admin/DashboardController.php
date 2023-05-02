<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $words = Word::query()->latest()->get();
        return view('admin.word', compact('words'));
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse {
        $validated = Validator::make($request->all(), [
            'word' => ['required', 'string', 'max:64', 'min:2'],
        ])->validated();

        Word::query()->create($validated);
        return to_route('admin.word.index');
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
    public function destroy(Word $word): \Illuminate\Http\RedirectResponse {
        $word->forceDelete();
        return to_route('admin.word.index');
    }
}
