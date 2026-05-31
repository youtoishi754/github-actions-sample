@extends('layouts.app')

@section('title', $memo->title)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('memos.index') }}" class="text-amber-600 hover:text-amber-800 text-sm">← 一覧へ</a>
    </div>

    <div class="bg-yellow-50 border border-amber-200 rounded-xl shadow-md overflow-hidden">
        {{-- ノートのヘッダー部分 --}}
        <div class="bg-amber-300 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
            <span class="text-xs text-amber-800">
                作成: {{ $memo->created_at->format('Y年m月d日 H:i') }}
                @if ($memo->created_at->ne($memo->updated_at))
                    &nbsp;·&nbsp; 更新: {{ $memo->updated_at->format('Y年m月d日 H:i') }}
                @endif
            </span>
        </div>

        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b border-amber-200">{{ $memo->title }}</h1>

            @if ($memo->body)
                <div class="text-gray-700 text-sm leading-8 whitespace-pre-wrap"
                     style="background-image: repeating-linear-gradient(transparent, transparent 31px, #fde68a 32px); background-attachment: local; min-height: 120px;">{{ $memo->body }}</div>
            @else
                <p class="text-gray-400 text-sm italic">本文なし</p>
            @endif
        </div>

        <div class="bg-amber-50 border-t border-amber-200 px-6 py-4 flex items-center gap-3">
            <a href="{{ route('memos.edit', $memo) }}"
               class="flex items-center gap-1 bg-amber-400 hover:bg-amber-500 text-amber-900 font-semibold px-4 py-2 rounded-lg text-sm shadow transition">
                ✏️ 編集
            </a>

            <form method="POST" action="{{ route('memos.destroy', $memo) }}"
                  onsubmit="return confirm('このメモを削除しますか？')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-4 py-2 rounded-lg text-sm transition">
                    🗑 削除
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
