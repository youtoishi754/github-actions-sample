@extends('layouts.app')

@section('title', 'メモ一覧')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-amber-900">📝 メモ一覧</h1>
    <a href="{{ route('memos.create') }}"
       class="flex items-center gap-1 bg-amber-400 hover:bg-amber-500 text-amber-900 font-semibold px-4 py-2 rounded-lg shadow transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        新規作成
    </a>
</div>

@forelse ($memos as $memo)
    <a href="{{ route('memos.show', $memo) }}" class="block group">
        <div class="bg-yellow-100 hover:bg-yellow-200 border-l-4 border-amber-400 rounded-lg shadow-sm hover:shadow-md transition mb-4 p-5">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-gray-800 text-base truncate group-hover:text-amber-700">{{ $memo->title }}</h2>
                    @if ($memo->body)
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $memo->body }}</p>
                    @endif
                </div>
                <span class="shrink-0 text-xs text-gray-400 mt-1">{{ $memo->updated_at->format('Y/m/d') }}</span>
            </div>
        </div>
    </a>
@empty
    <div class="text-center py-20">
        <p class="text-5xl mb-4">📭</p>
        <p class="text-gray-500 mb-6">まだメモがありません</p>
        <a href="{{ route('memos.create') }}"
           class="inline-block bg-amber-400 hover:bg-amber-500 text-amber-900 font-semibold px-6 py-2 rounded-lg shadow transition">
            最初のメモを作成する
        </a>
    </div>
@endforelse
@endsection
