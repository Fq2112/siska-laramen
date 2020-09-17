@extends('layouts.mst_admin')
@section('title', 'Partners Credentials Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Partners Credentials
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link" data-toggle="tooltip" title="Close" data-placement="right">
                                    <i class="fa fa-times"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="instansi">Filter Instansi</label>
                                <select id="instansi" class="form-control selectpicker" title="-- Pilih Instansi --"
                                        data-live-search="true" data-max-options="1" multiple>
                                    @foreach(\App\PartnerCredential::all() as $row)
                                        <option value="{{$row->name}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Details</th>
                                <th>Credentials</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1;  @endphp
                            @foreach($partnership as $row)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$row->name}}</strong><br>
                                        <a href="mailto:{{$row->email}}">{{$row->email}}</a><br>
                                        <a href="tel:{{$row->phone}}">{{$row->phone}}</a><br>
                                        <a href="{{$row->uri}}" target="_blank">{{$row->uri}}</a>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-key"></i>&nbsp;</td>
                                                <td>API Key</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$row->api_key != "" ? $row->api_key : '&ndash;'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-shield-alt"></i>&nbsp;</td>
                                                <td>API Secret</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$row->api_secret != "" ? $row->api_secret : '&ndash;'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>API Expiry</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$row->api_expiry != "" ? \Carbon\Carbon::parse($row->api_expiry)
                                                ->format('l, j F Y') : '&ndash;'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-sync"></i>&nbsp;</td>
                                                <td>Status</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="text-transform: uppercase">
                                                    @if($row->api_expiry != null && today() > $row->api_expiry)
                                                        <span class="label label-warning">EXPIRED</span>
                                                    @else
                                                        <span class="label label-{{$row->status == true ? 'success' :
                                                        'danger'}}">{{$row->status == true ? 'ACTIVE' : 'INACTIVE'}}
                                                        </span>
                                                    @endif
                                                    &nbsp;|&nbsp;<span class="label label-{{$row->isSync == true ? 'primary'
                                                    : 'default'}}">{{$row->isSync == true ? 'Synchronized' :
                                                    'Not Synchronized Yet'}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <form id="form-approval{{$row->id}}" method="post"
                                              action="{{route('partners.credentials.update',['id' => $row->id])}}">
                                            {{csrf_field()}} {{method_field('PUT')}}
                                            <input type="hidden" name="status" id="input_status{{$row->id}}">
                                        </form>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm"
                                                    style="font-weight: 600"
                                                    onclick="activatePartner('{{$row->id}}','{{$row->name}}')"
                                                    {{$row->status == false ? '' : 'disabled'}}>
                                                {{$row->status == false ? 'APPROVE' : 'APPROVED'}}
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($row->status == true)
                                                    <li><a onclick="deactivatePartner('{{$row->id}}','{{$row->name}}')">
                                                            <i class="fa fa-power-off"></i>&ensp;Deactivate</a></li>
                                                @endif
                                                <li>
                                                    <a href="{{route('partners.credentials.delete',[
                                                    'id' => encrypt($row->id)])}}" class="delete-partnership">
                                                        <i class="fa fa-trash-alt"></i>&ensp;Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(function () {
            @if($findPartner != "")
            $("#instansi").val('{{$findPartner}}').selectpicker('refresh');
            $(".dataTables_filter input[type=search]").val('{{$findPartner}}').trigger('keyup');
            @endif
        });

        $("#instansi").on("change", function () {
            $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
        });

        function activatePartner(id, name) {
            swal({
                title: 'Partnership Approval',
                text: 'By continuing this, you\'ll send the credentials API Key & API Secret ' +
                    'for ' + name + ' through the registered email. Are you sure to approve it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00adb5',
                confirmButtonText: 'Yes, approve it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#input_status" + id).val(1);
                        $("#form-approval" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        function deactivatePartner(id, name) {
            swal({
                title: 'Deactivate ' + name + ' Credentials',
                text: 'The status of this partner will be change into "INACTIVE". Are you sure to deactivate it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, deactivate it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#input_status" + id).val(0);
                        $("#form-approval" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        $(".delete-partnership").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Delete Partnership',
                text: 'Are you sure? You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = linkURL;
                    });
                },
                allowOutsideClick: false
            });
            return false;
        });
    </script>
@endpush