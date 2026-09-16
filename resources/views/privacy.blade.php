<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'VocalPay') }} - Privacy Policy</title>
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
                <h1 class="font-serif-display text-4xl sm:text-5xl text-text mb-4">Privacy Policy</h1>
                <p class="text-text/50">Last updated: {{ date('F d, Y') }}</p>
            </div>
        </section>

        {{-- Content --}}
        <section class="pb-20 px-5 sm:px-8 lg:px-12">
            <div class="max-w-3xl mx-auto prose prose-text max-w-none">
                <div class="space-y-10 text-text/70 leading-relaxed">

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">1. Introduction</h2>
                        <p>VocalPay ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform and services. By using VocalPay, you consent to the practices described in this policy.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">2. Information We Collect</h2>
                        <p>We collect information in the following categories:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Account information:</strong> Name, email address, phone number, and bank account details you provide during registration.</li>
                            <li><strong>Task submissions:</strong> Voice recordings, text evaluations, labelling data, and other content you submit through the Platform.</li>
                            <li><strong>Device information:</strong> Device type, operating system, browser type, and IP address collected automatically during use.</li>
                            <li><strong>Usage data:</strong> Pages visited, tasks completed, time spent, and interaction patterns within the Platform.</li>
                            <li><strong>Communication data:</strong> Messages you send to our support team or other users through the Platform.</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">3. How We Use Your Information</h2>
                        <p>We use collected information to:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Provide, operate, and maintain the VocalPay platform</li>
                            <li>Process tasks, track contributions, and manage payments</li>
                            <li>Train and improve AI models using anonymised and aggregated data</li>
                            <li>Communicate with you about account activity, updates, and support</li>
                            <li>Detect and prevent fraud, abuse, and security issues</li>
                            <li>Comply with legal obligations and enforce our terms</li>
                            <li>Improve user experience through analytics and research</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">4. AI Training Data</h2>
                        <p>Your task submissions may be used to train and improve artificial intelligence models. We take the following steps to protect your privacy in this process:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Voice recordings are processed to remove personally identifying information where technically feasible</li>
                            <li>Data is aggregated and anonymised before use in model training</li>
                            <li>We do not sell raw, identifiable data to third parties</li>
                            <li>You retain ownership of your original contributions</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">5. Data Sharing</h2>
                        <p>We may share your information with:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Service providers:</strong> Third-party companies that assist with payment processing, cloud hosting, and analytics, under strict data protection agreements.</li>
                            <li><strong>Legal authorities:</strong> When required by law, court order, or governmental regulation.</li>
                            <li><strong>Business partners:</strong> Anonymised, aggregated data that cannot identify you individually may be shared for research purposes.</li>
                        </ul>
                        <p class="mt-2">We do not sell your personal information to advertisers or data brokers.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">6. Data Security</h2>
                        <p>We implement industry-standard security measures to protect your data, including encryption in transit (TLS/SSL), encryption at rest, access controls, and regular security audits. However, no method of transmission or storage is 100% secure, and we cannot guarantee absolute security.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">7. Data Retention</h2>
                        <p>We retain your personal information for as long as your account is active or as needed to provide services. Account data is retained for up to 24 months after account closure for legal and operational purposes. Task submission data may be retained in anonymised form for AI research indefinitely.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">8. Your Rights</h2>
                        <p>You have the right to:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Access and review your personal information</li>
                            <li>Correct inaccurate or incomplete data</li>
                            <li>Request deletion of your account and personal data</li>
                            <li>Object to or restrict certain processing of your data</li>
                            <li>Export your data in a portable format</li>
                            <li>Withdraw consent for data processing at any time</li>
                        </ul>
                        <p class="mt-2">To exercise these rights, contact us at <a href="mailto:privacy@vocalpay.co" class="text-primary hover:text-primary/80">privacy@vocalpay.co</a>.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">9. Cookies and Tracking</h2>
                        <p>VocalPay uses essential cookies to maintain your session and preferences. We do not use third-party advertising cookies or cross-site tracking. Analytics data is collected anonymously to improve platform performance.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">10. Children's Privacy</h2>
                        <p>VocalPay is not intended for use by individuals under 18 years of age. We do not knowingly collect personal information from children. If you believe a child has provided us with personal data, please contact us immediately.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">11. Changes to This Policy</h2>
                        <p>We may update this Privacy Policy from time to time. Material changes will be communicated via email or in-app notification. The "Last updated" date at the top indicates when the policy was last revised.</p>
                    </div>

                    <div>
                        <h2 class="font-serif-display text-2xl text-text mb-3">12. Contact Us</h2>
                        <p>For questions about this Privacy Policy or to exercise your data rights, contact us at:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Email: <a href="mailto:privacy@vocalpay.co" class="text-primary hover:text-primary/80">privacy@vocalpay.co</a></li>
                            <li>Address: VocalPay Technologies, Lagos, Nigeria</li>
                            <li>Contact page: <a href="{{ route('contact') }}" class="text-primary hover:text-primary/80">vocalpay.co/contact</a></li>
                        </ul>
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
