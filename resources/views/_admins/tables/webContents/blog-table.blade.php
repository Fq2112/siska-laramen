@extends('layouts.mst_admin')
@section('title', 'Blog Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Blog
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createBlog()" data-toggle="tooltip" title="Create"
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
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($blogs as $blog)
                                @php $type = \App\Jenisblog::find($blog->jenisblog_id); @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr style="border-bottom: 1px solid #eee">
                                                <td style="vertical-align: middle">
                                                    <img class="img-responsive" width="100" alt="{{$blog->dir}}"
                                                         style="float: left;margin-right: .5em;margin-bottom: .5em"
                                                         src="{{asset('images/blog/'.$blog->dir)}}">
                                                    <strong>{{$blog->judul}}</strong><br>{{$blog->subjudul}}<br>
                                                    Blog Type: <span class="label label-success"
                                                                     style="text-transform: uppercase">
                                                        {{$type->nama}}</span>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #eee">
                                                <td style="vertical-align: middle">{!! $blog->konten !!}</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle">
                                                    Author: <span class="label label-primary">{{$blog->uploder}}</span>&nbsp;&ndash;
                                                    <i class="fa fa-clock"></i> {{$blog->updated_at->diffForHumans()}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick="editBlog('{{$blog->id}}','{{$blog->dir}}','{{$blog->judul}}',
                                                '{{$blog->subjudul}}','{{$blog->konten}}',
                                                '{{$blog->jenisblog_id}}','{{$blog->uploder}}')"
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="top"><i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{route('delete.blog',['id'=>encrypt($blog->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="bottom"><i class="fa fa-trash-alt"></i></a>
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
                <form method="post" action="{{route('create.blog')}}" enctype="multipart/form-data"
                      id="form-create-blog">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="dir">Image <span class="required">*</span></label>
                                <input type="file" name="dir" style="display: none;" accept="image/*" id="dir"
                                       required>
                                <div class="input-group">
                                    <input type="text" id="txt_dir"
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
                                <input id="title" type="text" class="form-control" maxlength="100" name="judul"
                                       placeholder="Blog title" required>
                                <span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="captions">Subtitle <span class="required">*</span></label>
                                <input id="captions" type="text" class="form-control" maxlength="100" name="subjudul"
                                       placeholder="Blog subtitle" required>
                                <span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="blogType">Blog Type <span class="required">*</span></label>
                                <select id="blogType" class="form-control" name="jenisblog_id" required>
                                    <option value="">-- Choose --</option>
                                    @foreach(\App\Jenisblog::all() as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-newspaper form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="author">Author <span class="required">*</span></label>
                                <input id="author" type="text" class="form-control" maxlength="100" name="uploader"
                                       placeholder="Author name" value="{{Auth::guard('admin')->user()->name}}"
                                       required>
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="konten">Content <span class="required">*</span></label>
                                <textarea name="konten" id="konten"></textarea>
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
        function createBlog() {
            $("#createModal").modal('show');
        }

        function editBlog(id, dir, judul, subjudul, konten, jenisblog, author) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" enctype="multipart/form-data" ' +
                'action="{{url('admin/tables/web_contents/blog')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<img style="margin: 0 auto;width: 50%" class="img-responsive" ' +
                'src="{{asset('images/blog/')}}/' + dir + '">' +
                '<label for="dir' + id + '">Image <span class="required">*</span></label>' +
                '<input type="file" name="dir" style="display: none;" accept="image/*" id="dir' + id + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_dir' + id + '" class="browse_files form-control" value="' + dir + '" ' +
                'readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="judul' + id + '">Title <span class="required">*</span></label>' +
                '<input id="judul' + id + '" type="text" class="form-control" maxlength="100" name="judul"' +
                'value="' + judul + '" required>' +
                '<span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="subjudul' + id + '">Subtitle <span class="required">*</span></label>' +
                '<input id="subjudul' + id + '" type="text" class="form-control" maxlength="100" name="subjudul"' +
                'value="' + subjudul + '" required>' +
                '<span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="blogType' + id + '">Title <span class="required">*</span></label>' +
                '<select id="blogType' + id + '" class="form-control" name="jenisblog_id" required></select>' +
                '<span class="fa fa-newspaper form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="author' + id + '">Author <span class="required">*</span></label>' +
                '<input id="author' + id + '" type="text" class="form-control" maxlength="100" name="uploader"' +
                'value="' + author + '" required>' +
                '<span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<label for="konten' + id + '">Content <span class="required">*</span></label>' +
                '<textarea class="form-control" rows="5" name="konten" id="konten' + id + '">' + konten + '</textarea>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );

            $.get('/api/clients/blog/types', function (data) {
                var $attr, $result = '';
                $.each(data, function (i, val) {
                    $attr = val.id == jenisblog ? 'selected' : '';
                    $result += '<option value="' + val.id + '" ' + $attr + '>' + val.nama + '</option>';
                });
                $("#blogType" + id).empty().append($result);
            });

            tinymce.init({
                branding: false,
                path_absolute: '{{url('/')}}',
                selector: '#konten' + id,
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
            tinyMCE.get('konten' + id).setContent(konten);

            $("#editModal").modal('show');

            $(".browse_files").on('click', function () {
                $("#dir" + id).trigger('click');
            });

            $("#dir" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_dir" + id);
                txt.val(names);
                $("#txt_dir" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $(".browse_files").on('click', function () {
            $("#dir").trigger('click');
        });

        $("#dir").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_dir");
            txt.val(names);
            $("#txt_dir[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });

        tinymce.init({
            branding: false,
            path_absolute: '{{url('/')}}',
            selector: '#konten',
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

        $("#form-create-blog").on('submit', function (e) {
            e.preventDefault();
            if (tinyMCE.get('konten').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Content field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush