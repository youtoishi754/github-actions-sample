@extends('layouts.guest')

@section('title', '新規登録')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">お名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="山田 太郎">
            @error('name')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="you@example.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">パスワード</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="8文字以上">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-1">パスワード（確認）</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white"
                   placeholder="••••••••">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-amber-400 hover:bg-amber-500 text-amber-900 font-bold py-2.5 rounded-lg shadow transition text-sm">
            アカウントを作成する →
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-500">
            すでにアカウントをお持ちの方は
            <a href="{{ route('login') }}" class="text-amber-600 font-semibold hover:underline">ログイン</a>
        </p>
    </div>
@endsection
