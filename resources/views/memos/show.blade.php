@extends('layouts.app')

@section('title', $memo->title)

@section('content')
<h1>{{ $memo->title }}</h1>

<p>{{ $memo->body }}</p>

<div>
    <a href="{{ route('memos.edit', $memo) }}">編集</a>

    <form method="POST" action="{{ route('memos.destroy', $memo) }}" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
    </form>

    <a href="{{ route('memos.index') }}">一覧へ戻る</a>
</div>
@endsection
