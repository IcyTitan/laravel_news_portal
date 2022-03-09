<nav aria-label="Page navigation">
    <ul class="pagination">
        @for ($i = 1; $i <= $pagesCount; $i++)
            <li class="page-item">
                <a class="page-link"
                   href="{{route('news.main',['category'=>$currentCategory,'page'=>$i])}}"
                >
                    {{$i}}
                </a>
            </li>
        @endfor
    </ul>
</nav>
