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
    <div class="d-flex flex-row mt-4">
        <div class="filter">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="filter navbar-brand">
                    Отображать по
                    <select id="select-pagination" name="category">
                        @foreach ($pageSize as $key=>$size)
                            <option
                                value="{{$key}}"
                                @if($size == $selectSize)
                                selected
                                @endif
                            >
                                {{$key}}
                            </option>
                        @endforeach
                    </select>
                    шт.
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        @foreach ($categories as $category)
                            <a href="{{route('news.main',['category'=>$category->id])}}"
                               class="nav-item nav-link">{{$category->name}}</a>
                        @endforeach
                    </div>
                </div>
            </nav>
        </div>
    </div>
    @if (count($arrNews)>0)
        @foreach ($arrNews as $news)
            <div class="news-list mt-4 alert alert-secondary">
                <div class="date alert-link">{{$news->created_at}}</div>
                <div class="name alert-link">{{$news->name}}</div>
                <div class="short_description">
                    {{$news->short_description}}
                </div>
            </div>
        @endforeach
        {!!$paginator!!}
    @else
        Похоже в этом разделе пусто.
    @endif
</div>
@once
    <script type="application/javascript">
        const CSFR_TOKEN = '{{csrf_token()}}';
        const SET_PAGINATION = '{{route('news.pagination')}}';
    </script>
@endonce
</body>
</html>
