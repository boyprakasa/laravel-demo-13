<?php

namespace App\DataTables;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable class for managing and displaying Loan records.
 * Handles data retrieval, column definitions, filtering, sorting, and action columns
 * for the Loans resource in the admin interface.
 *
 * Each loan record shows the member who borrowed the book, the book title,
 * dates (loan, expected return, actual return), status, and any fines applied.
 */
class LoansDataTable extends DataTable
{
    /**
     * Build the DataTable class with all columns, filters, and formatting.
     *
     * @param  QueryBuilder<Loan>  $query  Results from query() method containing loan records with loaded relationships.
     * @return EloquentDataTable An initialized DataTable instance with all columns and actions configured.
     *
     * This method configures:
     * - Menambahkan kolom index untuk identifikasi baris
     * - Menambahkan kolom loan_date menampilkan tanggal peminjaman
     * - Menambahkan kolom expected_return_date menampilkan tanggal pengembalian yang diharapkan
     * - Menambahkan kolom actual_return_date menampilkan ketika buku dikembalikan (atau '-' jika belum dikembalikan)
     * - Menambahkan kolom status menampilkan status pinjaman saat ini (on_loan, returned, overdue)
     * - Menambahkan kolom fine menampilkan jumlah denda yang diterapkan
     * - Menambahkan kolom aksi dengan tombol view/edit/delete
     * - Date formatting for loan_date, expected_return_date, actual_return_date, created_at, updated_at
     * - visible(false) on created_at and updated_at to hide from UI
     * - Row ID setting for DataTables JavaScript integration
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Add sequential row index column */
            ->addIndexColumn()

            /** Add action column with view/edit/delete buttons */
            ->addColumn('action', 'loan.action')

            /** Format loan_date using Laravel's format_date helper */
            ->editColumn('loan_date', function ($query) {
                return format_date($query->loan_date);
            })

            /** Format expected_return_date using Laravel's format_date helper */
            ->editColumn('expected_return_date', function ($query) {
                return format_date($query->expected_return_date);
            })

            /** Format actual_return_date using Laravel's format_date helper, show '-' if not returned */
            ->editColumn('actual_return_date', function ($query) {
                return $query->actual_return_date ? format_date($query->actual_return_date) : '-';
            })

            /** Format created_at date using Laravel's format_datetime helper */
            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })

            /** Format updated_at date using Laravel's format_datetime helper */
            ->editColumn('updated_at', function ($query) {
                return format_datetime($query->updated_at);
            })

            /** Hide created_at and updated_at columns from UI display */
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Loan>
     */
    public function query(Loan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('loans-table')
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

            // Column::make('member.name')
            //     ->title('Nama'),

            // Column::make('book.title')
            //     ->title('Judul Buku'),

            Column::make('loan_date')
                ->title('Tanggal Peminjaman'),

            Column::make('expected_return_date')
                ->title('Tanggal Pengembalian'),

            Column::make('actual_return_date')
                ->title('Tanggal Dikembalikan'),

            Column::make('status')
                ->title('Status'),

            Column::make('fine')
                ->title('Denda'),

            Column::make('created_at')
                ->title('Dibuat')
                ->visible(false),

            Column::make('updated_at')
                ->title('Diperbarui')
                ->visible(false),

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
        return 'Loans_'.date('YmdHis');
    }
}
