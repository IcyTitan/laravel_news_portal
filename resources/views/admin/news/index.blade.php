@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"/>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Управление новостями</div>
                    <div class="card-body">
                        <table class="table table-bordered" id="news-table">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Имя</th>
                                <th>Категория</th>
                                <th>Краткое описание</th>
                                <th>Описание</th>
                                <th>Дата создания</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
