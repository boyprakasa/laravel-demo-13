<?php

namespace App\DataTables;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LoansDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Loan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addIndexColumn()

            ->addColumn('action', 'loan.action')

            ->editColumn('loan_date', function ($query) {
                return format_date($query->loan_date);
            })

            ->editColumn('expected_return_date', function ($query) {
                return format_date($query->expected_return_date);
            })

            ->editColumn('actual_return_date', function ($query) {
                return $query->actual_return_date ? format_date($query->actual_return_date) : '-';
            })

            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })

            ->editColumn('updated_at', function ($query) {
                return format_datetime($query->updated_at);
            })

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
                Button::make('reload')
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
        return 'Loans_' . date('YmdHis');
    }
}
