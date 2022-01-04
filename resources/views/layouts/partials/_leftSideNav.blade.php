

<!--left sidebar start-->
<div class="left-sidebar">
    <nav class="sidebar-menu">
        <ul id="nav-accordion">
            {{-- <li class="sub-menu">
                <a href="/" class="active">
                    <i class=" ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li> --}}

            <li class="sub-menu">
                <a href="{{url('meetings')}}"  class=" @if(Request::segment(1) == 'meetings' || Request::segment(1) == 'join') active @endif">
                    <i class="fa fa-video-camera"></i>
                    <span>Meetings</span>
                </a>
            </li>

            @hasrole('Software-admin')
            <li class="sub-menu">
                <a href="{{url('users')}}"  class=" @if(Request::segment(1) == 'users') active @endif">
                    <i class="icon-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="{{url('memberships')}}" class=" @if(Request::segment(1) == 'memberships') active @endif">
                    <i class="icon-badge"></i>
                    <span>Memberships</span>
                </a>
            </li>
           @endhasrole

            {{-- <li class="nav-title">
                <h5 class="text-uppercase">Components</h5>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" ti-layers"></i>
                    <span>BS Elements</span>
                </a>
                <ul class="sub">
                    <li><a  href="alert.html">Alerts</a></li>
                    <li><a  href="buttons.html">Buttons</a></li>
                    <li><a  href="cards.html">Cards</a></li>
                    <li><a  href="dropdown.html">Dropdowns</a></li>
                    <li><a  href="grid.html">Grids</a></li>
                    <li><a  href="lists.html">Lists</a></li>
                    <li><a  href="modal.html">Modals</a></li>
                    <li><a  href="progress.html">Progress</a></li>
                    <li><a  href="popover-tooltips.html">Popover & Tooltips</a></li>
                    <li><a  href="typography.html">Typography</a></li>
                    <li><a  href="tabs.html">Tabs</a></li>
                    <li><a  href="tree.html">Tree</a></li>
                    <li><a  href="toastr.html">Toastr Notification</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="ti-archive"></i>
                    <span>Portlets</span>
                </a>
                <ul class="sub">
                    <li><a  href="portlet-base.html">Portlets Base</a></li>
                    <li><a  href="portlet-advanced.html">Portlets Advanced</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" ti-pencil-alt"></i>
                    <span>Icons</span>
                </a>
                <ul class="sub">
                    <li><a  href="icon-font-awesome.html">Fontawesome Icons</a></li>
                    <li><a  href="icon-themify.html">Themify Icons</a></li>
                    <li><a  href="icon-simple-line.html">Simple line Icons</a></li>
                    <li><a  href="icon-weather.html">Weather Icons</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" ti-blackboard"></i>
                    <span>Widgets </span> <span class="badge badge-primary ml-2">2</span>
                </a>
                <ul class="sub">
                    <li><a  href="widgets-base.html">Widgets Base</a></li>
                    <li><a  href="widgets-chart.html">Widgets Chart</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="icon-calendar"></i>
                    <span>Calendar </span>
                </a>
                <ul class="sub">
                    <li><a  href="calendar-basic.html">Basic Calendar</a></li>
                    <li><a  href="calendar-external-events.html">External Events Calendar</a></li>
                    <li><a  href="calendar-list.html">List Calendar</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" icon-speech"></i>
                    <span>Forms</span>
                </a>
                <ul class="sub">
                    <li class="sub-menu">
                        <a  href="#">Form Control</a>
                        <ul class="sub">
                            <li><a  href="form-basic-input.html">Basic Input</a></li>
                            <li><a  href="form-input-group.html">Input Group</a></li>
                            <li><a  href="form-checkbox-radio.html">Checkbox & Radio</a></li>
                            <li><a  href="form-switch.html">Switch</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a  href="#">Pickers</a>
                        <ul class="sub">
                            <li><a  href="date-picker.html">Date Picker</a></li>
                            <li><a  href="datetime-picker.html">Datetime & Time Picker</a></li>
                            <li><a  href="color-picker.html">Color Picker</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a  href="#">Advanced Form</a>
                        <ul class="sub">
                            <li><a  href="form-touchspin.html">Touchpin</a></li>
                            <li><a  href="form-select2.html">Select2</a></li>
                            <li><a  href="form-input-mask.html">Input Mask</a></li>
                            <li><a  href="form-multiple-select.html"> Multiple Select</a></li>
                            <li><a  href="form-dropzone.html"> Dropzone</a></li>
                            <li><a  href="form-ion-range-slider.html"> Ion Range Slider</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a  href="#">Editos</a>
                        <ul class="sub">
                            <li><a  href="editor-summernote.html">Summernote</a></li>
                            <li><a  href="editor-markdown.html">Markdown</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a  href="#">Form Validation</a>
                        <ul class="sub">
                            <li><a  href="form-validation-basic.html">Basic Validation</a></li>
                            <li><a  href="form-validation-jquery.html">jQuery Validation</a></li>
                            <li><a  href="form-wizard.html">Form Wizard</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" icon-grid"></i>
                    <span>Data Tables</span>
                </a>
                <ul class="sub">
                    <li><a  href="table-basic.html">Basic Table</a></li>
                    <li class="sub-menu">
                        <a  href="#">Data Tables</a>
                        <ul class="sub">
                            <li><a  href="table-datatable.html">Basic Datatable</a></li>
                            <li><a  href="table-datatable-show-hide.html">Toggle Col Datatable</a></li>
                            <li><a  href="table-datatable-ajax.html">Ajax Datatable</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" ti-pie-chart"></i>
                    <span>Charts</span>
                </a>
                <ul class="sub">
                    <li><a  href="flot-chart.html">Flot Charts</a></li>
                    <li><a  href="echart.html">eCharts</a></li>
                    <li><a  href="morris-chart.html">Morris Charts</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" icon-equalizer"></i>
                    <span>Extra Pages</span>
                </a>
                <ul class="sub">
                    <li><a  href="profile.html">Profile</a></li>
                    <li><a  href="search-result.html">Search Result</a></li>
                    <li><a  href="invoice.html">Invoice</a></li>
                    <li class="sub-menu">
                        <a  href="#">Sign In</a>
                        <ul class="sub">
                            <li><a  href="signin.html">Basic Sign In</a></li>
                            <li><a  href="signin-validate.html">jQuery Validate Sign In</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a  href="#">Sign Up</a>
                        <ul class="sub">
                            <li><a  href="signup.html">Basic Sign Up</a></li>
                            <li><a  href="signup-validate.html">jQuery Validate Sign Up</a></li>
                        </ul>
                    </li>
                    <li><a  href="lock-screen.html">Lock Screen</a></li>
                    <li><a  href="404-error.html">404 Error</a></li>
                </ul>
            </li>

            <li class="nav-title">
                <h5 class="text-uppercase">Layouts & Multi Level Menu</h5>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" ti-layout"></i>
                    <span>Layouts</span>
                </a>
                <ul class="sub">
                    <li><a  href="layout-blank.html">Blank Page</a></li>
                    <li><a  href="layout-box-container.html">Box Container</a></li>
                    <li><a  href="layout-leftside-hidden.html">Leftside Hidden</a></li>
                    <li><a  href="layout-leftside-hidden-rightside-open.html">Left Hidden Rightside Open</a></li>
                    <li><a  href="layout-bothside-open.html">Bothside Open</a></li>
                    <li><a  href="layout-rightside-overlay.html">Rightside Overlay</a></li>
                    <li><a  href="layout-rightside-pushed.html">Rightside Pushed</a></li>
                    <li><a  href="layout-header-leftside-not-fixed.html">Header & Leftside not Fixed</a></li>
                    <li><a  href="layout-light-left-nav.html">Left Nav Light</a></li>
                    <li><a  href="layout-light-left-nav-alt.html">Left Nav Light Alt</a></li>
                </ul>
            </li>

            <!--multi level menu start-->
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" ti-paint-bucket"></i>
                    <span>Multi level Menu</span>
                </a>
                <ul class="sub">
                    <li><a  href="javascript:;">Menu Item 1</a></li>
                    <li class="sub-menu">
                        <a  href="#">Menu Item 2</a>
                        <ul class="sub">
                            <li><a  href="javascript:;">Menu Item 2.1</a></li>
                            <li class="sub-menu">
                                <a  href="javascript:;">Menu Item 3</a>
                                <ul class="sub">
                                    <li><a  href="javascript:;">Menu Item 3.1</a></li>
                                    <li><a  href="javascript:;">Menu Item 3.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!--multi level menu end-->

            <li class="nav-title">
                <h5 class="text-uppercase">Other Projects</h5>
            </li>

            <li>
                <a href="index.html">
                    <i class="fa fa-dot-circle-o text-danger"></i>
                    <span>Multi-Purpose Website</span>
                </a>
            </li>

            <li>
                <a href="index.html">
                    <i class="fa fa-dot-circle-o text-primary"></i>
                    <span>Email Template</span>
                </a>
            </li>
            <li>
                <a href="index.html">
                    <i class="fa fa-dot-circle-o text-warning"></i>
                    <span>Landing Website</span>
                </a>
            </li> --}}
        </ul>
    </nav>
</div>
<!--left sidebar end-->
