<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use DataTables;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin/news/index');
    }

    public function drawNewsTable(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('admin.news') . '" class="edit btn btn-success btn-sm">Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" id-attr="' . $row->id . '">Delete</a>
                    ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
