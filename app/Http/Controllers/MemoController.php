<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemoController extends Controller
{
    public function index(): View
    {
        $memos = auth()->user()->memos()->latest()->get();

        return view('memos.index', compact('memos'));
    }

    public function create(): View
    {
        return view('memos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'body'  => ['nullable', 'string'],
        ]);

        auth()->user()->memos()->create($validated);

        return redirect()->route('memos.index');
    }

    public function show(Memo $memo): View
    {
        $this->authorize('view', $memo);

        return view('memos.show', compact('memo'));
    }

    public function edit(Memo $memo): View
    {
        $this->authorize('update', $memo);

        return view('memos.edit', compact('memo'));
    }

    public function update(Request $request, Memo $memo): RedirectResponse
    {
        $this->authorize('update', $memo);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'body'  => ['nullable', 'string'],
        ]);

        $memo->update($validated);

        return redirect()->route('memos.show', $memo);
    }

    public function destroy(Memo $memo): RedirectResponse
    {
        $this->authorize('delete', $memo);

        $memo->delete();

        return redirect()->route('memos.index');
    }
}
