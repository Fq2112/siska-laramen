@extends('layouts.mst_admin')
@section('title', 'Partners Vacancies Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Partners Vacancies
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
                    <div id="content1" class="x_content">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="partner_id">Partner Filter</label>
                                <select id="partner_id" class="form-control selectpicker" title="-- Select Partner --"
                                        data-live-search="true" data-max-options="1" multiple>
                                    @foreach($partnership as $partner)
                                        <option value="{{$partner->name}}">{{$partner->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-handshake form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <table id="myDataTable" class="table table-striped table-bordered bulk_action">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" class="flat"></th>
                                <th>ID</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($partnerVacancies as $row)
                                @php
                                    $vacancy = $row->getVacancy;
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $user = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $jobtype = \App\JobType::find($vacancy->jobtype_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                @endphp
                                <tr>
                                    <td class="a-center" style="vertical-align: middle" align="center">
                                        <input type="checkbox" class="flat">
                                    </td>
                                    <td style="vertical-align: middle">{{$row->id}}</td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$row->getPartner->name}}</strong><br>
                                        <a href="mailto:{{$row->getPartner->email}}">{{$row->getPartner->email}}</a><br>
                                        <a href="tel:{{$row->getPartner->phone}}">{{$row->getPartner->phone}}</a><br>
                                        <a href="{{$row->getPartner->uri}}"
                                           target="_blank">{{$row->getPartner->uri}}</a>
                                        <hr style="margin: .5em auto">
                                        <table>
                                            <tr>
                                                <td>
                                                    <table style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        <tr>
                                                            <td style="vertical-align: middle;text-align: center">
                                                                <a href="{{route('agency.profile',['id' =>
                                                                $vacancy->agency_id])}}" target="_blank">
                                                                    <img class="img-responsive" width="100"
                                                                         style="margin: 0 auto"
                                                                         src="{{$user->ava == "" || $user->ava ==
                                                                         "agency.png" ? asset('images/agency.png') :
                                                                         asset('storage/users/'.$user->ava)}}">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;text-align: center">
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Active Period"
                                                                      style="text-transform: uppercase"
                                                                      class="label label-{{$vacancy->active_period != ""
                                                                       ? 'primary' : 'warning'}}">
                                                                    {{$vacancy->active_period != "" ? 'Until '.
                                                                    \Carbon\Carbon::parse($vacancy->active_period)
                                                                    ->format('j F Y') : 'Unknown'}}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong></a>&nbsp;&ndash;
                                                                <span class="label label-default" data-toggle="tooltip"
                                                                      data-placement="bottom" title="Created at">
                                                                <i class="fa fa-calendar-alt"></i>&ensp;
                                                                    {{\Carbon\Carbon::parse($vacancy->created_at)
                                                                    ->format('j F Y')}}</span> |
                                                                <span class="label label-default" data-toggle="tooltip"
                                                                      data-placement="bottom" title="Last Update">
                                                                    <i class="fa fa-clock"></i>&ensp;{{$vacancy
                                                                    ->updated_at->diffForHumans()}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="{{route('agency.profile',['id' =>
                                                            $vacancy->agency_id])}}" target="_blank">{{$user->name}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{substr($city, 0, 2)=="Ko" ? substr($city,5) :
                                                            substr($city,10)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Recruitment Date" class="label label-info">
                                                                    <strong><i class="fa fa-users"></i>&ensp;
                                                                        {{$vacancy->recruitmentDate_start != "" &&
                                                                        $vacancy->recruitmentDate_end != "" ?
                                                                        \Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_start)
                                                                        ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_end)
                                                                        ->format('j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Job Interview Date"
                                                                      class="label label-primary">
                                                                    <strong><i class="fa fa-user-tie"></i>&ensp;
                                                                        {{$vacancy->interview_date != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->interview_date)
                                                                        ->format('l, j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Job Function">
                                                            <td><i class="fa fa-warehouse"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$jobfunc->nama}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Industry">
                                                            <td><i class="fa fa-industry"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$industry->nama}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Job Level">
                                                            <td><i class="fa fa-level-up-alt"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$joblevel->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Job Type">
                                                            <td><i class="fa fa-user-clock"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$jobtype->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Salary">
                                                            <td><i class="fa fa-money-bill-wave"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>IDR {{$salary->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Education Degree">
                                                            <td><i class="fa fa-graduation-cap"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$degrees->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Education Major">
                                                            <td><i class="fa fa-user-graduate"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$majors->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Work Experience">
                                                            <td><i class="fa fa-briefcase"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>At least {{$vacancy->pengalaman > 1 ?
                                                                $vacancy->pengalaman.' years' :
                                                                $vacancy->pengalaman.' year'}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Total Applicant">
                                                            <td><i class="fa fa-paper-plane"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td><strong>{{\App\Accepting::where
                                                            ('vacancy_id',$vacancy->id)->where('isApply',true)->count()}}
                                                                </strong> applicants
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                                        <hr style="margin: .5em auto">
                                        <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
                                    </td>
                                    <td style="vertical-align: middle;text-align: center">
                                        <span data-toggle="tooltip" data-placement="left" title="Status"
                                              class="label label-default" style="background: {{$vacancy->isPost == true ?
                                                                      '#00adb5' : '#fa5555'}}">
                                            <strong style="text-transform: uppercase">{{$vacancy->isPost == true ? 'Active' : 'Inactive'}}
                                            </strong>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <form method="post" id="form-deactivate{{$vacancy->id}}">
                                            {{csrf_field()}} {{method_field('PUT')}}
                                            <input type="hidden" name="check_form" value="schedule">
                                            <input type="hidden" name="isPost" value="0">
                                        </form>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning btn-sm"
                                                    style="font-weight: 600"
                                                    onclick="postPartnerVac('{{$vacancy->id}}','{{$vacancy->judul}}',
                                                            '{{$vacancy->recruitmentDate_start}}',
                                                            '{{$vacancy->recruitmentDate_end}}',
                                                            '{{$vacancy->interview_date}}')">
                                                <i class="fa fa-calendar-alt"></i>&ensp;SCHEDULE
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a onclick="editPartnerVac('{{$vacancy->id}}')">
                                                        <i class="fa fa-edit"></i>&ensp;Edit</a>
                                                </li>
                                                @if($vacancy->isPost == true)
                                                    <li>
                                                        <a onclick="deactivatePartnerVac('{{$vacancy->id}}',
                                                                '{{$vacancy->judul}}')">
                                                            <i class="fa fa-power-off"></i>&ensp;Deactivate</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <div class="col-sm-4" id="action-btn">
                                <div class="btn-group" style="float: right">
                                    <button id="btn_post" type="button" class="btn btn-success btn-sm"
                                            style="font-weight: 600">
                                        <i class="glyphicon glyphicon-check"></i>&ensp;POST
                                    </button>
                                    <button id="btn_pdf" type="button" class="btn btn-primary btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-file-pdf"></i>&ensp;PDF
                                    </button>
                                    <button id="btn_remove_app" type="button" class="btn btn-danger btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-trash"></i>&ensp;REMOVE
                                    </button>
                                </div>
                            </div>
                            <form method="post" id="form-partnerVac">
                                {{csrf_field()}}
                                <input id="partnerVac_ids" type="hidden" name="partnerVac_ids">
                            </form>
                        </div>
                    </div>
                    <div id="content2" class="x_content" style="display: none;">
                        <form method="post" id="form-vacancy">{{csrf_field()}} {{method_field('PUT')}}
                            <input type="hidden" name="check_form" value="vacancy">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="agency_id">Agency <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                        <select id="agency_id" class="form-control selectpicker" name="agency_id"
                                                data-live-search="true" title="-- Select Agency --" required>
                                            @foreach(\App\Agencies::all() as $agency)
                                                <option value="{{$agency->id}}">{{$agency->user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-8">
                                    <label for="judul">Vacancy <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                        <input type="text" id="judul" class="form-control" maxlength="200" name="judul"
                                               placeholder="Vacancy name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="pengalaman">Work Experience <span class="required">*</span></label>
                                    <div class="input-group" style="text-transform: none">
                                        <span class="input-group-addon">At least</span>
                                        <input class="form-control" type="text"
                                               onkeypress="return numberOnly(event, false)"
                                               maxlength="3" placeholder="0" id="pengalaman" name="pengalaman" required>
                                        <span class="input-group-addon">year(s)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="jobfunction_id">Job Function <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-warehouse"></i></span>
                                        <select id="jobfunction_id" class="form-control selectpicker"
                                                name="fungsikerja_id"
                                                data-live-search="true" title="-- Select Job Function --" required>
                                            @foreach(\App\FungsiKerja::all() as $function)
                                                <option value="{{$function->id}}">{{$function->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="industry_id">Industry <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                        <select id="industry_id" class="form-control selectpicker" name="industri_id"
                                                data-live-search="true" title="-- Select Industry --" required>
                                            @foreach(\App\Industri::all() as $industry)
                                                <option value="{{$industry->id}}">{{$industry->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="joblevel_id">Job Level <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-level-up-alt"></i></span>
                                        <select id="joblevel_id" class="form-control selectpicker" name="joblevel_id"
                                                data-live-search="true" title="-- Select Job Level --" required>
                                            @foreach(\App\JobLevel::all() as $level)
                                                <option value="{{$level->id}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="jobtype_id">Job Type <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-clock"></i></span>
                                        <select id="jobtype_id" class="form-control selectpicker" name="jobtype_id"
                                                data-live-search="true" title="-- Select Job Type --" required>
                                            @foreach(\App\JobType::all() as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="city_id">Location <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marked"></i></span>
                                        <select class="form-control selectpicker" title="-- Select City --" id="city_id"
                                                data-live-search="true" name="cities_id" required>
                                            @foreach(\App\Provinces::all() as $province)
                                                <optgroup label="{{$province->name}}">
                                                    @foreach($province->cities as $city)
                                                        <option value="{{$city->id}}">{{substr($city->name, 0, 2)=="Ko" ?
                                                    substr($city->name,4) : substr($city->name,9)}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="salary_id">Salary <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>Rp</strong></span>
                                        <select id="salary_id" class="form-control selectpicker" name="salary_id"
                                                data-live-search="true" title="-- Select Salary --" required>
                                            @foreach(\App\Salaries::all() as $salary)
                                                <option value="{{$salary->id}}">{{$salary->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="degree_id">Education Degree <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                        <select id="degree_id" class="form-control selectpicker" name="tingkatpend_id"
                                                data-live-search="true" title="-- Select Degree --" required>
                                            @foreach(\App\Tingkatpend::all() as $degree)
                                                <option value="{{$degree->id}}">{{$degree->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="major_id">Education Major <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-graduate"></i></span>
                                        <select id="major_id" class="form-control selectpicker" name="jurusanpend_id"
                                                data-live-search="true" title="-- Select Major --" required>
                                            @foreach(\App\Jurusanpend::all() as $major)
                                                <option value="{{$major->id}}">{{$major->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="syarat">Requirements <span class="required">*</span></label>
                                    <textarea id="syarat" class="use-tinymce" name="syarat"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="tanggungjawab">Responsibilities <span class="required">*</span></label>
                                    <textarea id="tanggungjawab" class="use-tinymce" name="tanggungjawab"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <button id="btn_cancel" type="reset" class="btn btn-block btn-default">Cancel
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button id="btn_submit" type="submit" class="btn btn-block btn-primary">Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="scheduleModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><strong id="vacancy_title"></strong> &ndash; Vacancy Schedule</h4>
                </div>
                <form method="post" id="form-schedule">
                    {{csrf_field()}} {{method_field('PUT')}}
                    <input type="hidden" name="check_form" value="schedule">
                    <input type="hidden" name="isPost" value="1">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Recruitment Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input style="background-color: #fff;width: 50%" class="form-control" type="text"
                                           maxlength="10" placeholder="yyyy-mm-dd" name="recruitmentDate_start"
                                           id="recruitmentDate_start" required>
                                    <input style="background-color: #fff;width:50%" class="form-control" type="text"
                                           maxlength="10" placeholder="yyyy-mm-dd" name="recruitmentDate_end"
                                           id="recruitmentDate_end" required>
                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Interview Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                                    <input style="background-color: #fff" class="form-control" type="text"
                                           maxlength="10" placeholder="yyyy-mm-dd" name="interview_date"
                                           id="interview_date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(function () {
            var table = $("#myDataTable").DataTable({
                order: [[1, "desc"]],
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false
                    },
                    {
                        targets: [1],
                        visible: false,
                        searchable: false
                    }
                ]
            }), toolbar = $("#myDataTable_wrapper").children().eq(0);

            toolbar.children().toggleClass("col-sm-6 col-sm-4");
            $('#action-btn').appendTo(toolbar);

            @if($findPartner != "")
            $("#partner_id").val('{{$findPartner}}').selectpicker('refresh');
            $(".dataTables_filter input[type=search]").val('{{$findPartner}}').trigger('keyup');
            @endif

            $("#partner_id").on('change', function () {
                $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
            });

            $("#check-all").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#myDataTable tbody tr").addClass("selected").find('input[type=checkbox]').iCheck("check");
                } else {
                    $("#myDataTable tbody tr").removeClass("selected").find('input[type=checkbox]').iCheck("uncheck");
                }
            });

            $("#myDataTable tbody").on("click", "tr", function () {
                $(this).toggleClass("selected");
                $(this).find('input[type=checkbox]').iCheck("toggle");
            });

            $('#btn_post').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#partnerVac_ids").val(ids);
                $("#form-partnerVac").attr("action", "{{route('partners.vacancies.massPost')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Post Partner Vacancies',
                        text: 'The status of the ' + ids.length + ' selected vacancies will be change into "ACTIVE". ' +
                            'Are you sure to post them?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00adb5',
                        confirmButtonText: 'Yes, post them!',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $("#form-partnerVac")[0].submit();
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "There's no any selected record!", "error");
                }
                return false;
            });

            $('#btn_pdf').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#partnerVac_ids").val(ids);
                $("#form-partnerVac").attr("action", "{{route('partners.vacancies.massPDF')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Generate PDF',
                        text: 'Are you sure to generate this ' + ids.length + ' selected records into a pdf file? ' +
                            'You won\'t be able to revert this!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00adb5',
                        confirmButtonText: 'Yes, generate now!',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('partners.vacancies.massPDF')}}",
                                    data: new FormData($("#form-partnerVac")[0]),
                                    contentType: false,
                                    processData: false,
                                    success: function (data) {
                                        if (data == 0) {
                                            swal("Error!", "Couldn't zip the file! Please try again.", "error");
                                        } else {
                                            swal("Success!", "Pdf file(s) is successfully generated and " +
                                                "zipped into PDFs.zip file!", "success");
                                        }
                                    },
                                    error: function () {
                                        swal("Error!", "Something went wrong, please refresh the page.", "error");
                                    }
                                });
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "There's no any selected record!", "error");
                }
                return false;
            });

            $('#btn_remove_app').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#partnerVac_ids").val(ids);
                $("#form-partnerVac").attr("action", "{{route('partners.vacancies.massDelete')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Remove Partner Vacancies',
                        text: 'Are you sure to remove this ' + ids.length + ' selected records? ' +
                            'You won\'t be able to revert this!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#fa5555',
                        confirmButtonText: 'Yes, delete it!',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $("#form-partnerVac")[0].submit();
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "There's no any selected record!", "error");
                }
                return false;
            });
        });

        function editPartnerVac(id) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);

            $("#panel_title").html('Partner Vacancies<small>Setup</small>');

            $.get("{{route('partners.vacancies.edit',['id' => ''])}}/" + id, function (data) {
                $('#agency_id').val(data.agency_id).selectpicker("refresh");
                $('#judul').val(data.judul);
                $('#pengalaman').val(data.pengalaman);
                $('#jobfunction_id').val(data.fungsikerja_id).selectpicker("refresh");
                $('#industry_id').val(data.industry_id).selectpicker("refresh");
                $('#joblevel_id').val(data.joblevel_id).selectpicker("refresh");
                $('#jobtype_id').val(data.jobtype_id).selectpicker("refresh");
                $('#city_id').val(data.cities_id).selectpicker("refresh");
                $('#salary_id').val(data.salary_id).selectpicker("refresh");
                $('#degree_id').val(data.tingkatpend_id).selectpicker("refresh");
                $('#major_id').val(data.jurusanpend_id).selectpicker("refresh");
                tinyMCE.get('syarat').setContent(data.syarat);
                tinyMCE.get('tanggungjawab').setContent(data.tanggungjawab);
            });

            $("#form-vacancy").attr('action', '{{route('partners.vacancies.update',['id'=> ''])}}/' + id);
            $("#btn_submit").html("<strong>SAVE CHANGES</strong>");
        }

        function postPartnerVac(id, judul, start, end, interview) {
            var $start = $("#recruitmentDate_start"), $end = $("#recruitmentDate_end"),
                $interview = $("#interview_date");

            $("#vacancy_title").text(judul);
            $("#form-schedule").attr('action', '{{route('partners.vacancies.update',['id'=> ''])}}/' + id);

            $start.val(start);
            $end.val(end);
            $interview.val(interview);

            if (start == "") {
                $start.datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: new Date()
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $end.datepicker({
                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: minDate,
                    }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $interview.datepicker({
                            format: "yyyy-mm-dd",
                            autoclose: true,
                            todayHighlight: true,
                            todayBtn: true,
                            startDate: minDate
                        });
                    });
                });

            } else {
                $start.datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: new Date(),
                });
                $end.datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: start,
                });
                $interview.datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: end
                });
            }

            $("#scheduleModal").modal('show');
        }

        function deactivatePartnerVac(id, judul) {
            swal({
                title: 'Deactivate Partner Vacancy - ' + judul,
                text: 'The status of the vacancy will be change into "INACTIVE". Are you sure to deactivate it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, deactivate it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#form-deactivate" + id).attr("action", "{{route('partners.vacancies.update',['id'=> ''])}}/" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        $("#btn_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);

            $("#panel_title").html('Partner Vacancies<small>Table</small>');
        });

        $("#form-vacancy").on("submit", function (e) {
            e.preventDefault();
            if (tinyMCE.get('syarat').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Requirements field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else if (tinyMCE.get('tanggungjawab').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Responsibilities field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $('#form-vacancy')[0].submit();
            }
        })
    </script>
@endpush