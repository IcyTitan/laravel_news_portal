<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;

class NewsController extends Controller
{
    private $pageSize = [
        '5' => 5,
        '10' => 10,
        '15' => 15,
        '50' => 50,
    ];

    public function index(Request $request, DatabaseHelper $database)
    {
        $category = $request->input('category');

        if (!empty($request->cookie('pagination_count'))) {
            $paginationCount = $request->cookie('pagination_count');
        } else {
            $paginationCount = 10;
        }

        if (!empty($request->input('page'))) {
            $page = (intval($request->input('page'))-1)*$paginationCount;
        } else {
            $page = 0;
        }



        $categories = $database->query("call get_news_categories();");

        if (!empty($request->input('category'))) {
            $news = $database->prepareQuery(
                "call get_pagination_filtered_news(?,?,?)",
                'iii',
                [$request->input('category'),
                    $paginationCount,
                    $page
                ]
            );
            $countNews = $database->prepareQuery(
                'call count_news_category(?)',
                'i',
                [$request->input('category')]
            )[0]->total;
        } else {
            $news = $database->prepareQuery(
                "call get_pagination_news(?,?)",
                'ii',
                [$paginationCount, $page]
            );
            $countNews = $database->query('call count_news()')[0]->total;
        }
        $paginator = $this->makePaginator($page, $countNews, $paginationCount, $category);
        return view('public/news/index')->with([
            'categories' => $categories,
            'arrNews' => $news,
            'pageSize' => $this->pageSize,
            'selectSize' => $paginationCount,
            'paginator' => $paginator
        ]);
    }

    private function makePaginator($currentPage, $elementsCount, $pageSize, $category)
    {
        $pagesCount = $elementsCount / $pageSize;

        if ($pagesCount <= 1) {
            return false;
        }

        return view('public/components/paginator')->with([
            'pagesCount' => ceil($pagesCount),
            'currentPage' => $currentPage,
            'currentCategory'=> $category
        ]);
    }

    public function setPaginationCount(Request $request)
    {
        $count = $request->input('count');
        return response(
            ['success' => true]
        )->cookie(
            'pagination_count',
            $this->pageSize[$count],
            60,
        );
    }
}
