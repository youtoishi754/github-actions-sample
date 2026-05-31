<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>メモ帳アプリ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-amber-50 min-h-screen flex flex-col">

    {{-- ナビゲーション --}}
    <nav class="bg-amber-400 shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="flex items-center gap-2 text-amber-900 font-bold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                メモ帳
            </span>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('memos.index') }}"
                       class="bg-amber-900 text-amber-50 text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-amber-800 transition">
                        マイメモへ
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-amber-900 font-medium hover:underline">ログイン</a>
                    <a href="{{ route('register') }}"
                       class="bg-amber-900 text-amber-50 text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-amber-800 transition">
                        無料で始める
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ヒーローセクション --}}
    <section class="bg-gradient-to-b from-amber-400 to-amber-50 py-20 text-center px-4">
        <div class="max-w-2xl mx-auto">
            <div class="text-7xl mb-6">📝</div>
            <h1 class="text-4xl font-extrabold text-amber-900 mb-4 leading-tight">
                シンプルで使いやすい<br>あなたのメモ帳
            </h1>
            <p class="text-amber-800 text-lg mb-8 leading-relaxed">
                アイデア・タスク・ひらめきを、すばやく記録。<br>
                いつでもどこでも、自分だけのメモ空間。
            </p>
            @auth
                <a href="{{ route('memos.index') }}"
                   class="inline-block bg-amber-900 text-amber-50 font-bold text-lg px-8 py-3 rounded-full shadow-lg hover:bg-amber-800 transition">
                    マイメモを見る →
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-block bg-amber-900 text-amber-50 font-bold text-lg px-8 py-3 rounded-full shadow-lg hover:bg-amber-800 transition">
                    今すぐ無料で始める →
                </a>
                <p class="mt-3 text-sm text-amber-700">
                    すでにアカウントをお持ちの方は
                    <a href="{{ route('login') }}" class="underline hover:text-amber-900">ログイン</a>
                </p>
            @endauth
        </div>
    </section>

    {{-- 使い方 3ステップ --}}
    <section class="py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-amber-900 text-center mb-10">📖 かんたん 3 ステップで始めよう</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Step 1 --}}
                <div class="bg-white border border-amber-200 rounded-xl shadow-sm p-6 text-center relative">
                    {{-- 図：アカウント登録（ユーザー＋チェックマーク） --}}
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" class="w-24 h-24">
                            {{-- 背景円 --}}
                            <circle cx="40" cy="40" r="38" fill="#fef3c7" stroke="#fcd34d" stroke-width="2"/>
                            {{-- 人物：頭 --}}
                            <circle cx="35" cy="28" r="9" fill="#fbbf24"/>
                            {{-- 人物：胴体 --}}
                            <path d="M18 58 Q18 44 35 44 Q52 44 52 58" fill="#fbbf24"/>
                            {{-- チェックマーク（緑） --}}
                            <circle cx="55" cy="26" r="11" fill="#34d399"/>
                            <polyline points="49,26 54,31 62,21" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="w-10 h-10 bg-amber-400 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-3">1</div>
                    <h3 class="font-bold text-gray-800 mb-2">アカウントを作成</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        メールアドレスとパスワードだけで登録完了。<br>
                        30秒でメモが書けるようになります。
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white border border-amber-200 rounded-xl shadow-sm p-6 text-center relative">
                    {{-- 図：メモ帳にペンで書く --}}
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" class="w-24 h-24">
                            {{-- 背景円 --}}
                            <circle cx="40" cy="40" r="38" fill="#fef3c7" stroke="#fcd34d" stroke-width="2"/>
                            {{-- メモ帳 --}}
                            <rect x="16" y="18" width="36" height="46" rx="3" fill="white" stroke="#d97706" stroke-width="2"/>
                            {{-- 罫線 --}}
                            <line x1="22" y1="30" x2="46" y2="30" stroke="#fcd34d" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="22" y1="38" x2="46" y2="38" stroke="#fcd34d" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="22" y1="46" x2="38" y2="46" stroke="#fcd34d" stroke-width="1.5" stroke-linecap="round"/>
                            {{-- ペン --}}
                            <g transform="rotate(-35 52 44)">
                                <rect x="48" y="30" width="8" height="22" rx="2" fill="#f59e0b"/>
                                <polygon points="48,52 56,52 52,60" fill="#92400e"/>
                                <line x1="52" y1="59" x2="52" y2="62" stroke="#1f2937" stroke-width="1.5" stroke-linecap="round"/>
                            </g>
                        </svg>
                    </div>
                    <div class="w-10 h-10 bg-amber-400 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-3">2</div>
                    <h3 class="font-bold text-gray-800 mb-2">メモを書く</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        タイトルと本文を入力してすぐ保存。<br>
                        思いついたアイデアや日々のタスクを記録しましょう。
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white border border-amber-200 rounded-xl shadow-sm p-6 text-center relative">
                    {{-- 図：メモ一覧を見る（虫眼鏡＋リスト） --}}
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" class="w-24 h-24">
                            {{-- 背景円 --}}
                            <circle cx="40" cy="40" r="38" fill="#fef3c7" stroke="#fcd34d" stroke-width="2"/>
                            {{-- メモ一覧（カード3枚） --}}
                            <rect x="12" y="20" width="34" height="12" rx="2" fill="white" stroke="#fcd34d" stroke-width="1.5"/>
                            <line x1="16" y1="25" x2="38" y2="25" stroke="#d97706" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="16" y1="29" x2="32" y2="29" stroke="#fcd34d" stroke-width="1" stroke-linecap="round"/>
                            <rect x="12" y="36" width="34" height="12" rx="2" fill="white" stroke="#fcd34d" stroke-width="1.5"/>
                            <line x1="16" y1="41" x2="38" y2="41" stroke="#d97706" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="16" y1="45" x2="28" y2="45" stroke="#fcd34d" stroke-width="1" stroke-linecap="round"/>
                            <rect x="12" y="52" width="34" height="12" rx="2" fill="white" stroke="#fcd34d" stroke-width="1.5"/>
                            <line x1="16" y1="57" x2="38" y2="57" stroke="#d97706" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="16" y1="61" x2="34" y2="61" stroke="#fcd34d" stroke-width="1" stroke-linecap="round"/>
                            {{-- 虫眼鏡 --}}
                            <circle cx="57" cy="38" r="10" fill="none" stroke="#f59e0b" stroke-width="3"/>
                            <line x1="64" y1="45" x2="70" y2="52" stroke="#92400e" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="w-10 h-10 bg-amber-400 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-3">3</div>
                    <h3 class="font-bold text-gray-800 mb-2">いつでも見返す・編集</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        書いたメモは一覧でまとめて確認。<br>
                        編集・削除も自由自在で、常に最新の状態を保てます。
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- 特徴 --}}
    <section class="bg-yellow-100 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-xl font-bold text-amber-900 text-center mb-8">✨ このアプリの特徴</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-start gap-3 bg-white rounded-lg p-4 shadow-sm border border-amber-100">
                    <span class="text-2xl">🔒</span>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm">自分のメモは自分だけ</h4>
                        <p class="text-xs text-gray-500 mt-1">ログインしないと他の人のメモは一切見えません。プライバシーを守ります。</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 bg-white rounded-lg p-4 shadow-sm border border-amber-100">
                    <span class="text-2xl">⚡</span>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm">シンプルで高速</h4>
                        <p class="text-xs text-gray-500 mt-1">余計な機能を省いたシンプルな設計。ストレスなく素早くメモを書けます。</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 bg-white rounded-lg p-4 shadow-sm border border-amber-100">
                    <span class="text-2xl">✏️</span>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm">いつでも編集・削除</h4>
                        <p class="text-xs text-gray-500 mt-1">書いたメモはあとからいつでも修正・削除できます。</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 bg-white rounded-lg p-4 shadow-sm border border-amber-100">
                    <span class="text-2xl">📋</span>
                    <div>
                        <h4 class="font-semibold text-gray-800 text-sm">一覧でまとめて管理</h4>
                        <p class="text-xs text-gray-500 mt-1">書いたメモはタイトルと日付付きで一覧表示。サッと目的のメモを見つけられます。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- お知らせ --}}
    <section class="py-12 px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-bold text-amber-900 mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                お知らせ
            </h2>
            <div class="space-y-3">

                <div class="bg-white border border-amber-200 rounded-lg px-5 py-4 flex items-start gap-4 shadow-sm">
                    <span class="shrink-0 bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full mt-0.5">新機能</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">メモのデザインをリニューアルしました</p>
                        <p class="text-xs text-gray-400 mt-0.5">2026年6月1日</p>
                    </div>
                </div>

                <div class="bg-white border border-amber-200 rounded-lg px-5 py-4 flex items-start gap-4 shadow-sm">
                    <span class="shrink-0 bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full mt-0.5">リリース</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">メモ帳アプリをリリースしました</p>
                        <p class="text-xs text-gray-400 mt-0.5">2026年5月26日</p>
                    </div>
                </div>

                <div class="bg-white border border-amber-200 rounded-lg px-5 py-4 flex items-start gap-4 shadow-sm">
                    <span class="shrink-0 bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full mt-0.5">お知らせ</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">パスワードのリセット機能が使えるようになりました</p>
                        <p class="text-xs text-gray-400 mt-0.5">2026年5月26日</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- フッター --}}
    <footer class="mt-auto bg-amber-900 text-amber-200 text-center text-xs py-6">
        &copy; 2026 メモ帳アプリ — GitHub Actions サンプル
    </footer>

</body>
</html>
