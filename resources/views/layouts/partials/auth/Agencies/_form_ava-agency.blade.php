<div class="card to-animate-2">
    <form class="form-horizontal" role="form" method="POST" id="form-ava"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="img-card image-upload">
            <label for="file-input">
                @if($user->ava==null)
                    <img style="width: 100%" class="show_ava" alt="AVA is here..."
                         src="{{asset('images/avatar.png')}}"
                         data-placement="bottom" data-toggle="tooltip"
                         title="Click here to change your AVA!">
                @elseif($user->ava=='agency.png')
                    <img style="width: 100%" class="show_ava" alt="AVA is here..."
                         src="{{asset('images/agency.png')}}"
                         data-placement="bottom" data-toggle="tooltip"
                         title="Click here to change your AVA!">
                @else
                    <img style="width: 100%" class="show_ava" alt="AVA is here..."
                         src="{{asset('storage/users/'.$user->ava)}}"
                         data-placement="bottom" data-toggle="tooltip"
                         title="Click here to change your AVA!">
                @endif
            </label>
            <input id="file-input" name="ava" type="file" accept="image/*">
            <div id="progress-upload">
                <div class="progress-bar progress-bar-info progress-bar-striped active"
                     role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     style="background-color: #00ADB5;z-index: 20">
                </div>
            </div>
        </div>
    </form>

    <form action="{{route('agency.update.profile')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="check_form" value="personal_data">
        <div class="card-content">
            <div class="card-title text-center">
                <a href="{{route('seeker.edit.profile')}}">
                    <h4 class="aj_name" style="color: #006269">{{$user->name}}</h4></a>
                <small>
                    <a href="{{$agency->link}}" target="_blank"
                       style="text-transform: none;color: #00ADB5">{{$agency->link}}</a>
                </small>
            </div>
            <div class="card-title">
                @if(\Illuminate\Support\Facades\Request::is('account/agency/profile'))
                    <small id="show_personal_data_settings" class="pull-right" style="color: #00ADB5;cursor: pointer">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </small>
                @endif
                <table class="stats_personal_data" style="font-size: 15px">
                    <tr>
                        <td><i class="fa fa-industry"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$agency->industri_id != "" ? $industry->nama : '(empty)'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-building"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$agency->kantor_pusat != "" ? $agency->kantor_pusat : '(empty)'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-calendar-alt"></i></td>
                        <td>&nbsp;</td>
                        <td style="text-transform: none">{{$agency->hari_kerja != "" ? $agency->hari_kerja : '(empty)'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-clock"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$agency->jam_kerja != "" ? $agency->jam_kerja : '(empty)'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-phone"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$agency->phone != "" ? $agency->phone : '(empty)'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-map-marker-alt"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$agency->alamat != "" ? $agency->alamat : ''}}</td>
                    </tr>
                </table>
                <hr class="stats_personal_data">
                <table class="stats_personal_data" style="font-size: 14px">
                    <tr>
                        <td><i class="fa fa-calendar-check"></i></td>
                        <td>&nbsp;Member Since</td>
                        <td>
                            : {{$agency->created_at->format('j F Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-clock"></i></td>
                        <td>&nbsp;Last Update</td>
                        <td>
                            : {{$agency->updated_at->diffForHumans()}}
                        </td>
                    </tr>
                </table>
                <div id="personal_data_settings" style="display: none">
                    <small>Agency Name</small>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                <input placeholder="Name" maxlength="191" value="{{$user->name}}" type="text"
                                       class="form-control" name="name" required autofocus>
                            </div>
                        </div>
                    </div>

                    <small>Industry</small>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                <select class="form-control selectpicker"
                                        title="-- Choose --"
                                        name="industri_id" required>
                                    @foreach(App\Industri::all() as $row)
                                        <option value="{{$row->id}}" {{$agency->industri_id == $row->id ?
                                         'selected' : ''}}>{{$row->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <small>Headquarter</small>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input type="text" class="form-control" name="kantor_pusat"
                                       placeholder="Surabaya" required maxlength="60"
                                       value="{{$agency->kantor_pusat == "" ? '' : $agency->kantor_pusat}}">
                            </div>
                        </div>
                    </div>

                    <small>Working Days</small>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <small>Start Day</small>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-alt"></i></span>
                                <select class="form-control selectpicker" name="start_day"
                                        title="-- Start Day --" required>
                                    <option value="Monday"
                                            {{substr($agency->hari_kerja,0,3) == 'Mon' ? 'selected' : ''}}>Monday
                                    </option>
                                    <option value="Tuesday"
                                            {{substr($agency->hari_kerja,0,3) == 'Tue' ? 'selected' : ''}}>Tuesday
                                    </option>
                                    <option value="Wednesday"
                                            {{substr($agency->hari_kerja,0,3) == 'Wed' ? 'selected' : ''}}>Wednesday
                                    </option>
                                    <option value="Thursday"
                                            {{substr($agency->hari_kerja,0,3) == 'Thu' ? 'selected' : ''}}>Thursday
                                    </option>
                                    <option value="Friday"
                                            {{substr($agency->hari_kerja,0,3) == 'Fri' ? 'selected' : ''}}>Friday
                                    </option>
                                    <option value="Saturday"
                                            {{substr($agency->hari_kerja,0,3) == 'Sat' ? 'selected' : ''}}>Saturday
                                    </option>
                                    <option value="Sunday"
                                            {{substr($agency->hari_kerja,0,3) == 'Sun' ? 'selected' : ''}}>Sunday
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <small>End Day</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar-check"></i>
                                </span>
                                <select class="form-control selectpicker" name="end_day"
                                        title="-- End Day --" required>
                                    <option value="Monday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Mon' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Mon' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Mon' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Mon' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Monday
                                    </option>
                                    <option value="Tuesday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Tue' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Tue' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Tue' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Tue' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Tuesday
                                    </option>
                                    <option value="Wednesday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Wed' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Wed' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Wed' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Wed' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Wednesday
                                    </option>
                                    <option value="Thursday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Thu' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Thu' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Thu' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Thu' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Thursday
                                    </option>
                                    <option value="Friday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Fri' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Fri' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Fri' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Fri' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Friday
                                    </option>
                                    <option value="Saturday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Sat' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Sat' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Sat' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Sat' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Saturday
                                    </option>
                                    <option value="Sunday"
                                            {{(substr($agency->hari_kerja,9,3) == 'Sun' && (substr($agency->hari_kerja,0,3) == 'Mon' || substr($agency->hari_kerja,0,3) == 'Fri' || substr($agency->hari_kerja,0,3) == 'Sun')) || (substr($agency->hari_kerja,11,3) == 'Sun' && (substr($agency->hari_kerja,0,3) == 'Thu' || substr($agency->hari_kerja,0,3) == 'Sat')) || (substr($agency->hari_kerja,12,3) == 'Sun' && substr($agency->hari_kerja,0,3) == 'Wed') || (substr($agency->hari_kerja,10,3) == 'Sun' && substr($agency->hari_kerja,0,3) == 'Tue') ? 'selected' : ''}}>
                                        Sunday
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <small>Working Hours</small>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <small>Start Time</small>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>
                                <input class="form-control timepicker" name="start_time"
                                       type="text" placeholder="08:00" value="{{$agency->jam_kerja != "" ?
                                       substr($agency->jam_kerja,0,5) : ''}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <small>End Time</small>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hourglass-end"></i></span>
                                <input class="form-control timepicker" name="end_time"
                                       type="text" placeholder="16:00" value="{{$agency->jam_kerja != "" ?
                                       substr($agency->jam_kerja,8,5) : ''}}" required>
                            </div>
                        </div>
                    </div>

                    <small>Phone<span class="optional-label">(Optional)</span></small>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input placeholder="08123xxxxxxx"
                                       type="text" maxlength="13"
                                       class="form-control" name="phone"
                                       onkeypress="return numberOnly(event, false)"
                                       value="{{$agency->phone != "" ? $agency->phone : ''}}">
                            </div>
                        </div>
                    </div>

                    <small>Website<span class="optional-label">(Optional)</span></small>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <input class="form-control" name="link" type="text"
                                       placeholder="http://example.com"
                                       value="{{$agency->link == "" ? '' : $agency->link}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(\Illuminate\Support\Facades\Request::is('account/agency/profile'))
            <div class="card-read-more">
                <button class="btn btn-link btn-block" data-placement="top"
                        data-toggle="tooltip"
                        title="Click here to submit your changes!" id="btn_save_personal_data"
                        disabled>
                    <i class="fa fa-user-tie"></i>&nbsp;SAVE CHANGES
                </button>
            </div>
        @endif
    </form>
</div>
