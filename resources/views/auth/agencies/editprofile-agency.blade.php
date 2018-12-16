@section('title', 'Edit Profile | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 to-animate">
                            <div class="card">
                                <div class="img-card">
                                    <div id="map"></div>
                                </div>
                                <form action="{{route('agency.update.profile')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="check_form" value="address">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_address_settings">
                                                Agency Address
                                                <span class="pull-right" style="color: #00ADB5;cursor: pointer">
                                                    <i class="fa fa-edit"></i>&nbsp;Edit</span>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote id="stats_address" style="text-transform: none">
                                                <table style="font-size: 14px; margin-top: 0">
                                                    <tr>
                                                        <td><i class="fa fa-map-marker-alt"></i></td>
                                                        <td>
                                                            &nbsp;{{$agency->alamat != "" ? $agency->alamat : ''}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </blockquote>
                                            <div id="address_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-map-marker-alt"></i>
                                                                    </span>
                                                            <textarea style="resize:vertical" name="alamat"
                                                                      id="address_map"
                                                                      placeholder="Agency address"
                                                                      class="form-control"
                                                                      required>{{$agency->alamat == "" ? '' : $agency->alamat}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button class="btn btn-link btn-block" data-placement="top"
                                                data-toggle="tooltip" title="Click here to submit your changes!"
                                                id="btn_save_address" disabled>
                                            <i class="fa fa-map-marker-alt"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 text-center">@include('layouts.partials.auth.Agencies._form_ava-agency')</div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 to-animate">
                            <div class="card">
                                <div class="img-card stats_gallery">
                                    <div id="carousel-example" class="carousel slide carousel-fullscreen carousel-fade"
                                         data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @php $i = 0; @endphp
                                            @foreach($galleries as $row)
                                                <li data-target="#carousel-example" data-slide-to="{{$i++}}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach($galleries as $row)
                                                @if($row->image == 'c1.jpg' || $row->image == 'c2.jpg'
                                                || $row->image == 'c3.jpg')
                                                    <div class="item" style="background-image: url({{asset
                                                    ('images/carousel/'.$row->image)}});">
                                                        <div class="carousel-overlay"></div>
                                                    </div>
                                                @else
                                                    <div class="item" style="background-image: url({{asset
                                                    ('storage/users/agencies/galleries/'.$row->image)}});">
                                                        <div class="carousel-overlay"></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-example" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-title">
                                        <small id="show_gallery_settings">
                                            Background Profile
                                            <span class="pull-right" style="color: #00ADB5;cursor: pointer">
                                                    <i class="fa fa-edit"></i>&nbsp;Edit</span>
                                        </small>
                                        <hr class="hr-divider">
                                        @if(count($galleries) == 0)
                                            <blockquote class="stats_gallery" style="text-transform: none">
                                                <p align="justify">
                                                    Upload some pictures to update your background profile.
                                                    Allowed extension: jpg, jpeg, gif, png.
                                                    Allowed size: < 5 MB.</p>
                                            </blockquote>
                                        @else
                                            <form action="{{route('agency.delete.gallery')}}"
                                                  id="form-delete-gallery">
                                                <ul class="stats_gallery myCheckbox" id="gallery_list">
                                                    <li><input type="checkbox" class="gallery_cb"
                                                               id="selectAll">{{count($galleries) > 1 ?
                                                               'Select '.count($galleries).' files' :
                                                               'Select '.count($galleries).' file'}}</li>
                                                    <div data-scrollbar style="max-height: 124px">
                                                    @foreach($galleries as $row)
                                                        <li><input type="checkbox" name="gallery_cbs[]"
                                                                   class="gallery_cb" value="{{$row->id}}">
                                                            {{\Illuminate\Support\Str::words($row->image,4,'...')}}</li>
                                                        <input type="hidden" name="gallery_image[]"
                                                               value="{{$row->image}}">
                                                    @endforeach
                                                    </div>
                                                </ul>
                                            </form>
                                        @endif
                                        <form action="{{route('create.galleries')}}" method="post"
                                              enctype="multipart/form-data" id="form-create-gallery">
                                            {{csrf_field()}}
                                            <div id="gallery_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <input type="file" name="galleries[]" style="display: none;"
                                                               accept="image/*" id="gallery-files" required multiple>
                                                        <div class="input-group">
                                                            <input type="text" id="txt_gallery"
                                                                   class="browse_files form-control"
                                                                   placeholder="Upload file here..." readonly
                                                                   style="cursor: pointer"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 5 MB">
                                                            <span class="input-group-btn">
                                                                <button class="browse_files btn btn-info" type="button">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <span class="help-block">
                                                            <small id="count_files"></small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-read-more" id="btn_gallery" style="display: none">
                                    <button class="btn btn-link btn-block" data-placement="top"
                                            data-toggle="tooltip" title="Click here to submit your changes!"
                                            id="btn_save_gallery">
                                        <i class="fa fa-images"></i>&nbsp;SAVE CHANGES
                                    </button>
                                </div>
                                @if(count($galleries) != 0)
                                    <div class="card-read-more" id="btn_delete_gallery">
                                        <button class="btn btn-link btn-block" data-placement="top"
                                                data-toggle="tooltip" disabled
                                                title="Click here to delete all selected files!">
                                            <i class="fa fa-trash"></i>&nbsp;DELETE SELECTED FILES
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 to-animate">
                            <div class="card">
                                <form action="{{route('agency.update.profile')}}" method="post" id="form-about">
                                    {{csrf_field()}}
                                    <input type="hidden" name="check_form" value="about">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_agency_about_settings">
                                                About The Agency
                                                <span class="pull-right" style="color: #00ADB5;cursor: pointer">
                                                    <i class="fa fa-edit"></i>&nbsp;Edit</span>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote id="stats_agency_about" data-scrollbar
                                                        style="max-height: 300px">
                                                {!! $agency->tentang != "" ? $agency->tentang : '' !!}
                                                <small>{{$agency->alasan != "" ? 'Why Choose Us?' : ''}}</small>
                                                {!! $agency->alasan != "" ? $agency->alasan : '' !!}
                                            </blockquote>

                                            <div id="agency_about_settings" style="display: none">
                                                <small>About Us</small>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <textarea class="form-control" name="tentang" id="tentang"
                                                                  placeholder="Brief history or some short description about your agency">{{$agency->tentang == "" ? '' : $agency->tentang}}</textarea>
                                                    </div>
                                                </div>

                                                <small>Why Choose Us</small>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <textarea class="form-control" name="alasan" id="alasan"
                                                                  placeholder="Tell us why should choose your agency...">{{$agency->alasan == "" ? '' : $agency->alasan}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button class="btn btn-link btn-block" data-placement="bottom"
                                                data-toggle="tooltip"
                                                title="Click here to submit your changes!" id="btn_save_agency_about"
                                                disabled>
                                            <i class="fa fa-building"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        // gmaps address agency
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng('{{$agency->lat}}', '{{$agency->long}}');

            var mapOptions = {
                zoom: 15,
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
                icon: '{{asset('images/pin-agency.png')}}',
                anchorPoint: new google.maps.Point(0, -29)
            });

            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });

            // styling infoWindow
            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = $('.gm-style-iw');
                var iwBackground = iwOuter.prev();

                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                iwOuter.css({left: '25px', top: '15px'});
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
                    background: '#fff',
                    opacity: '1',
                    width: '30px',
                    height: '30px',
                    right: '15px',
                    top: '6px',
                    border: '6px solid #48b5e9',
                    'border-radius': '50%',
                    'box-shadow': '0 0 5px #3990B9'
                });

                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });

            // autoComplete
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address_map'));

            autocomplete.bindTo('bounds', map);

            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                var markerSearch = new google.maps.Marker({
                    map: map,
                    icon: '{{asset('images/pin-agency.png')}}',
                    anchorPoint: new google.maps.Point(0, -29)
                });
                markerSearch.setPosition(place.geometry.location);
                markerSearch.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                var contentSearch =
                    '<div id="iw-container">' +
                    '<div class="iw-title">{{$user->name}} <sub>New Address</sub></div>' +
                    '<div class="iw-content">' +
                    '<div class="iw-subTitle">' + place.name + '</div>' +
                    '<img src="{{asset('images/searchPlace.png')}}">' +
                    '<p>' + address + '</p>' +
                    '</div><div class="iw-bottom-gradient"></div></div>';

                var infowindowSearch = new google.maps.InfoWindow({
                    content: contentSearch,
                    maxWidth: 350
                });
                infowindowSearch.open(map, markerSearch);

                markerSearch.addListener('click', function () {
                    infowindowSearch.open(map, markerSearch);
                });

                google.maps.event.addListener(map, 'click', function () {
                    infowindowSearch.close();
                });

                // styling infoWindowSearch
                google.maps.event.addListener(infowindowSearch, 'domready', function () {
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
            });
        }

        google.maps.event.addDomListener(window, 'load', init);

        $(document).ready(function () {
            tinymce.init({
                branding: false,
                path_absolute: '{{url('/')}}',
                selector: '#tentang',
                height: 300,
                themes: 'modern',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code',
                    'insertdatetime media table contextmenu paste code help wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                relative_urls: false,
                file_browser_callback: function (field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth ||
                        document.getElementsByTagName('body')[0].clientWidth,
                        y = window.innerHeight || document.documentElement.clientHeight ||
                            document.getElementsByTagName('body')[0].clientHeight,
                        cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + '&type=Images';
                    } else {
                        cmsURL = cmsURL + '&type=Files';
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'File Manager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: 'yes',
                        close_previous: 'no'
                    });
                }
            });
            tinymce.init({
                branding: false,
                path_absolute: '{{url('/')}}',
                selector: '#alasan',
                height: 300,
                themes: 'modern',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code',
                    'insertdatetime media table contextmenu paste code help wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                relative_urls: false,
                file_browser_callback: function (field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth ||
                        document.getElementsByTagName('body')[0].clientWidth,
                        y = window.innerHeight || document.documentElement.clientHeight ||
                            document.getElementsByTagName('body')[0].clientHeight,
                        cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + '&type=Images';
                    } else {
                        cmsURL = cmsURL + '&type=Files';
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'File Manager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: 'yes',
                        close_previous: 'no'
                    });
                }
            });
        });
    </script>
    @include('layouts.partials.auth.Agencies._scripts_auth-agency')
    @include('layouts.partials.auth.Agencies._scripts_ajax-agency')
@endpush
