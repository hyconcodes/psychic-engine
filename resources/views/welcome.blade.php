<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-init="darkMode = localStorage.getItem('darkMode') === 'true'; if(darkMode) document.documentElement.classList.add('dark'); $watch('darkMode', val => { localStorage.setItem('darkMode', val); document.documentElement.classList.toggle('dark', val); })" x-data="{ darkMode: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'VocalPay') }} - Turn your voice into better AI</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <style>
            .font-serif-display { font-family: 'DM Serif Display', Georgia, serif; }
            @keyframes counter { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            .counter-animate { animation: counter 0.6s ease-out forwards; }
            @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
            .float-badge { animation: float 3s ease-in-out infinite; }
            .float-badge-delay { animation: float 3s ease-in-out 1.5s infinite; }
        </style>
    </head>
    <body class="bg-white dark:bg-neutral-950 text-text font-sans antialiased overflow-x-hidden">

        {{-- Navigation --}}
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-neutral-950/80 backdrop-blur-md border-b border-gray-100/80 dark:border-neutral-800/80">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex items-center justify-between h-16">
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="/images/logo-icon.svg" alt="VocalPay" class="w-8 h-8">
                        <span class="font-serif-display text-xl text-text">VocalPay</span>
                    </a>
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#ways" class="text-[13px] font-medium text-text/50 hover:text-text transition-colors">Ways to Earn</a>
                        <a href="#calculator" class="text-[13px] font-medium text-text/50 hover:text-text transition-colors">Earnings</a>
                        <a href="#how" class="text-[13px] font-medium text-text/50 hover:text-text transition-colors">How It Works</a>
                        <a href="#faq" class="text-[13px] font-medium text-text/50 hover:text-text transition-colors">FAQ</a>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Dark mode toggle --}}
                        <button @click="darkMode = !darkMode" class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 dark:border-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-800 transition-colors">
                            <template x-if="!darkMode">
                                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                            </template>
                            <template x-if="darkMode">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                            </template>
                        </button>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-[13px] font-medium text-text/60 hover:text-text transition-colors hidden sm:block">Sign In</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-[13px] font-semibold bg-primary hover:bg-primary/90 text-white px-5 py-2 rounded-full transition-colors">Start Earning</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero: Editorial Split --}}
        <section class="pt-24 pb-16 sm:pt-32 sm:pb-24 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-6 items-center">
                    {{-- Left: Text --}}
                    <div class="lg:col-span-7 xl:col-span-6">
                        <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-5">Built for Africa. Train AI. Earn.</p>
                        <h1 class="font-serif-display text-[2.75rem] sm:text-[3.5rem] lg:text-[4rem] leading-[1.08] text-text mb-6">
                            Your voice<br>has value.
                        </h1>
                        <p class="text-lg sm:text-xl text-text/55 leading-relaxed max-w-lg mb-8">
                            Record short voice samples, evaluate AI outputs, and complete training tasks. Every contribution earns you real money, paid directly to your African bank account.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 mb-10">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-semibold px-7 py-3.5 rounded-full text-sm transition-colors">
                                    Start Earning Today <span class="text-base">&rarr;</span>
                                </a>
                            @endif
                            <a href="#ways" class="inline-flex items-center justify-center gap-2 border-2 border-text/15 hover:border-text/30 text-text font-semibold px-7 py-3.5 rounded-full text-sm transition-colors">
                                See Ways to Earn
                            </a>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[13px] text-text/45">
                            <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> 12,000+ contributors</span>
                            <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> 8 languages</span>
                            <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> 4.9 rating</span>
                        </div>
                    </div>
                    {{-- Right: Phone Illustration --}}
                    <div class="lg:col-span-5 xl:col-span-6 flex justify-center lg:justify-end relative">
                        <div class="relative">
                            <img src="/images/phone-waveform.svg" alt="VocalPay recording interface" class="w-64 sm:w-72 lg:w-80 relative z-10">
                            <div class="absolute -top-4 -right-6 float-badge z-20">
                                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg shadow-primary/10 border border-gray-100 dark:border-neutral-700 px-4 py-2.5 flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-50 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-text/40">Task earned</p>
                                        <p class="text-sm font-bold text-green-600">+&#8358;850</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -bottom-2 -left-8 float-badge-delay z-20">
                                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg shadow-primary/10 border border-gray-100 dark:border-neutral-700 px-4 py-2.5 flex items-center gap-2">
                                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-text/40">Balance</p>
                                        <p class="text-sm font-bold text-text">&#8358;12,400</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-1/2 -left-16 w-48 h-48 bg-primary/8 rounded-full blur-3xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Abstract Brand Visual --}}
        <section class="relative py-16 sm:py-20 overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[500px] h-[500px] rounded-full border border-primary/8 absolute"></div>
                <div class="w-[380px] h-[380px] rounded-full border border-primary/10 absolute"></div>
                <div class="w-[260px] h-[260px] rounded-full border border-primary/12 absolute"></div>
                <div class="w-[140px] h-[140px] rounded-full border border-primary/15 absolute"></div>
            </div>
            {{-- Wave lines --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 1200 300" preserveAspectRatio="none">
                <path d="M0,150 Q300,100 600,150 T1200,150" fill="none" stroke="#FF5722" stroke-width="0.8" stroke-opacity="0.08"/>
                <path d="M0,130 Q300,180 600,130 T1200,130" fill="none" stroke="#FF5722" stroke-width="0.6" stroke-opacity="0.06"/>
                <path d="M0,170 Q300,120 600,170 T1200,170" fill="none" stroke="#FFA726" stroke-width="0.5" stroke-opacity="0.07"/>
            </svg>
            {{-- Scattered dots --}}
            <div class="absolute top-8 left-[15%] w-2 h-2 rounded-full bg-primary/15"></div>
            <div class="absolute top-12 right-[20%] w-1.5 h-1.5 rounded-full bg-primary/10"></div>
            <div class="absolute bottom-10 left-[25%] w-2.5 h-2.5 rounded-full bg-primary/12"></div>
            <div class="absolute top-1/2 right-[12%] w-2 h-2 rounded-full bg-primary/8"></div>
            <div class="absolute bottom-8 right-[30%] w-1.5 h-1.5 rounded-full bg-primary/10"></div>
            <div class="absolute top-20 left-[40%] w-1 h-1 rounded-full bg-primary/20"></div>
            <div class="absolute bottom-16 left-[60%] w-1.5 h-1.5 rounded-full bg-primary/15"></div>
            {{-- Center logo --}}
            <div class="relative z-10 flex items-center justify-center">
                <img src="/images/logo-icon.svg" alt="VocalPay" class="w-20 h-20 sm:w-24 sm:h-24 drop-shadow-lg">
            </div>
            {{-- Floating earning badges --}}
            <div class="absolute top-6 left-[8%] sm:left-[18%] float-badge z-10">
                <div class="bg-white/90 dark:bg-neutral-800/90 backdrop-blur-sm rounded-full shadow-md px-3 py-1.5 text-xs font-bold text-green-600">+&#8358;850</div>
            </div>
            <div class="absolute bottom-8 right-[10%] sm:right-[20%] float-badge-delay z-10">
                <div class="bg-white/90 dark:bg-neutral-800/90 backdrop-blur-sm rounded-full shadow-md px-3 py-1.5 text-xs font-bold text-primary">+&#8358;1,200</div>
            </div>
            <div class="absolute top-1/3 right-[6%] sm:right-[15%] float-badge z-10" style="animation-delay: 0.8s">
                <div class="bg-white/90 dark:bg-neutral-800/90 backdrop-blur-sm rounded-full shadow-md px-3 py-1.5 text-xs font-bold text-green-600">+&#8358;650</div>
            </div>
            <div class="absolute bottom-1/3 left-[5%] sm:left-[12%] float-badge-delay z-10" style="animation-delay: 2.2s">
                <div class="bg-white/90 dark:bg-neutral-800/90 backdrop-blur-sm rounded-full shadow-md px-3 py-1.5 text-xs font-bold text-primary">+&#8358;2,000</div>
            </div>
        </section>

        {{-- Stats Strip --}}
        <section class="bg-text dark:bg-neutral-900 py-10 px-5 sm:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <p class="font-serif-display text-3xl sm:text-4xl text-white mb-1">&#8358;24M<span class="text-primary">+</span></p>
                        <p class="text-xs text-white/40 uppercase tracking-wider">Total Paid Out</p>
                    </div>
                    <div class="text-center">
                        <p class="font-serif-display text-3xl sm:text-4xl text-white mb-1">12K<span class="text-primary">+</span></p>
                        <p class="text-xs text-white/40 uppercase tracking-wider">Active Contributors</p>
                    </div>
                    <div class="text-center">
                        <p class="font-serif-display text-3xl sm:text-4xl text-white mb-1">850K<span class="text-primary">+</span></p>
                        <p class="text-xs text-white/40 uppercase tracking-wider">Tasks Completed</p>
                    </div>
                    <div class="text-center">
                        <p class="font-serif-display text-3xl sm:text-4xl text-white mb-1">8</p>
                        <p class="text-xs text-white/40 uppercase tracking-wider">Languages</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Ways to Earn: Narrative Blocks --}}
        <section id="ways" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-2xl mb-16">
                    <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Ways to earn</p>
                    <h2 class="font-serif-display text-3xl sm:text-4xl lg:text-[2.75rem] text-text leading-tight">Choose tasks that fit your life. Every one pays.</h2>
                </div>

                {{-- Voice Data --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center mb-20">
                    <div class="order-2 lg:order-1">
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-8 sm:p-10 relative overflow-hidden">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-5">
                                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center"><span class="text-primary text-xs font-bold">&#9654;</span></div>
                                    <div class="flex-1 h-2 bg-gray-100 dark:bg-neutral-700 rounded-full overflow-hidden"><div class="h-full bg-primary/30 rounded-full" style="width: 65%"></div></div>
                                    <span class="text-[11px] text-text/40">1:24</span>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                    <div class="w-8 h-8 bg-green-50 dark:bg-green-900/30 rounded-lg flex items-center justify-center"><span class="text-green-500 text-xs font-bold">&#10003;</span></div>
                                    <div class="flex-1 h-2 bg-gray-100 dark:bg-neutral-700 rounded-full overflow-hidden"><div class="h-full bg-green-400 rounded-full" style="width: 100%"></div></div>
                                    <span class="text-[11px] text-text/40">Done</span>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 flex items-center gap-3 shadow-sm opacity-60">
                                    <div class="w-8 h-8 bg-gray-50 dark:bg-neutral-700 rounded-lg flex items-center justify-center"><span class="text-gray-400 text-xs font-bold">&#9202;</span></div>
                                    <div class="flex-1 text-[12px] text-text/40">Next: Igbo sample</div>
                                </div>
                            </div>
                            <p class="text-xs text-text/30 font-medium uppercase tracking-wider">Voice recording queue</p>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="inline-flex items-center gap-2 bg-primary/8 text-primary text-xs font-semibold px-3 py-1 rounded-full mb-4">&#8358;500 &ndash; &#8358;2,000 per task</div>
                        <h3 class="font-serif-display text-2xl sm:text-3xl text-text mb-3">Voice Data</h3>
                        <p class="text-text/55 leading-relaxed mb-5">Record yourself speaking naturally in English, Pidgin, or selected African languages. Short clips of 15 to 60 seconds, done from your phone, on your own time.</p>
                        <ul class="space-y-2.5 text-sm text-text/50">
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Work from anywhere with just your phone</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Tasks take 1 to 3 minutes each</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Payment lands in your bank account</li>
                        </ul>
                    </div>
                </div>

                {{-- AI Evaluation --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center mb-20">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-primary/8 text-primary text-xs font-semibold px-3 py-1 rounded-full mb-4">&#8358;300 &ndash; &#8358;1,500 per task</div>
                        <h3 class="font-serif-display text-2xl sm:text-3xl text-text mb-3">AI Evaluation</h3>
                        <p class="text-text/55 leading-relaxed mb-5">Read AI-generated responses and rate them for accuracy, naturalness, and cultural relevance. Your judgment helps models understand context that data alone cannot capture.</p>
                        <ul class="space-y-2.5 text-sm text-text/50">
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Compare two or three responses side by side</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> No special training needed</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> See rewards before you start</li>
                        </ul>
                    </div>
                    <div>
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-8 sm:p-10">
                            <div class="space-y-3">
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-neutral-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[11px] font-semibold text-text/60 uppercase tracking-wider">Response A</span>
                                        <span class="text-[11px] font-bold text-green-600 bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full">Selected</span>
                                    </div>
                                    <p class="text-sm text-text/70 leading-relaxed">"The market is very busy today. I need to buy tomatoes and onions for the soup."</p>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-neutral-700 opacity-50">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[11px] font-semibold text-text/60 uppercase tracking-wider">Response B</span>
                                        <span class="text-[11px] font-bold text-text/40 bg-gray-50 dark:bg-neutral-700 px-2 py-0.5 rounded-full">Not selected</span>
                                    </div>
                                    <p class="text-sm text-text/70 leading-relaxed">"The marketplace has much activity. I shall procure vegetables for preparation."</p>
                                </div>
                            </div>
                            <p class="text-xs text-text/30 font-medium uppercase tracking-wider mt-4">Evaluation interface</p>
                        </div>
                    </div>
                </div>

                {{-- Micro Tasks --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center mb-20">
                    <div class="order-2 lg:order-1">
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-8 sm:p-10">
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 shadow-sm text-center">
                                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                    </div>
                                    <p class="text-[11px] font-medium text-text/60">Classify</p>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 shadow-sm text-center">
                                    <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <p class="text-[11px] font-medium text-text/60">Validate</p>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 shadow-sm text-center">
                                    <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <p class="text-[11px] font-medium text-text/60">Label</p>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 shadow-sm text-center">
                                    <div class="w-10 h-10 bg-rose-50 dark:bg-rose-900/30 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zm7-2a1 1 0 01.967.744L14.146 15H16a1 1 0 110 2h-2a1 1 0 01-.967-.744L12 12.721l-1.033 3.535A1 1 0 0110 17H8a1 1 0 110-2h2a1 1 0 01.967.744L12 12.721l1.033-3.535A1 1 0 0114 8h2a1 1 0 110 2h-2l-1.033 3.535z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <p class="text-[11px] font-medium text-text/60">Rate</p>
                                </div>
                            </div>
                            <p class="text-xs text-text/30 font-medium uppercase tracking-wider">Task categories</p>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="inline-flex items-center gap-2 bg-primary/8 text-primary text-xs font-semibold px-3 py-1 rounded-full mb-4">&#8358;200 &ndash; &#8358;800 per task</div>
                        <h3 class="font-serif-display text-2xl sm:text-3xl text-text mb-3">Micro Tasks</h3>
                        <p class="text-text/55 leading-relaxed mb-5">Quick classification, validation, and data-labelling activities. Each task takes under a minute, and you can complete as many as you want in a session.</p>
                        <ul class="space-y-2.5 text-sm text-text/50">
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Finish most tasks in under 60 seconds</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Mix and match task types</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Earnings stack up quickly</li>
                        </ul>
                    </div>
                </div>

                {{-- Referrals --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-primary/8 text-primary text-xs font-semibold px-3 py-1 rounded-full mb-4">&#8358;1,000 per referral</div>
                        <h3 class="font-serif-display text-2xl sm:text-3xl text-text mb-3">Referrals</h3>
                        <p class="text-text/55 leading-relaxed mb-5">Invite friends and family to join VocalPay. When they sign up and complete their first qualifying task, you both earn a bonus. No limit on referrals.</p>
                        <ul class="space-y-2.5 text-sm text-text/50">
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Share your unique link anywhere</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> Both you and your friend earn</li>
                            <li class="flex items-start gap-2.5"><span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5"><span class="text-primary text-[10px] font-bold">&#10003;</span></span> No cap on how many you can invite</li>
                        </ul>
                    </div>
                    <div>
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-8 sm:p-10">
                            <div class="space-y-3">
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary text-sm font-bold">AB</div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-text">Amina B.</p>
                                        <p class="text-[11px] text-text/40">Joined 2 days ago</p>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+&#8358;1,000</span>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary text-sm font-bold">KO</div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-text">Kofi O.</p>
                                        <p class="text-[11px] text-text/40">Joined 5 days ago</p>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+&#8358;1,000</span>
                                </div>
                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm flex items-center gap-4 opacity-50">
                                    <div class="w-10 h-10 bg-gray-50 dark:bg-neutral-700 rounded-full flex items-center justify-center text-text/30 text-sm font-bold">NM</div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-text">Naledi M.</p>
                                        <p class="text-[11px] text-text/40">Pending first task</p>
                                    </div>
                                    <span class="text-sm font-bold text-text/30">&#8358;0</span>
                                </div>
                            </div>
                            <p class="text-xs text-text/30 font-medium uppercase tracking-wider mt-4">Referral tracker</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Earnings Calculator --}}
        <section id="calculator" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-12 bg-gray-50/60 dark:bg-neutral-900/60">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Earnings calculator</p>
                <h2 class="font-serif-display text-3xl sm:text-4xl text-text mb-4">See what you could earn</h2>
                <p class="text-text/50 mb-12 max-w-md mx-auto">Move the slider to estimate your monthly earnings based on your availability.</p>
                <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 p-8 sm:p-10" x-data="{ tasks: 10 }">
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-text/50">Tasks per week</span>
                            <span class="font-serif-display text-3xl text-primary" x-text="tasks"></span>
                        </div>
                        <input type="range" min="1" max="50" x-model="tasks" class="w-full h-2 bg-gray-100 dark:bg-neutral-700 rounded-full appearance-none cursor-pointer accent-primary">
                        <div class="flex justify-between text-[11px] text-text/30 mt-1">
                            <span>1</span>
                            <span>25</span>
                            <span>50</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 dark:bg-neutral-900 rounded-2xl p-5">
                            <p class="text-xs text-text/40 mb-1">Weekly estimate</p>
                            <p class="font-serif-display text-2xl text-text" x-text="'&#8358;' + (tasks * 650).toLocaleString()"></p>
                        </div>
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-2xl p-5">
                            <p class="text-xs text-primary/60 mb-1">Monthly estimate</p>
                            <p class="font-serif-display text-2xl text-primary" x-text="'&#8358;' + (tasks * 650 * 4).toLocaleString()"></p>
                        </div>
                    </div>
                    <p class="text-xs text-text/30">Based on an average of &#8358;650 per task. Actual earnings vary by task type and availability.</p>
                </div>
            </div>
        </section>

        {{-- How It Works: User Story --}}
        <section id="how" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">How it works</p>
                    <h2 class="font-serif-display text-3xl sm:text-4xl text-text mb-4">From signup to first payout in one week</h2>
                    <p class="text-text/50 max-w-lg mx-auto">Here is how one contributor went from curious to earning.</p>
                </div>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-neutral-800 rounded-3xl border border-gray-100 dark:border-neutral-700 p-7 relative overflow-hidden group hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-serif-display text-xl mb-5">1</div>
                        <p class="text-[11px] text-primary font-semibold uppercase tracking-wider mb-2">Monday</p>
                        <h4 class="font-semibold text-text mb-2">Create your account</h4>
                        <p class="text-sm text-text/50 leading-relaxed">Sign up in under a minute. Link your bank account for payouts. Choose the languages you speak.</p>
                        <div class="absolute bottom-0 right-0 w-24 h-24 bg-primary/5 dark:bg-primary/10 rounded-tl-3xl"></div>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 rounded-3xl border border-gray-100 dark:border-neutral-700 p-7 relative overflow-hidden group hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-serif-display text-xl mb-5">2</div>
                        <p class="text-[11px] text-primary font-semibold uppercase tracking-wider mb-2">Wednesday</p>
                        <h4 class="font-semibold text-text mb-2">Complete your first tasks</h4>
                        <p class="text-sm text-text/50 leading-relaxed">Start with voice recordings or quick evaluations. Each task shows its reward before you begin.</p>
                        <div class="absolute bottom-0 right-0 w-24 h-24 bg-primary/5 dark:bg-primary/10 rounded-tl-3xl"></div>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 rounded-3xl border border-gray-100 dark:border-neutral-700 p-7 relative overflow-hidden group hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-serif-display text-xl mb-5">3</div>
                        <p class="text-[11px] text-primary font-semibold uppercase tracking-wider mb-2">Friday</p>
                        <h4 class="font-semibold text-text mb-2">Get paid</h4>
                        <p class="text-sm text-text/50 leading-relaxed">Your earnings appear in your wallet instantly. Withdraw to your bank account within 1 to 3 days.</p>
                        <div class="absolute bottom-0 right-0 w-24 h-24 bg-primary/5 dark:bg-primary/10 rounded-tl-3xl"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Trusted Across Africa --}}
        <section class="py-20 sm:py-28 px-5 sm:px-8 lg:px-12 bg-gray-50/60 dark:bg-neutral-900/60">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div>
                        <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Trusted across Africa</p>
                        <h2 class="font-serif-display text-3xl sm:text-4xl text-text mb-5 leading-tight">Contributors from 12 countries earning in 8 languages</h2>
                        <p class="text-text/50 leading-relaxed mb-8">VocalPay is built for the diversity of African voices. Whether you speak Yoruba in Lagos, Swahili in Nairobi, or Amharic in Addis Ababa, there is a place for you.</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white dark:bg-neutral-800 rounded-xl shadow-sm flex items-center justify-center text-lg">&#127475;&#127468;</div>
                                <div>
                                    <p class="text-sm font-medium text-text">Nigeria</p>
                                    <p class="text-[11px] text-text/40">4,200+ contributors</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white dark:bg-neutral-800 rounded-xl shadow-sm flex items-center justify-center text-lg">&#127472;&#127466;</div>
                                <div>
                                    <p class="text-sm font-medium text-text">Kenya</p>
                                    <p class="text-[11px] text-text/40">2,800+ contributors</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white dark:bg-neutral-800 rounded-xl shadow-sm flex items-center justify-center text-lg">&#127468;&#127469;</div>
                                <div>
                                    <p class="text-sm font-medium text-text">Ghana</p>
                                    <p class="text-[11px] text-text/40">1,900+ contributors</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white dark:bg-neutral-800 rounded-xl shadow-sm flex items-center justify-center text-lg">&#127466;&#127464;</div>
                                <div>
                                    <p class="text-sm font-medium text-text">Ethiopia</p>
                                    <p class="text-[11px] text-text/40">1,400+ contributors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <img src="/images/africa-map.svg" alt="VocalPay contributors across Africa" class="w-full max-w-md">
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQ --}}
        <section id="faq" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-12">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-14">
                    <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Questions</p>
                    <h2 class="font-serif-display text-3xl sm:text-4xl text-text">Frequently asked</h2>
                </div>
                <div class="space-y-3" x-data="{ open: null }">
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-2xl overflow-hidden transition-all" :class="open === 1 && 'border-primary/20 shadow-sm'">
                        <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                            <span class="font-semibold text-text pr-4">What is VocalPay?</span>
                            <span class="w-7 h-7 rounded-full border border-gray-200 dark:border-neutral-600 flex items-center justify-center shrink-0 transition-transform" :class="open === 1 && 'rotate-45 border-primary/30'"><span class="text-text/40 text-lg leading-none" :class="open === 1 && 'text-primary'">+</span></span>
                        </button>
                        <div x-show="open === 1" x-collapse class="px-6 pb-5 text-sm text-text/55 leading-relaxed">VocalPay is an AI training contribution platform where people complete useful data and evaluation activities and receive rewards for eligible work.</div>
                    </div>
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-2xl overflow-hidden transition-all" :class="open === 2 && 'border-primary/20 shadow-sm'">
                        <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                            <span class="font-semibold text-text pr-4">How do I get paid?</span>
                            <span class="w-7 h-7 rounded-full border border-gray-200 dark:border-neutral-600 flex items-center justify-center shrink-0 transition-transform" :class="open === 2 && 'rotate-45 border-primary/30'"><span class="text-text/40 text-lg leading-none" :class="open === 2 && 'text-primary'">+</span></span>
                        </button>
                        <div x-show="open === 2" x-collapse class="px-6 pb-5 text-sm text-text/55 leading-relaxed">Once your balance meets the minimum threshold, you can request a payout directly to your linked African bank account. Processing typically takes 1 to 3 business days.</div>
                    </div>
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-2xl overflow-hidden transition-all" :class="open === 3 && 'border-primary/20 shadow-sm'">
                        <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                            <span class="font-semibold text-text pr-4">What languages are supported?</span>
                            <span class="w-7 h-7 rounded-full border border-gray-200 dark:border-neutral-600 flex items-center justify-center shrink-0 transition-transform" :class="open === 3 && 'rotate-45 border-primary/30'"><span class="text-text/40 text-lg leading-none" :class="open === 3 && 'text-primary'">+</span></span>
                        </button>
                        <div x-show="open === 3" x-collapse class="px-6 pb-5 text-sm text-text/55 leading-relaxed">We currently support English, Pidgin, Yoruba, Igbo, Hausa, Swahili, Amharic, and Twi, with more languages being added regularly.</div>
                    </div>
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-2xl overflow-hidden transition-all" :class="open === 4 && 'border-primary/20 shadow-sm'">
                        <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                            <span class="font-semibold text-text pr-4">Do I need special equipment?</span>
                            <span class="w-7 h-7 rounded-full border border-gray-200 dark:border-neutral-600 flex items-center justify-center shrink-0 transition-transform" :class="open === 4 && 'rotate-45 border-primary/30'"><span class="text-text/40 text-lg leading-none" :class="open === 4 && 'text-primary'">+</span></span>
                        </button>
                        <div x-show="open === 4" x-collapse class="px-6 pb-5 text-sm text-text/55 leading-relaxed">No special equipment is needed. A smartphone with a microphone is enough to complete most tasks on the platform.</div>
                    </div>
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-2xl overflow-hidden transition-all" :class="open === 5 && 'border-primary/20 shadow-sm'">
                        <button @click="open = open === 5 ? null : 5" class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                            <span class="font-semibold text-text pr-4">How do referrals work?</span>
                            <span class="w-7 h-7 rounded-full border border-gray-200 dark:border-neutral-600 flex items-center justify-center shrink-0 transition-transform" :class="open === 5 && 'rotate-45 border-primary/30'"><span class="text-text/40 text-lg leading-none" :class="open === 5 && 'text-primary'">+</span></span>
                        </button>
                        <div x-show="open === 5" x-collapse class="px-6 pb-5 text-sm text-text/55 leading-relaxed">Share your unique referral link with friends. When they sign up and complete their first qualifying task, you both earn a referral bonus.</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Final CTA --}}
        <section class="px-5 sm:px-8 lg:px-12 pb-20">
            <div class="max-w-5xl mx-auto">
                <div class="bg-gradient-to-br from-primary to-orange-600 rounded-[2rem] px-8 sm:px-14 py-14 sm:py-20 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 800 400" fill="none"><circle cx="100" cy="100" r="200" fill="white"/><circle cx="700" cy="300" r="150" fill="white"/></svg>
                    </div>
                    <div class="relative">
                        <h2 class="font-serif-display text-3xl sm:text-4xl lg:text-5xl text-white mb-4 leading-tight">Ready to turn your<br>voice into income?</h2>
                        <p class="text-white/70 mb-8 max-w-md mx-auto">Join 12,000+ contributors across Africa who are already earning.</p>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-primary font-semibold px-8 py-3.5 rounded-full text-sm hover:bg-gray-50 transition-colors">
                                Create Free Account <span>&rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 dark:border-neutral-800 py-12 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-8 mb-10">
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-2.5 mb-3">
                            <img src="/images/logo-icon.svg" alt="VocalPay" class="w-7 h-7">
                            <span class="font-serif-display text-lg text-text">VocalPay</span>
                        </div>
                        <p class="text-sm text-text/40 max-w-xs leading-relaxed">AI training that pays. Built for Africa.</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-text uppercase tracking-wider mb-3">Product</h4>
                        <ul class="space-y-2 text-sm text-text/45">
                            <li><a href="#ways" class="hover:text-text transition-colors">Ways to Earn</a></li>
                            <li><a href="#calculator" class="hover:text-text transition-colors">Earnings</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-text transition-colors">Get Started</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-text uppercase tracking-wider mb-3">Company</h4>
                        <ul class="space-y-2 text-sm text-text/45">
                            <li><a href="#how" class="hover:text-text transition-colors">How It Works</a></li>
                            <li><a href="#faq" class="hover:text-text transition-colors">FAQ</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-text transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-text uppercase tracking-wider mb-3">Legal</h4>
                        <ul class="space-y-2 text-sm text-text/45">
                            <li><a href="{{ route('terms') }}" class="hover:text-text transition-colors">Terms</a></li>
                            <li><a href="{{ route('privacy') }}" class="hover:text-text transition-colors">Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-100 dark:border-neutral-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-text/30">&copy; {{ date('Y') }} VocalPay Technologies. All rights reserved.</p>
                    <p class="text-xs text-text/30">Built for Africa. Powered by voices.</p>
                </div>
            </div>
        </footer>

        @if (Route::has('login'))
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        @endif
    </body>
</html>
