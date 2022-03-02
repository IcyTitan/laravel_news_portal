<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategories;
use DataTables;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $categories = NewsCategories::all();
        return view('admin/news/index')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function drawNewsTable(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button
                                        type="button"
                                        class="edit btn btn-success btn-sm edit-button"
                                        id-attr="' . $row->id . '">
                                    Edit
                                  </button>
                        <button
                                class="delete btn btn-danger btn-sm delete-button"
                                id-attr="' . $row->id . '">
                            Delete
                        </button>
                    ';
                    return $actionBtn;
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsDelete(Request $request)
    {
        $response = News::find($request->id)->delete();
        return response()->json([
                'success' => $response,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsEdit(Request $request)
    {
        $news = News::find($request->id);
        return response()->json([
            'success' => !empty($news),
            'news' => $news,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNews(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $company = News::find($request->input('id'));

        $company->name = $request->input('name');
        $company->category_id = $request->input('category');
        $company->short_description = $request->input('short-description');
        $company->description = $request->input('description');
        $success = $company->update();

        return response()->json(
            [
                'success' => $success,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveNews(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

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
