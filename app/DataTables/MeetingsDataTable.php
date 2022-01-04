<?php

namespace App\DataTables;

use App\Meeting;
use App\Participant;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class MeetingsDataTable extends DataTable
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
     ->addColumn('action', function ($meeting) {
        $participants = Participant::all()->where('meeting_id', $meeting->id);
        return view('meetings._partials.datatable_action', compact('meeting', 'participants'));
      })
     ->addColumn('host_name', function ($meeting) {
          return $meeting->user ? $meeting->user->first_name : "";
      })
      ->addColumn('participants', function ($meeting) {
        return $participants = Participant::all()->where('meeting_id', $meeting->id)->count();
    })
    ->addColumn('start_time', function ($meeting) {
        $created_at = $meeting->created_at->format('H:i:s M-d-Y');
        return $created_at;
    })
      ->rawColumns(['status' , 'action', 'host_name', 'participants', 'start_time'])
      ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Meeting $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Meeting $model)
    {
      if(Auth::user()->hasRole('Software-admin')){
        $data =  $model->newQuery();
      }
      else{
        $data = $model->where('user_id' , Auth::id())->newQuery();
      }

      return $data;

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
      return $this->builder()
                  ->setTableId('meetings-table')
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
            'host_name',
            'participants',
            'start_time',
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
        return 'Meetings_' . date('YmdHis');
    }
}
