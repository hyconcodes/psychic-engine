<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'VocalPay') }} - Contact Us</title>
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <style>
            .font-serif-display { font-family: 'DM Serif Display', Georgia, serif; }
        </style>
    </head>
    <body class="bg-white text-text font-sans antialiased" x-data="{ sent: @js(session('status') === 'sent') }">

        {{-- Navigation --}}
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100/80">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex items-center justify-between h-16">
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="/images/logo-icon.svg" alt="VocalPay" class="w-8 h-8">
                        <span class="font-serif-display text-xl text-text">VocalPay</span>
                    </a>
                    <div class="flex items-center gap-3">
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

        {{-- Hero --}}
        <section class="relative py-16 sm:py-24 px-5 sm:px-8 lg:px-12 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-orange-100/30 pointer-events-none"></div>
            <div class="max-w-7xl mx-auto relative">
                <div class="max-w-2xl">
                    <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Get in touch</p>
                    <h1 class="font-serif-display text-4xl sm:text-5xl lg:text-6xl text-text mb-4 leading-tight">We'd love to<br>hear from you.</h1>
                    <p class="text-lg text-text/50 leading-relaxed">Have a question, need help, or want to partner with us? Our team is ready to respond. We typically reply within 24 hours.</p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="pb-20 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-5 gap-12 lg:gap-16">

                    {{-- Left: Contact Options --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="group">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-primary/15 transition-colors">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-serif-display text-xl text-text mb-1">Email us</h3>
                                    <p class="text-sm text-text/45 mb-2">For general enquiries, support requests, or partnership discussions.</p>
                                    <a href="mailto:support@vocalpay.co" class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">support@vocalpay.co</a>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="group">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-primary/15 transition-colors">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-serif-display text-xl text-text mb-1">Live support</h3>
                                    <p class="text-sm text-text/45 mb-2">Chat with our support team for immediate assistance with your account or tasks.</p>
                                    <p class="text-sm font-medium text-primary">Available Monday to Friday, 9am to 6pm WAT</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="group">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-primary/15 transition-colors">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-serif-display text-xl text-text mb-1">Quick answers</h3>
                                    <p class="text-sm text-text/45 mb-2">Find instant answers to common questions about tasks, payments, and your account.</p>
                                    <a href="{{ route('home') }}#faq" class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">Browse FAQ &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Contact Form --}}
                    <div class="lg:col-span-3">
                        <div class="bg-gray-50/60 rounded-3xl p-8 sm:p-10">
                            <h2 class="font-serif-display text-2xl text-text mb-1">Send us a message</h2>
                            <p class="text-sm text-text/45 mb-8">Fill out the form below and we'll get back to you shortly.</p>

                            {{-- Success State --}}
                            <div x-show="sent" x-transition class="text-center py-12">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-serif-display text-xl text-text mb-2">Message sent</h3>
                                <p class="text-sm text-text/50">Thanks for reaching out. We'll respond within 24 hours.</p>
                            </div>

                            {{-- Form --}}
                            <form x-show="!sent" x-transition class="space-y-5" method="POST" action="{{ route('contact.store') }}">
                                @csrf

                                @if ($errors->any())
                                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div>
                                        <label for="contact-name" class="block text-sm font-medium text-text mb-1.5">Your name</label>
                                        <input
                                            id="contact-name"
                                            name="name"
                                            type="text"
                                            required
                                            value="{{ old('name') }}"
                                            placeholder="Alex Johnson"
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                                        >
                                    </div>
                                    <div>
                                        <label for="contact-email" class="block text-sm font-medium text-text mb-1.5">Email address</label>
                                        <input
                                            id="contact-email"
                                            name="email"
                                            type="email"
                                            required
                                            value="{{ old('email') }}"
                                            placeholder="you@example.com"
                                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label for="contact-subject" class="block text-sm font-medium text-text mb-1.5">Subject</label>
                                    <select
                                        id="contact-subject"
                                        name="subject"
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors appearance-none"
                                    >
                                        <option value="general" {{ old('subject') === 'general' ? 'selected' : '' }}>General enquiry</option>
                                        <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>Account support</option>
                                        <option value="payment" {{ old('subject') === 'payment' ? 'selected' : '' }}>Payment issue</option>
                                        <option value="partnership" {{ old('subject') === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option value="feedback" {{ old('subject') === 'feedback' ? 'selected' : '' }}>Feedback</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="contact-message" class="block text-sm font-medium text-text mb-1.5">Message</label>
                                    <textarea
                                        id="contact-message"
                                        name="message"
                                        rows="5"
                                        required
                                        placeholder="Tell us how we can help..."
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors resize-none"
                                    >{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3.5 rounded-full text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                        Send Message
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 py-8 px-5 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <img src="/images/logo-icon.svg" alt="VocalPay" class="w-6 h-6">
                    <span class="font-serif-display text-sm text-text">VocalPay</span>
                </div>
                <div class="flex items-center gap-6 text-xs text-text/40">
                    <a href="{{ route('terms') }}" class="hover:text-text transition-colors">Terms</a>
                    <a href="{{ route('privacy') }}" class="hover:text-text transition-colors">Privacy</a>
                    <a href="{{ route('contact') }}" class="hover:text-text transition-colors">Contact</a>
                </div>
                <p class="text-xs text-text/30">&copy; {{ date('Y') }} VocalPay Technologies</p>
            </div>
        </footer>
    </body>
</html>
