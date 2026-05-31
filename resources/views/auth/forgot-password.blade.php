@extends('layouts.guest')

@section('title', 'パスワードをリセット')

@section('content')
    <p class="text-sm text-gray-500 mb-5 leading-relaxed">
        登録済みのメールアドレスを入力してください。<br>
        パスワードリセット用のリンクをお送りします。
    </p>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
            <span>✅</span> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="you@example.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-amber-400 hover:bg-amber-500 text-amber-900 font-bold py-2.5 rounded-lg shadow transition text-sm">
            リセットリンクを送信 →
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
        <a href="{{ route('login') }}" class="text-sm text-amber-600 hover:underline">← ログインに戻る</a>
    </div>
@endsection
