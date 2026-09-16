<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'VocalPay') }} - Terms of Service</title>
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <style>.font-serif-display { font-family: 'DM Serif Display', Georgia, serif; }</style>
    </head>
    <body class="bg-white text-text font-sans antialiased">

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
        <section class="py-16 sm:py-24 px-5 sm:px-8 lg:px-12">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-primary text-sm font-semibold tracking-wide uppercase mb-3">Legal</p>
                <h1 class="font-serif-display text-4xl sm:text-5xl text-text mb-4">Terms of Service</h1>
                <p class="text-text/50">Last updated: {{ date('F d, Y') }}</p>
            </div>
        </section>

        {{-- Content --}}
        <section class="pb-20 px-5 sm:px-8 lg:px-12">
            <div class="max-w-3xl mx-auto prose prose-text max-w-none">
                <div class="space-y-10 text-text/70 leading-relaxed">

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">1. Acceptance of Terms</h2>
                        <p>By accessing or using VocalPay ("the Platform"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Platform. These terms apply to all users, including contributors, visitors, and account holders.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">2. Description of Service</h2>
                        <p>VocalPay is an AI training contribution platform that connects individuals with data collection, evaluation, and labelling tasks. Contributors complete tasks such as voice recordings, AI response evaluations, and micro-labelling activities and receive monetary rewards for eligible work.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">3. Eligibility</h2>
                        <p>To use VocalPay, you must:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Be at least 18 years of age, or the age of majority in your jurisdiction</li>
                            <li>Have the legal capacity to enter into a binding agreement</li>
                            <li>Reside in a country where VocalPay operates</li>
                            <li>Provide accurate and complete registration information</li>
                            <li>Maintain the security of your account credentials</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">4. Account Registration</h2>
                        <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to immediately notify VocalPay of any unauthorised use of your account. VocalPay reserves the right to suspend or terminate accounts that violate these terms.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">5. How Earning Works</h2>
                        <p>On VocalPay, you generate income by taking part in real activities such as voice readings, word-based tasks, quick evaluations, and sponsored content. Each completed activity carries a reward, which is reflected in your in-app wallet once it passes our review. We run quality and authenticity checks on submitted work before finalising any credits, which helps keep the platform fair for everyone.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">6. Plans and Activation</h2>
                        <p>Certain features and higher reward tiers on VocalPay are tied to an active plan. You can activate a plan using funds available in your wallet. Plan details, including pricing, reward rates, and usage limits, are listed on the Plans page and may be updated from time to time as the platform evolves.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">7. Withdrawals</h2>
                        <p>You can request a withdrawal once your balance reaches the applicable minimum threshold. Some accounts may need to complete identity verification before withdrawals are enabled. Different balance types, such as earnings from tasks and earnings from referrals, may carry separate minimums and processing windows. We process all valid withdrawal requests as quickly as possible, though exact timings may vary depending on your bank.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">8. Referral Programme</h2>
                        <p>VocalPay offers a referral programme where existing contributors can invite new users. Referral bonuses are credited when the referred user signs up and completes their first qualifying task. VocalPay reserves the right to modify referral terms, bonus amounts, or discontinue the programme at any time.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">9. Intellectual Property</h2>
                        <p>By submitting tasks on VocalPay, you grant VocalPay a non-exclusive, worldwide, royalty-free licence to use, modify, and distribute your contributions solely for the purpose of training and improving AI models. You retain ownership of your original work. VocalPay's trademarks, logos, and brand materials may not be used without prior written consent.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">10. Prohibited Conduct</h2>
                        <p>You agree not to:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Submit fraudulent, misleading, or low-quality work</li>
                            <li>Create multiple accounts to exploit rewards or referrals</li>
                            <li>Use automated tools or bots to complete tasks</li>
                            <li>Interfere with the Platform's operation or security</li>
                            <li>Harvest or collect user information without consent</li>
                            <li>Violate any applicable laws or regulations</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">11. Termination</h2>
                        <p>VocalPay may suspend or terminate your account at any time for violation of these terms, fraudulent activity, or conduct that harms the Platform or its users. Upon termination, your right to use the Platform ceases immediately. Outstanding eligible earnings will be processed in accordance with our payment terms.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">12. Limitation of Liability</h2>
                        <p>VocalPay is provided "as is" without warranties of any kind. To the maximum extent permitted by law, VocalPay shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of the Platform. Our total liability shall not exceed the amount of rewards earned by you in the twelve months preceding the claim.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">13. Modifications</h2>
                        <p>VocalPay reserves the right to modify these Terms of Service at any time. Material changes will be communicated via email or in-app notification. Continued use of the Platform after changes take effect constitutes acceptance of the modified terms.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">14. Governing Law</h2>
                        <p>These Terms of Service are governed by and construed in accordance with the laws of the Federal Republic of Nigeria. Any disputes shall be resolved through binding arbitration in Lagos, Nigeria, unless otherwise agreed by the parties.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">15. Contact</h2>
                        <p>For questions about these Terms of Service, please contact us at <a href="mailto:legal@vocalpay.co" class="text-primary hover:text-primary/80">legal@vocalpay.co</a> or visit our <a href="{{ route('contact') }}" class="text-primary hover:text-primary/80">contact page</a>.</p>
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
