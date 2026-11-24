<?php

namespace App\DataTables;

use App\Models\Author;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable class for managing and displaying Author records.
 * Handles data retrieval, column definitions, filtering, sorting, and action columns
 * for the Authors resource in the admin interface.
 *
 * Setiap catatan penulis menampilkan namanya, jumlah buku yang telah ditulis,
 * and action buttons for managing the author.
 */
class AuthorsDataTable extends DataTable
{
    /**
     * Build the DataTable class with all columns, filters, and formatting.
     *
     * @param  QueryBuilder<Author>  $query  Results from query() method containing author records.
     * @return EloquentDataTable An initialized DataTable instance with all columns and actions configured.
     *
     * This method configures:
     * - Menambahkan kolom index untuk identifikasi baris
     * - Menampilkan jumlah buku per penulis
     * - Menambahkan kolom aksi dengan tombol view/edit/delete
     * - Format tanggal created_at dan updated_at (tersembunyi dari tampilan)
     * - Menambahkan kolom aksi dengan tombol yang dihitung
     * - Row ID setting for DataTables JavaScript integration
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Menambahkan kolom index berurutan */
            ->addIndexColumn()

            /** Add books count column showing number of books per author */
            ->addColumn('books_count', function ($query) {
                return $query->books()->count();
            })

            /** Menambahkan kolom aksi dengan tombol view/edit/delete */
            ->addColumn('action', 'author.action')

            /** Format created_at date using Laravel's format_datetime helper */
            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })

            /** Format updated_at date using Laravel's format_datetime helper */
            ->editColumn('updated_at', function ($query) {
                return format_datetime($query->updated_at);
            })

            /** Set HTML row ID for DataTables jQuery integration */
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Author>
     */
    public function query(Author $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('authors-table')
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

            Column::make('books_count')
                ->title('Jumlah Buku')
                ->searchable(false),

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
        return 'Authors_'.date('YmdHis');
    }
}
