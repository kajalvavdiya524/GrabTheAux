
<div class="col">
    <div class="btn-group task-list-action">
        <div class="dropdown">
            <a href="#"
               class="btn btn-transparent border p-2 default-color dropdown-hover p-0"
               data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <i class=" icon-options"></i>
            </a>
            <div class="dropdown-menu" x-placement="bottom-start"
                 style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item" href="javascript:void(0)"
                       data-toggle="modal"
                       data-target=".bd-example-modal-sm-{{$meeting->id}}">
                        <i class="icon-close text-danger pr-2"></i>
                        Delete</a>

                    <a class="dropdown-item" href="javascript:void(0)"
                        data-toggle="modal"
                        data-target=".bd-participants-modal-sm-{{$meeting->id}}">
                         <i class="icon-eye text-danger pr-2"></i>
                         View Participants</a>
            </div>
        </div>
    </div>
</div>

      <!--delete modal-->
        <div class="modal fade bd-example-modal-sm-{{$meeting->id}}"
             tabindex="-1" role="dialog"
             aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mySmallModalLabel">
                            Delete Meeting
                            <strong>{{ $meeting->title }}</strong></h6>
                        <button type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>Are you sure?</h6><br>
                        <form
                            action="{{url('meetings' , $meeting->id)}}"
                            method="post">
                            @csrf
                            <input name="_method" type="hidden"
                                   value="DELETE">
                            <div class="float-right">
                                <button type="submit"
                                        class="btn btn-primary mx-a">Yes
                                </button>
                                <button type="button"
                                        class="btn btn-secondary mx-a"
                                        data-dismiss="modal">No
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end delete modal-->


        <!--Participants modal-->
        <div class="modal fade bd-participants-modal-sm-{{$meeting->id}}"
            tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-md">
               <div class="modal-content">
                   <div class="modal-header">
                       <h6 class="modal-title" id="mySmallModalLabel">
                           Participants
                       <button type="button" class="close"
                               data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                    @if(count($participants)>0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($participants as $participant)
                                <tr>
                                    <th scope="row">{{ $participant->user->first_name }}</th>
                                    <td>
                                        {{ $participant->user->email }}
                                    </td>
                                    <td>{{ $participant->role }}</td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    @else
                        <h5>No Participants</h5>
                    @endif

                   </div>
               </div>
           </div>
       </div>

       <!-- end Participants modal-->
