<?php

namespace App\DataTables\Admin;

use App\Models\News;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->editColumn('category', function ($model) {
                return $model->category->name;
            })
            ->addColumn('action', function ($row) {
                return view('admin/components/tablebuttons')->with([
                    'row' => $row,
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\News $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(News $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('news-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'Все']
                ],
                'buttons' => [
                    'csv'
                ]
            ])
            ->dom('Bfrltip')
            ->orderBy(1)
            ->buttons(
                Button::make('print'),
                Button::make('reload'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('id'),
            Column::make('name')->title('Имя'),
            Column::make('category')->title('Категория'),
            Column::make('short_description')->title('Превью'),
            Column::make('description')->title('Описание'),
            Column::make('created_at')->title('Дата создания'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

}
