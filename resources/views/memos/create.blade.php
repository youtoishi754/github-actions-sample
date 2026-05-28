@extends('layouts.app')

@section('title', 'メモ新規作成')

@section('content')
<h1>メモ新規作成</h1>

<form method="POST" action="{{ route('memos.store') }}">
    @csrf

    <div>
        <label for="title">タイトル <span>*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="100" required>
        @error('title')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="body">本文</label>
        <textarea id="body" name="body">{{ old('body') }}</textarea>
        @error('body')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">保存</button>
    <a href="{{ route('memos.index') }}">キャンセル</a>
</form>
@endsection
