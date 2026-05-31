@extends('layouts.app')

@section('title', 'メモ編集')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('memos.show', $memo) }}" class="text-amber-600 hover:text-amber-800 text-sm">← 詳細へ</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-xl font-bold text-amber-900">メモを編集</h1>
    </div>

    <div class="bg-yellow-50 border border-amber-200 rounded-xl shadow-md overflow-hidden">
        {{-- ノートのヘッダー部分 --}}
        <div class="bg-amber-300 px-6 py-3 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-red-400"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
            <div class="w-3 h-3 rounded-full bg-green-400"></div>
        </div>

        <form method="POST" action="{{ route('memos.update', $memo) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-600 mb-1">
                    タイトル <span class="text-red-500">*</span>
                    <span class="font-normal text-gray-400 text-xs">（最大100文字）</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $memo->title) }}"
                       maxlength="100" required autofocus
                       class="w-full border-0 border-b-2 border-amber-300 focus:border-amber-500 bg-transparent text-gray-800 text-lg font-medium py-2 outline-none transition">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-semibold text-gray-600 mb-1">本文</label>
                <textarea id="body" name="body" rows="12"
                          class="w-full bg-transparent border border-amber-200 focus:border-amber-400 rounded-lg p-3 text-gray-700 text-sm leading-7 resize-y outline-none transition"
                          style="background-image: repeating-linear-gradient(transparent, transparent 27px, #fde68a 28px); background-attachment: local;">{{ old('body', $memo->body) }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-amber-400 hover:bg-amber-500 text-amber-900 font-semibold px-6 py-2 rounded-lg shadow transition">
                    💾 更新する
                </button>
                <a href="{{ route('memos.show', $memo) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">キャンセル</a>
            </div>
        </form>
    </div>
</div>
@endsection
