@extends('layouts.guest')

@section('title', 'パスワードの確認')

@section('content')
    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 mb-6">
        <span class="text-2xl">🔒</span>
        <p class="text-sm text-amber-800 leading-relaxed">
            セキュリティ保護のため、パスワードを再入力してください。
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

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

        <button type="submit"
                class="w-full bg-amber-400 hover:bg-amber-500 text-amber-900 font-bold py-2.5 rounded-lg shadow transition text-sm">
            確認する →
        </button>
    </form>
@endsection
