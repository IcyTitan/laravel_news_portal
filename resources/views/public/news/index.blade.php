<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <title>Новостной портал</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset("js/scripts/news.js") }}"></script>
</head>
<body>
<div class="news container mt-4">
    <div class="filter d-flex flex-column">
        <select size="4" id="select-pagination" name="category">
            <option disabled>Выберите чиссло элементов на странице</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
        </select>
    </div>
    <div class="filter d-flex flex-column mt-4">
        <select size="4" id="select-category" name="category">
            <option disabled>Выберите категорию</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    @foreach ($arrNews as $news)
        <div class="news-list mt-4 alert alert-secondary">
            <div class="date alert-link">{{$news->created_at}}</div>
            <div class="name alert-link">{{$news->name}}</div>
            <div class="short_description">
                {{$news->short_description}}
            </div>
        </div>
    @endforeach
    {{ $arrNews->links() }}
</div>
@once
    <script type="application/javascript">
        const CSFR_TOKEN = '{{csrf_token()}}';
        const SET_CATEGORY = '{{route('news.setCategory')}}';
        const SET_PAGINATION = '{{route('news.setPagination')}}'
    </script>
@endonce
</body>
</html>
