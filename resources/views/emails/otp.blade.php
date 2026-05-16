@extends('emails.template')

@section('greeting', 'Verification Protocol')

@section('content')
Your identity verification is required to proceed with **Homiq**. Please use the following authorization code to secure your session:

<div style="background-color: #faf9f6; border-radius: 24px; padding: 40px; text-align: center; margin: 30px 0; border: 1px solid rgba(0,0,0,0.03);">
    <span style="font-size: 42px; font-weight: 700; color: #171717; letter-spacing: 12px; font-family: 'Poppins', sans-serif;">{{ $otp }}</span>
</div>

This code will expire in **10 minutes**. For your security, please do not share this code with anyone. If you did not initiate this request, you may safely ignore this dispatch.
@endsection

