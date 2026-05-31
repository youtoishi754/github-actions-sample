<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'メモ帳') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-amber-50 min-h-screen flex">

    {{-- 左パネル（デスクトップのみ）--}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-amber-400 to-amber-600 flex-col items-center justify-center p-12 text-amber-900">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-4">
            <div class="bg-white/30 rounded-3xl p-6 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-amber-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight">メモ帳</h1>
            <p class="text-amber-800 text-center text-lg leading-relaxed">
                アイデアを、すばやく記録。<br>いつでも見返せる自分だけのメモ帳。
            </p>
        </a>
        <ul class="mt-12 space-y-4 text-sm text-amber-900">
            <li class="flex items-center gap-3">
                <span class="bg-white/40 rounded-full p-1.5">✅</span>
                アカウント登録・ログインでいつでも利用可能
            </li>
            <li class="flex items-center gap-3">
                <span class="bg-white/40 rounded-full p-1.5">✅</span>
                自分のメモは自分だけが見られる
            </li>
            <li class="flex items-center gap-3">
                <span class="bg-white/40 rounded-full p-1.5">✅</span>
                タイトル・本文を自由に入力、編集、削除
            </li>
        </ul>
    </div>

    {{-- 右パネル（フォームエリア）--}}
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">

        {{-- モバイル用ロゴ --}}
        <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2 mb-8 text-amber-900 font-bold text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            メモ帳
        </a>

        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl border border-amber-100 overflow-hidden">
                <div class="bg-amber-400 px-6 py-4">
                    <h2 class="text-lg font-bold text-amber-900">@yield('title', 'メモ帳')</h2>
                </div>
                <div class="p-8">
                    @yield('content')
                </div>
            </div>
            <p class="mt-6 text-center text-xs text-gray-400">
                <a href="{{ url('/') }}" class="hover:text-amber-600 transition">← トップページへ戻る</a>
            </p>
        </div>
    </div>

</body>
</html>
