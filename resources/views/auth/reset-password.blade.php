@extends('layouts.guest')

@section('title', '新しいパスワードを設定')

@section('content')
    <p class="text-sm text-gray-500 mb-5">新しいパスワードを入力してください。</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                   required autofocus autocomplete="username"
                   class="w-full border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 rounded-lg px-4 py-2.5 text-sm outline-none transition bg-gray-50 focus:bg-white">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">新しいパスワード</label>
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
            パスワードを更新 →
        </button>
    </form>
@endsection
