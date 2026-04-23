<x-mail::message>
# Hello!

Your verification code for **Homiq** is:

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

This code will expire in 10 minutes. If you did not request this code, please ignore this email.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
