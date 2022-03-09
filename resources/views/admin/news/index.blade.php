@extends('layouts.app')
@section('content')
    <div class="container">
        {!! $dataTable->table() !!}
    </div>
    <div class="container">
        <form id="news-form">
            <div class="error-text alert alert-danger d-none"></div>
            <div class="success-text alert alert-success d-none">Соохранение прошло успешно</div>
            <div class="form-group">
                <label>Имя:</label>
                <input type="text" name="name" id="form-name" autocomplete="off" class="form-control">
            </div>

            <div class="form-group d-flex flex-column">
                <label>Категория:</label>
                <select size="4" id="form-category" name="category" class="">
                    <option disabled>Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Текст анонса:</label>
                <textarea rows="5" cols="45" name="short-description" id="form-short-description"
                          class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Текст детального описания:</label>
                <textarea rows="5" cols="45" name="description" id="form-description" class="form-control"></textarea>
            </div>

            <div class="form-group mt-4">
                <button type="submit" id="update-button" class="btn btn-success btn-update" disabled>Применить</button>
                <button type="submit" id="save-button" class="btn btn-success btn-save">Сохранить как новую запись</button>
            </div>
        </form>
    </div>

    @once
        @push('scripts')
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
            <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
            <script src="/vendor/datatables/buttons.server-side.js"></script>
            <script src="{{ asset('/js/scripts/admin/news.js') }}"></script>
            {!! $dataTable->scripts() !!}

            <script type="application/javascript">
                $(function () {
                    let routs = {
                        edit: '{{route('admin.news.edit')}}',
                        delete: '{{route('admin.news.delete')}}',
                        update: '{{route('admin.news.update')}}',
                        save: '{{route('admin.news.save')}}',
                    }

                    let helper = new window.adminNewsHelper();
                    helper.setCsrf('{{ csrf_token() }}');
                    helper.validate(routs.save, routs.update);

                    $(document).on('click', '.edit-button', function (e) {
                        e.preventDefault();
                        helper.changeEntry(routs.edit, $(this));
                        $(".btn-save").attr('disabled', true);
                        $(".btn-update").attr('disabled', false);
                    });

                    $(document).on('click', '.delete-button', function (e) {
                        e.preventDefault();
                        helper.changeEntry(routs.delete, $(this));
                    });

                });
            </script>
        @endpush
    @endonce
@endsection
