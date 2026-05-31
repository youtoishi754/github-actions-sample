@extends('layouts.guest')

@section('title', 'メールアドレスの確認')

@section('content')
    <div class="text-center mb-6">
        <div class="text-5xl mb-3">📬</div>
        <p class="text-sm text-gray-600 leading-relaxed">
            確認メールをお送りしました。<br>
            メール内のリンクをクリックして認証を完了してください。
        </p>
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
            <span>✅</span> 確認メールを再送信しました。
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit"
                class="w-full bg-amber-400 hover:bg-amber-500 text-amber-900 font-bold py-2.5 rounded-lg shadow transition text-sm">
            確認メールを再送信
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="w-full text-sm text-gray-400 hover:text-gray-600 py-2 transition">
            ログアウト
        </button>
    </form>
@endsection
