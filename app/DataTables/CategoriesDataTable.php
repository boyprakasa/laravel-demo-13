<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable class for managing and displaying Category records.
 * Handles data retrieval, column definitions, filtering, sorting, and action columns
 * for the Categories resource in the admin interface.
 *
 * Each category record shows the category name and the count of books
 * associated with that category.
 */
class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class with all columns, filters, and formatting.
     *
     * @param  QueryBuilder<Category>  $query  Results from query() method containing category records.
     * @return EloquentDataTable An initialized DataTable instance with all columns and actions configured.
     *
     * This method configures:
     * - Menambahkan kolom index untuk identifikasi baris
     * - Menampilkan jumlah buku per kategori
     * - Menambahkan kolom aksi dengan tombol view/edit/delete
     * - Date formatting for created_at and updated_at (hidden from view)
     * - Menandai kolom raw untuk rendering tombol aksi
     * - Row ID setting for DataTables JavaScript integration
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Menambahkan kolom index berurutan */
            ->addIndexColumn()

            /** Menampilkan jumlah buku per kategori */
            ->addColumn('category_count', function ($query) {
                return $query->books()->count();
            })

            /** Menambahkan kolom aksi dengan tombol view/edit/delete */
            ->addColumn('action', 'category.action')

            /** Format created_at date using Laravel's format_datetime helper */
            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })

            /** Format updated_at date using Laravel's format_datetime helper */
            ->editColumn(
                'updated_at',
                function ($query) {
                    return format_datetime($query->updated_at);
                }
            )

            /** Mark action column as raw to render HTML properly */
            ->rawColumns(['action'])

            /** Set HTML row ID for DataTables jQuery integration */
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Category>
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false),

            Column::make('name')
                ->title('Nama'),

            Column::make('category_count')
                ->title('Jumlah Buku'),

            Column::make('created_at')
                ->title('Dibuat')
                ->hidden(),

            Column::make('updated_at')
                ->title('Diperbarui')
                ->hidden(),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Categories_'.date('YmdHis');
    }
}
