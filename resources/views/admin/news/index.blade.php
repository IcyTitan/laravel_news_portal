@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table table-bordered" id="news-table">
            <thead>
            <tr>
                <th>id</th>
                <th>Имя</th>
                <th>Категория</th>
                <th>Краткое описание</th>
                <th>Описание</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="container">
        <form id="news-form">
            <input type="text" name="company-id" value="" hidden>
            <div class="form-group">
                <label>Имя:</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group d-flex flex-column">
                <label>Категория:</label>
                <select size="4" id="select-category" name="category">
                    <option disabled>Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Текст анонса:</label>
                <textarea rows="5" cols="45" name="short-description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Текст детального описания:</label>
                <textarea rows="5" cols="45" name="description"  class="form-control"></textarea>
            </div>

            <div class="form-group mt-4">
                <button class="btn btn-success btn-update">Применить</button>
                <button class="btn btn-success btn-save">Сохранить как новую запись</button>
            </div>
        </form>
    </div>

    @once
        @push('scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"/>
            <script type="application/javascript">
                $(function () {
                    let newsTable = $('#news-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{route('admin.news.table')}}',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'name', name: 'Имя'},
                            {data: 'category', name: 'Категория'},
                            {data: 'short_description', name: 'Краткое описание'},
                            {data: 'description', name: 'Описание'},
                            {data: 'created_at', name: 'Дата создания'},
                            {
                                data: 'action',
                                name: 'action',
                            },
                        ]
                    });
                    $(document).on('click', '.edit-button', function (e) {
                        let rowId = $(this).attr('id-attr');
                        if (!rowId) return;
                        $.ajax({
                            type: "POST",
                            dataType: 'JSON',
                            url: '{{route('admin.news.edit')}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: rowId,
                            },
                            success: function (response) {
                                $("input[name=name]").val(response.news['name']);
                                $("textarea[name=short-description]").val(response.news['short_description']);
                                $("textarea[name=description]").val(response.news['description']);
                                $('#select-category').val(response.news['category_id']);
                                $('.btn-update').attr('id-attr',rowId);
                            }
                        });
                    });
                    $(document).on('click', '.delete-button', function (e) {
                        let rowId = $(this).attr('id-attr');
                        if (!rowId) return;

                        $.ajax({
                            type: "POST",
                            dataType: 'JSON',
                            url: '{{route('admin.news.delete')}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: rowId,
                            },
                            success: function () {
                                newsTable.draw();
                            }
                        });
                    });
                    $(document).on('click', '.btn-update', function (e) {
                        e.preventDefault();
                        let rowId = $(this).attr('id-attr');
                        if (!rowId){
                            alert('Не выбрана новость для редактирования');
                            return;
                        }
                        var Newsform = document.querySelector("#news-form");
                        var NewsformData = new FormData(Newsform);
                        NewsformData.append('id', rowId);
                        $.ajax({
                            type: "POST",
                            dataType: 'JSON',
                            url: '{{route('admin.news.update')}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: NewsformData,
                            success: function () {
                                newsTable.draw();
                            }
                        });
                    });
                    $(document).on('click', '.btn-save', function (e) {
                        e.preventDefault();
                        var Newsform = document.querySelector("#news-form");
                        var NewsformData = new FormData(Newsform);
                        $.ajax({
                            type: "POST",
                            dataType: 'JSON',
                            url: '{{route('admin.news.save')}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: NewsformData,
                            success: function () {
                                newsTable.draw();
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endonce
@endsection
