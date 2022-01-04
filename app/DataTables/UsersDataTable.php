<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class UsersDataTable extends DataTable
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
        ->addColumn('CreatedAt', function ($user) {
                $created_at = $user->created_at->format('M-d-Y');
            return $created_at;
        })
       ->addColumn('action', function ($user) {
            return view('users._partials.datatable_action',['user'=>$user]);
        })
        ->rawColumns(['CreatedAt', 'action'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
      $users = User::where('id', '!=', Auth::id());
      return $users;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
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
          'first_name',
          'last_name',
          'email',
          'phone',
          'CreatedAt' => [
              'name'=>'users.created_at',
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
        return 'Users_' . date('YmdHis');
    }
}
