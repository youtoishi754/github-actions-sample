@extends('layouts.app')

@section('title', 'メモ編集')

@section('content')
<h1>メモ編集</h1>

<form method="POST" action="{{ route('memos.update', $memo) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="title">タイトル <span>*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title', $memo->title) }}" maxlength="100" required>
        @error('title')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="body">本文</label>
        <textarea id="body" name="body">{{ old('body', $memo->body) }}</textarea>
        @error('body')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">更新</button>
    <a href="{{ route('memos.show', $memo) }}">キャンセル</a>
</form>
@endsection
