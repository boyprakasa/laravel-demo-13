<?php

namespace App\DataTables;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable class for managing and displaying Member records.
 * Handles data retrieval, column definitions, and action columns
 * for the Members resource in the admin interface.
 */
class MembersDataTable extends DataTable
{
    /**
     * Build the DataTable class with all columns and formatting.
     *
     * @param  QueryBuilder<Member>  $query  Results from query() method containing member records.
     * @return EloquentDataTable An initialized DataTable instance with all columns configured.
     *
     * This method configures:
     * - Menambahkan kolom index untuk identifikasi baris
     * - Columns for name, email, phone, and address
     * - Menambahkan kolom aksi dengan tombol view/edit/delete
     * - Format tanggal created_at dan updated_at (tersembunyi dari tampilan)
     * - Row ID setting for DataTables JavaScript integration
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Menambahkan kolom index berurutan */
            ->addIndexColumn()

            /** Menambahkan kolom nama */
            ->addColumn('name', function ($member) {
                return e($member->name);
            })

            /** Menambahkan kolom email */
            ->addColumn('email', function ($member) {
                return e($member->email);
            })

            /** Menambahkan kolom nomor telepon */
            ->addColumn('phone_number', function ($member) {
                return e($member->phone_number);
            })

            /** Menambahkan kolom alamat */
            ->addColumn('address', function ($member) {
                return e($member->address);
            })

            /** Menambahkan kolom aksi dengan tombol view/edit/delete */
            ->addColumn('action', 'member.action')

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
     * @return QueryBuilder<Member>
     */
    public function query(Member $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('members-table')
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
                ->orderable(false),

            Column::make('name')
                ->title('Nama'),

            Column::make('email')
                ->title('Email'),

            Column::make('phone_number')
                ->title('Telepon'),

            Column::make('address')
                ->title('Alamat'),

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
        return 'Members_'.date('YmdHis');
    }
}
