@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    @if (Route::has('posts.index'))
                        <a href="{{ route('posts.index') }}" class="ml-4 text-sm text-gray-700 underline">View Posts</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
