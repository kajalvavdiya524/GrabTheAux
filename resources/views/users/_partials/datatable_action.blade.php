
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
                       data-target=".bd-example-modal-sm-{{$user->id}}">
                        <i class="icon-close text-danger pr-2"></i>
                        Delete</a>
            </div>
        </div>
    </div>
</div>

      <!--delete modal-->
        <div class="modal fade bd-example-modal-sm-{{$user->id}}"
             tabindex="-1" role="dialog"
             aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mySmallModalLabel">
                            Delete User
                            <strong>{{ $user->first_name }}</strong></h6>
                        <button type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>Are you sure?</h6><br>
                        <form
                            action="{{url('users' , $user->id)}}"
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
