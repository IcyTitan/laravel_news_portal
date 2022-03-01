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
                        Личный кабинет пользователя.
                        Для того чтоб сделать пользователя администратором, нужно задать type = 1
                        После этого админ панель будет доступна по <a href="{{ route('admin.main') }}">этому</a> адресу
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
