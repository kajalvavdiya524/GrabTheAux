<?php

namespace App\DataTables;

use App\Membership;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MembershipDataTable extends DataTable
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
        ->editColumn('price', function ($membership) {
            return '$'.$membership->price;
        })
        ->addColumn('CreatedAt', function ($membership) {
                $created_at = $membership->created_at->format('M-d-Y');
            return $created_at;
        })
       ->addColumn('action', function ($membership) {
            return view('memberships._partials.datatable_action',['membership'=>$membership]);
        })
        ->rawColumns(['status' , 'CreatedAt', 'action'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Membership $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Membership $model)
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
                  ->setTableId('membership-table')
                  ->columns($this->getColumns())
                  ->minifiedAjax()
                  ->dom('Bfrtip')
                  ->orderBy(1)
                  ->parameters([
                      'buttons' => [
                          // [
                          //     'extend'  => 'collection',
                          //     'text'    => '<i class="fa fa-download"></i> Export',
                          //     'buttons' => [
                          //         'csv',
                          //         'excel'
                          //     ],
                          // ],
                      ],
                  ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
      $getCols = [
            '#' => [
                'name'=> 'id',
                'data' => 'DT_RowIndex',
                'searchable' => false,
            ],
          'title',
          'description',
          'price',
          'CreatedAt' => [
              'name'=>'memberships.created_at',
              'searchable' => false
          ],
          'action' => [
              'exportable' => false,
              'searchable'=>false,
              'orderable' => false
          ]
      ];

      return $getCols;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Membership_' . date('YmdHis');
    }
}
