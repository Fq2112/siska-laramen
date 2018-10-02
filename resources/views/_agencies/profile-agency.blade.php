@extends('layouts.mst_user')
@section('title', ''.$user->name.'\'s Profile | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myProfile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 2.9em">
        <div class="fh5co-services">
            <div class="container to-animate" style="width: 100%;padding: 0;">
                <header id="header">
                    <div class="slider">
                        <div id="carousel-example" class="carousel slide carousel-fullscreen"
                             data-ride="carousel">
                            <div class="carousel-inner">
                                @if(\App\Gallery::where('agency_id',$agency->id)->count())
                                    @foreach(\App\Gallery::where('agency_id',$agency->id)->get() as $row)
                                        @if($row->image == 'c1.jpg'||$row->image == 'c2.jpg'|| $row->image == 'c3.jpg')
                                            <div class="item" style="background-image: url({{
                                                 asset('images/carousel/'.$row->image)}});">
                                                <div class="carousel-overlay"></div>
                                            </div>
                                        @else
                                            <div class="item" style="background-image: url({{
                                                 asset('storage/users/agencies/galleries/'.$row->image)}});">
                                                <div class="carousel-overlay"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="item"
                                         style="background-image: url({{asset('images/carousel/c0.png')}})">
                                        <div class="carousel-overlay"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <nav class="profilebar navbar-default">
                        <div class="profilebar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#mainNav">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="profilebar-brand" style="cursor: pointer">
                                @if($user->ava == ""||$user->ava == "agency.png")
                                    <img class="img-responsive" src="{{asset('images/agency.png')}}">
                                @else
                                    <img class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}">
                                @endif
                            </a>
                            <span class="site-name">{{$user->name}}</span>
                            <span class="site-description">{{$agency->alamat}}</span>
                        </div>
                        <div class="collapse navbar-collapse" id="mainNav">
                            <ul class="nav main-menu navbar-nav to-animate">
                                <li data-placement="left" data-toggle="tooltip" title="Headquarter"><a>
                                        <i class="fa fa-building"></i>&ensp;{{$agency->kantor_pusat}}</a></li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Industry"><a>
                                        <i class="fa fa-industry"></i>&ensp;{{is_null($agency->industri_id) ? 'Unknown' : $industry->name}}
                                    </a></li>
                                <li data-placement="bottom" data-toggle="tooltip" title="Working Days"><a>
                                        <i class="fa fa-calendar"></i>&ensp;{{$agency->hari_kerja}}</a></li>
                                <li data-placement="right" data-toggle="tooltip" title="Working Hours"><a>
                                        <i class="fa fa-clock"></i>&ensp;{{$agency->jam_kerja}}</a></li>
                            </ul>
                            <ul class="nav to-animate-2 navbar-nav navbar-right">
                                @auth
                                    @if(Auth::user()->isAgency() && Auth::user()->id == $agency->user_id)
                                        <li class="ld ld-breath" id="btn_edit">
                                            <a href="{{route('agency.edit.profile')}}" class="btn btn-info btn-block">
                                                <i class="fa fa-user-edit"></i>&ensp;<strong>Edit</strong>
                                            </a>
                                        </li>
                                    @else
                                        <li id="fav-agency">
                                            <form method="post" action="{{route('favorite.agency')}}"
                                                  id="form-favorite">
                                                {{csrf_field()}}
                                                @if($likes > 0)
                                                    <small><strong>{{$likes}} {{$likes > 1 ? 'likes' : 'like'}}</strong>
                                                    </small>
                                                @endif
                                                <div class="anim-icon anim-icon-md heart ld ld-heartbeat">
                                                    <input type="hidden" name="agency_id" value="{{$agency->id}}">
                                                    <input type="checkbox" id="favorite">
                                                    <label for="favorite" data-placement="top" data-toggle="tooltip">
                                                    </label>
                                                </div>
                                            </form>
                                        </li>
                                    @endif
                                @else
                                    <li id="fav-agency">
                                        <form method="post" action="{{route('favorite.agency')}}" id="form-favorite">
                                            {{csrf_field()}}
                                            @if($likes > 0)
                                                <small><strong>{{$likes}} {{$likes > 1 ? 'likes' : 'like'}}</strong>
                                                </small>
                                            @endif
                                            <div class="anim-icon anim-icon-md heart ld ld-heartbeat">
                                                <input type="hidden" name="agency_id" value="{{$agency->id}}">
                                                <input type="checkbox" id="favorite">
                                                <label for="favorite" data-placement="top"
                                                       data-toggle="tooltip"></label>
                                            </div>
                                        </form>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </nav>
                </header>

                <div class="row to-animate detail">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="img-card" id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>
                                                About The Agency
                                                <span class="pull-right" style="color: #FA5555">
                                                        Last Update: {{$agency->updated_at->diffForHumans()}}</span>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote>
                                                {!! $agency->tentang != "" ? $agency->tentang : '' !!}
                                                <small>{{$agency->alasan != "" ? 'Why Choose Us?' : ''}}</small>
                                                {!! $agency->alasan != "" ? $agency->alasan : '' !!}
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <a class="btn btn-link btn-block" href="{{$agency->link}}" target="_blank">
                                            <i class="fa fa-globe"></i>&ensp;More info {{$user->name}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Vacancies in {{$user->name}}</small>
                                            <hr class="hr-divider">
                                            @foreach($vacancies as $row)
                                                @php
                                                    $city = \App\Cities::find($row->cities_id)->name;
                                                    $salary = \App\Salaries::find($row->salary_id);
                                                    $jobfunc = \App\FungsiKerja::find($row->fungsikerja_id);
                                                    $joblevel = \App\JobLevel::find($row->joblevel_id);
                                                    $industry = \App\Industri::find($row->industry_id);
                                                    $degrees = \App\Tingkatpend::find($row->tingkatpend_id);
                                                    $majors = \App\Jurusanpend::find($row->jurusanpend_id);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <small class="media-heading">
                                                                    <a href="{{route('detail.vacancy',['id'=>$row->id])}}">
                                                                        {{$row->judul}}</a>
                                                                    <sub style="color: #fa5555;text-transform: none">&ndash; {{$row->updated_at
                                                                    ->diffForHumans()}}</sub>
                                                                </small>
                                                                <blockquote style="font-size: 12px;color: #7f7f7f"
                                                                            class="ulTinyMCE">
                                                                    <ul class="list-inline">
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['loc' => substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)])}}">
                                                                                <i class="fa fa-map-marked"></i>&ensp;
                                                                                {{substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)}}
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['jobfunc_ids' => $row->fungsikerja_id])}}">
                                                                                <i class="fa fa-warehouse"></i>&ensp;
                                                                                {{$jobfunc->nama}}
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['industry_ids' => $row->industry_id])}}">
                                                                                <i class="fa fa-industry"></i>&ensp;
                                                                                {{$industry->nama}}
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['salary_ids' => $salary->id])}}">
                                                                                <i class="fa fa-money-bill-wave"></i>
                                                                                &ensp;IDR {{$salary->name}}</a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['degrees_ids' => $row->tingkatpend_id])}}">
                                                                                <i class="fa fa-graduation-cap"></i>
                                                                                &ensp;{{$degrees->name}}</a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag" target="_blank"
                                                                               href="{{route('search.vacancy',['majors_ids' => $row->jurusanpend_id])}}">
                                                                                <i class="fa fa-user-graduate"></i>
                                                                                &ensp;{{$majors->name}}</a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="tag">
                                                                                <i class="fa fa-briefcase"></i>
                                                                                &ensp;At least {{$row->pengalaman > 1 ?
                                                                                $row->pengalaman.' years' :
                                                                                $row->pengalaman.' year'}}
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <small>Requirements</small>
                                                                    {!! $row->syarat !!}
                                                                    <small>Responsibilities</small>
                                                                    {!! $row->tanggungjawab !!}
                                                                    <hr>
                                                                    <table style="font-size: 12px;margin-top: -.5em">
                                                                        <tr>
                                                                            <td><i class="fa fa-comments"></i>
                                                                            </td>
                                                                            <td>&nbsp;Interview Date</td>
                                                                            <td>:
                                                                                {{$row->interview_date != "" ?
                                                                                \Carbon\Carbon::parse
                                                                                ($row->interview_date)
                                                                                ->format('l, j F Y') : '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><i class="fa fa-users"></i></td>
                                                                            <td>&nbsp;Recruitment Date</td>
                                                                            <td>:
                                                                                {{$row->recruitmentDate_start &&
                                                                                $row->recruitmentDate_end != "" ?
                                                                                \Carbon\Carbon::parse
                                                                                ($row->recruitmentDate_start)
                                                                                ->format('j F Y')." - ".
                                                                                \Carbon\Carbon::parse
                                                                                ($row->recruitmentDate_end)
                                                                                ->format('j F Y') : '-'}}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </blockquote>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="hr-divider">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade login" id="avaModal">
        <div class="modal-dialog login animated">
            @if($user->ava == ""||$user->ava == "agency.png")
                <img class="img-responsive" src="{{asset('images/agency.png')}}">
            @else
                <img class="img-responsive" src="{{asset('storage/users/'.$user->ava)}}">
            @endif
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68"></script>
    <script>
        // gmaps address agency
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng('{{$agency->lat}}', '{{$agency->long}}');

            var mapOptions = {
                zoom: 16,
                center: myLatlng,
                scrollwheel: true,
                styles: [{
                    "featureType": "administrative.land_parcel",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "landscape.man_made",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "on"}]}, {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}, {"lightness": 20}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{"hue": "#f49935"}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{"hue": "#fad959"}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "road.local",
                    "elementType": "labels",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"hue": "#a1cdfc"}, {"saturation": 30}, {"lightness": 49}]
                }]
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var contentString =
                '<div id="iw-container">' +
                '<div class="iw-title">{{$user->name}}</div>' +
                '<div class="iw-content">' +
                '<div class="iw-subTitle">About Us</div>' +
                '<img src="{{$user->ava == "" || $user->ava == "agency.png" ? asset('images/agency.png') :
                asset('storage/users/'.$user->ava)}}">' +
                '{!!$agency->tentang == "" ? '(empty)' : $agency->tentang!!}' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>{{$agency->alamat == "" ? '(empty)' : $agency->alamat}}<br>' +
                '<br>Phone: <a href="tel:{{$agency->phone == "" ? '' : $agency->phone}}">' +
                '{{$agency->phone == "" ? '-' : $agency->phone}}</a>' +
                '<br>E-mail: <a href="mailto:{{$user->email}}">{{$user->email}}</a>' +
                '<br>Website: <a href="{{$agency->link == "" ? '#' : $agency->link}}" target="_blank">' +
                '{{$agency->link == "" ? '-' : $agency->link}}</a>' +
                '</p></div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 350
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '{{asset('images/pin-agency.png')}}'
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });
            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = $('.gm-style-iw');
                var iwBackground = iwOuter.prev();

                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                iwOuter.parent().parent().css({left: '0'});

                iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').find('div').children().css({
                    'box-shadow': 'rgba(72, 181, 233, 0.6) 0 1px 6px',
                    'z-index': '1'
                });

                var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({
                    opacity: '1',
                    width: '25px',
                    height: '25px',
                    right: '20px',
                    top: '3px',
                    border: '6px solid #48b5e9',
                    'border-radius': '13px',
                    'box-shadow': '0 0 5px #3990B9'
                });

                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);


        // favorite agency
        var $btnFav = $("#fav-agency"), $tooltipFav = $("#fav-agency label");
        $tooltipFav.attr('title', 'Like');
        @auth
        @php
            $seeker = \App\Seekers::where('user_id',Auth::user()->id)->first();
            $fav = App\FavoriteAgency::where('user_id',Auth::user()->id)->where('agency_id',$agency->id);
        @endphp
        @if(count($fav->get()))
        @if($fav->first()->isFavorite == true)
        $("#favorite").prop('checked', true);
        $("#fav-agency .anim-icon").removeClass('ld ld-heartbeat');
        $tooltipFav.attr('title', 'Dislike');
        @endif
        @endif
        @endauth

        $("#favorite").click(function () {
            $("#fav-agency .bookmark").toggleClass('ld ld-heartbeat');
            @auth
            @if(Auth::user()->isAgency())
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Seeker.',
                type: 'warning',
                timer: '3500'
            });
            $("#favorite").prop('checked', false);
            @else
            $("#form-favorite")[0].submit();
            @endif
            @else
            $(this).prop('checked', false);
            @if(Auth::guard('admin')->check())
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Seeker.',
                type: 'warning',
                timer: '3500'
            });
            @else
            openLoginModal();
            @endif
            @endauth
        });

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $(".profilebar-brand img").click(function () {
            $("#avaModal").modal('show');
        });
    </script>
@endpush