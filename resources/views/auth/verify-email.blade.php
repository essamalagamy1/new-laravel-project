@extends('components.layouts.website.app')

@section('title', __('lang.verify_email'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">{{ __('lang.verify_email') }}</h2>
                    <p class="text-muted text-center mb-4">
                        {{ __('lang.verify_email_instruction') }}
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            {{ __('lang.verification_link_sent') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('lang.resend_verification_email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                {{ __('lang.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
