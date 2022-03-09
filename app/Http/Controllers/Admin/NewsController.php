<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\DataTables\Admin\NewsDataTable;
use DataTables;
use App\Helpers\DatabaseHelper;

class NewsController extends Controller
{
    public function index(NewsDataTable $dataTable, Request $request)
    {
        $database = new DatabaseHelper();

        if ($request->ajax()) {
            return $this->drawNewsTable();
        }
        $categories = $database->query("call get_news_categories()");
        return $dataTable->render(
            'admin/news/index',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * @param NewsDataTable $dataTable
     * @return mixed
     */
    private function drawNewsTable()
    {
        $model = News::query();
        return DataTables::of($model->newQuery())
            ->addIndexColumn()
            ->editColumn('category', function ($model) {
                return $model->category->name;
            })
            ->rawColumns(['action'])
            ->addColumn('action', function ($row) {
                return view('admin/components/tablebuttons')->with([
                    'row' => $row,
                ]);
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsDelete(Request $request, DatabaseHelper $database)
    {
        $id = intval($request->input('id'));
        $response = $database->prepareQuery("CALL delete_news(?)", "i", [$id]);
        return response()->json([
            'success' => $response,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsEdit(Request $request, DatabaseHelper $database)
    {
        $id = intval($request->input('id'));
        $news = $database->prepareQuery('call select_news(?)', "i", [$id]);
        return response()->json([
            'success' => !empty($news),
            'news' => $news[0],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNews(Request $request, DatabaseHelper $database)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,. ]+$/i', 'max:250', 'min:5'],
            'short-description' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,. ]+$/i', 'max:400', 'min:5'],
            'description' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,. ]+$/i', 'max:4000', 'min:5'],
            'category' => ['required', 'regex:/^[0-9]+$/i'],
            'id' => ['required', 'regex:/^[0-9]+$/i'],
        ],[
            'required' => 'Поле :attribute не заполнено',
            'regex' => 'Поле :attribute содержит недопустимые символы',
            'max' => 'Поле :attribute должно быть не больше :max символов.',
            'min' => 'Поле :attribute должно быть не меньше :min символов.',
        ]);

        $inserValues = [
            $request->input('name'),
            $request->input('category'),
            $request->input('short-description'),
            $request->input('description'),
            date("Y-m-d H:i:s"),
            $request->input('id')
        ];

        $queryRes = $database->prepareQuery('call update_news(?,?,?,?,?,?)', "sisssi", $inserValues);

        return response()->json(
            [
                'success' => $queryRes,
            ]
        );

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveNews(Request $request, DatabaseHelper $database)
    {
        $request->validate(
            [
                'name' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,.]+$/i' , 'max:250', 'min:5'],
                'short-description' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,. ]+$/i' , 'max:400', 'min:5'],
                'description' => ['required', 'regex:/^[aA-zZаА-яЯ0-9-_,. ]+$/i', 'max:4000', 'min:5'],
                'category' => ['required', 'regex:/^[0-9]+$/i'],
            ], [
                'required' => 'Поле :attribute не заполнено',
                'regex' => 'Поле :attribute содержит недопустимые символы',
                'max' => 'Поле :attribute должно быть не больше :max символов.',
                'min' => 'Поле :attribute должно быть не меньше :min символов.',
            ]);

        $inserValues = [
            $request->input('name'),
            $request->input('category'),
            $request->input('short-description'),
            $request->input('description'),
            date("Y-m-d H:i:s")
        ];

        $queryRes = $database->prepareQuery('call insert_news(?,?,?,?,?)', "sisss", $inserValues);

        $result = News::insert([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'short_description' => $request->input('short-description'),
            'description' => $request->input('description'),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return response()->json(
            [
                'success' => $result,
            ]
        );
    }

}
