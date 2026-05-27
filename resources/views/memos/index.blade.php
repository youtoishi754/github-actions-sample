@extends('layouts.app')

@section('title', 'メモ一覧')

@section('content')
<h1>メモ一覧</h1>

<a href="{{ route('memos.create') }}">新規作成</a>

@forelse ($memos as $memo)
    <div>
        <a href="{{ route('memos.show', $memo) }}">{{ $memo->title }}</a>
        <span>{{ $memo->created_at->format('Y/m/d') }}</span>
    </div>
@empty
    <p>メモがありません。</p>
@endforelse
@endsection
