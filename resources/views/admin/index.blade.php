@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Панель управления</div>

                    <div class="card-body">
                        <a class="dropdown-item" href="{{ route('admin.news') }}">{{ __('News') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
