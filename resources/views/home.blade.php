@extends('layouts.app')

@section('content')
        <div class="container">
            @if (session()->has('verified'))
                @if (session('verified') === true)
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        Your email was verified. Thank you!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif

            <div class="text-center">
                <h1>Upload and share your images.</h1>
            </div>
        </div>
@endsection
