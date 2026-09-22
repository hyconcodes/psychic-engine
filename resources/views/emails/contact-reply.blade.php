<x-mail::message>
# Hi {{ $userName }}

Thank you for reaching out to us. Here is our reply to your message regarding **"{{ $contactSubject }}"**:

{!! nl2br(e($replyMessage)) !!}

If you have any further questions, feel free to reply to this email or visit our support page.

Best regards,<br>
**VocalPay Support Team**
</x-mail::message>
