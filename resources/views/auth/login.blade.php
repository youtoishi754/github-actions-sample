@extends('layouts.guest')

@section('title', 'ログイン')

@section('content')
    @if (session('status'))
        <div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
            <span>✅</span> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="you@example.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">パスワード</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-amber-500">
                ログイン状態を保持
            </label>
            <a href="{{ route('password.request') }}" class="text-xs text-amber-600 hover:text-amber-800 hover:underline transition">
                パスワードを忘れた場合
            </a>
        </div>

        <button type="submit"
                class="w-full bg-amber-400 hover:bg-amber-500 text-amber-900 font-bold py-2.5 rounded-lg shadow transition text-sm">
            ログイン →
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-500">
            アカウントをお持ちでない方は
            <a href="{{ route('register') }}" class="text-amber-600 font-semibold hover:underline">新規登録</a>
        </p>
    </div>
@endsection
