<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportWord;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $words = Word::query()->latest()->get();
        return view('admin.word', compact('words'));
    }

    public function semantics(Word $word)
    {
        $semantics = $word->semantics;

        $duplicates = [];
        foreach ($semantics as $semantic) {
            $duplicates[] = $semantic->semantic;
        }
        $duplicates = array_count_values($duplicates);


        return view('admin.semantics', compact('semantics', 'duplicates', 'word'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = Validator::make($request->all(), [
            'word' => ['required', 'string', 'max:64', 'min:2'],
        ])->validated();

        Word::query()->create($validated);
        return to_route('admin.word.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word): \Illuminate\Http\RedirectResponse
    {
        $word->forceDelete();
        return to_route('admin.word.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFile(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'file' => ['required', File::types(['xlsx', 'txt'])]
        ]);

        $uploaded_file = ($request->file('file'));

        switch ($uploaded_file->extension()) {
            case 'txt':
                $url = $uploaded_file;
                $lines = file($url, FILE_IGNORE_NEW_LINES);
                $arrays = array_map(function ($array) {
                    $columns = ['word'];
                    return array_combine($columns, array_map('trim', $array));
                }, array_chunk($lines, 1));

                $request->file('file')->store('files');
                Word::query()->insert($arrays);

                break;
            case 'xlsx':
                Excel::import(new ImportWord(), $request->file('file')->store('files'));
                break;
            default:
                dd('hi');

        }
        return to_route('admin.word.index');
    }
}
