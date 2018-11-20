<form class="form-horizontal to-animate-2" role="form" method="POST" id="form-ava"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="card">
        <div class="img-card image-upload">
            <label for="file-input">
                @if($user->ava==null)
                    <img style="width: 100%" class="show_ava" alt="AVA is here..."
                         src="{{asset('images/avatar.png')}}"
                         data-placement="bottom" data-toggle="tooltip"
                         title="Click here to change your AVA!">
                @elseif($user->ava=='seeker.png')
                    <img style="width: 100%" class="show_ava" alt="AVA is here..."
                         src="{{asset('images/seeker.png')}}"
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
                <div class="progress-bar progress-bar-danger progress-bar-striped active"
                     role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="card-title text-center">
                <a href="{{route('seeker.edit.profile')}}">
                    <h4 class="aj_name" style="color: #872f2f">{{$user->name}}</h4></a>
                <small>
                    @if(count($job_title->get()) != 0)
                        {{$job_title->first()->job_title}}
                    @else
                        Current Job Title (-)
                    @endif
                </small>
            </div>
            <div class="card-title">
                <table class="stats">
                    <tr>
                        <td><i class="fa fa-hand-holding-usd"></i></td>
                        <td>&nbsp;</td>
                        <td style="text-transform: none" id="expected_salary">
                            @if($seeker->lowest_salary != "")
                                <script>
                                    var low = ("{{$seeker->lowest_salary}}").split(',').join("") / 1000000,
                                        high = ("{{$seeker->highest_salary}}").split(',').join("") / 1000000;
                                    document.getElementById("expected_salary").innerText =
                                        "IDR " + low + " to " + high + " millions";
                                </script>
                            @else
                                Expected Salary (Anything)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-briefcase"></i></td>
                        <td>&nbsp;</td>
                        <td style="text-transform: none">
                            Total Exp: {{$seeker->total_exp != "" ? $seeker->total_exp.' years' : '0 year'}}
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-graduation-cap"></i></td>
                        <td>&nbsp;</td>
                        <td>
                            @if(count($last_edu->get()) != 0)
                                {{\App\Tingkatpend::find($last_edu->first()->tingkatpend_id)->name}}
                            @else
                                Latest Education Degree (-)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-user-graduate"></i></td>
                        <td>&nbsp;</td>
                        <td>
                            @if(count($last_edu->get()) != 0)
                                {{\App\Jurusanpend::find($last_edu->first()->jurusanpend_id)->name}}
                            @else
                                Latest Education Major (-)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-grin-stars"></i></td>
                        <td>&nbsp;</td>
                        <td>
                            @if(count($last_edu->get()) != 0 && $last_edu->first()->nilai != "")
                                {{$last_edu->first()->nilai}}
                            @else
                                Latest GPA (-)
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
                <table class="stats" style="font-size: 14px">
                    <tr>
                        <td><i class="fa fa-calendar-check"></i></td>
                        <td>&nbsp;Member Since</td>
                        <td>
                            : {{$seeker->created_at->format('j F Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-clock"></i></td>
                        <td>&nbsp;Last Update</td>
                        <td>
                            : {{$seeker->updated_at->diffForHumans()}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>
