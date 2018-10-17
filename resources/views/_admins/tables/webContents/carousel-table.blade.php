@extends('layouts.mst_admin')
@section('title', 'Carousels Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Carousels
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createCarousel()" data-toggle="tooltip" title="Create"
                                   data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Title / Captions</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($carousels as $carousel)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <img class="img-responsive" width="100" alt="{{$carousel->image}}"
                                             src="{{asset('images/carousel/'.$carousel->image)}}">
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$carousel->title}}</strong><br>{{$carousel->captions}}
                                    </td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($carousel->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$carousel->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editCarousel("{{$carousel->id}}","{{$carousel->image}}",
                                                "{{$carousel->title}}","{{$carousel->captions}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.carousels',['id'=>encrypt($carousel->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="right"><i class="fa fa-trash-alt"></i></a>
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
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.carousels')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="image">Image <span class="required">*</span></label>
                                <input type="file" name="image" style="display: none;" accept="image/*" id="image"
                                       required>
                                <div class="input-group">
                                    <input type="text" id="txt_image"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                           title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="title">Title <span class="required">*</span></label>
                                <input id="title" type="text" class="form-control" maxlength="191" name="title"
                                       placeholder="Carousel title" required>
                                <span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="captions">Captions <span class="required">*</span></label>
                                <input id="captions" type="text" class="form-control" maxlength="191" name="captions"
                                       placeholder="Carousel captions" required>
                                <span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>
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
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Form</h4>
                </div>
                <div id="editModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createCarousel() {
            $("#createModal").modal('show');
        }

        function editCarousel(id, image, title, captions) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" enctype="multipart/form-data" ' +
                'action="{{url('admin/tables/web_contents/carousels')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<img style="margin: 0 auto;width: 50%;cursor:pointer" class="img-responsive" id="btn_img' + id + '" ' +
                'src="{{asset('images/carousel/')}}/' + image + '" data-toggle="tooltip" data-placement="bottom" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">' +
                '<label for="image' + id + '">Image <span class="required">*</span></label>' +
                '<input type="file" name="image" style="display: none;" accept="image/*" id="image' + id + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_image' + id + '" class="browse_files form-control" value="' + image + '" ' +
                'readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="title' + id + '">Title <span class="required">*</span></label>' +
                '<input id="title' + id + '" type="text" class="form-control" maxlength="191" name="title"' +
                'value="' + title + '" required>' +
                '<span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="captions' + id + '">Captions <span class="required">*</span></label>' +
                '<input id="captions' + id + '" type="text" class="form-control" maxlength="191" name="captions"' +
                'value="' + captions + '" required>' +
                '<span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            $("#editModal").modal('show');
            $(".browse_files").on('click', function () {
                $("#image" + id).trigger('click');
            });
            $("#btn_img" + id).on('click', function () {
                $("#image" + id).trigger('click');
            });

            $("#image" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_image" + id);
                txt.val(names);
                $("#txt_image" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $(".browse_files").on('click', function () {
            $("#image").trigger('click');
        });

        $("#image").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_image");
            txt.val(names);
            $("#txt_image[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });
    </script>
@endpush