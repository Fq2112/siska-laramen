@section('title', 'Edit Profile | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 to-animate">
                            <div class="card">
                                <div class="img-card">
                                    <form role="form" method="POST" id="form-background" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('put') }}
                                        <div class="slider image-upload" data-toggle="tooltip" data-placement="bottom"
                                             title="Click here to change your profile background!">
                                            <label for="input-background">
                                                <div id="carousel-example" class="carousel slide carousel-fullscreen"
                                                     data-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @if($seeker->background != null)
                                                            <div class="item show_background"
                                                                 style="background-image: url({{asset('storage/users/seekers/background/'.$seeker->background)}});">
                                                                <div class="carousel-overlay"></div>
                                                            </div>
                                                        @else
                                                            <div class="item show_background"
                                                                 style="background-image: url({{asset('images/carousel/c0.png')}});">
                                                                <div class="carousel-overlay"></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                            <input id="input-background" name="background" type="file" accept="image/*">
                                            <div id="progress-upload">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                                     role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-content">
                                    <div class="card-title">
                                        <small id="show_background_settings">
                                            Profile Background
                                            <span class="pull-right" style="cursor: pointer; color: #fa5555">
                                                <i class="fa fa-edit"></i>&nbsp;EDIT</span>
                                        </small>
                                        <hr class="hr-divider">
                                        <blockquote style="text-transform: none">
                                            <table style="font-size: 14px; margin-top: 0">
                                                <tr>
                                                    <td><i class="fa fa-image"></i></td>
                                                    <td>
                                                        &nbsp;{{$seeker->background != "" ? $seeker->background : '(empty)'}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 text-center">
                    {{--AVA--}}
                    <div class="row">
                        <div class="col-lg-12">
                            @include('layouts.partials.auth.Seekers._form_ava')
                        </div>
                    </div>
                    {{--Video Summary--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" enctype="multipart/form-data"
                                      method="post" id="form-video-summary">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <input type="hidden" name="check_form" value="video_summary"
                                           id="input_video">
                                    <div class="img-card stats_video">
                                        @if($seeker->video_summary != "")
                                            <video class="aj_video" style="width: 100%;height: auto"
                                                   src="{{asset('storage/users/seekers/video/'.$seeker->video_summary)}}"
                                                   controls></video>
                                        @else
                                            <video class="aj_video" style="width: 100%;height: auto"
                                                   src="{{asset('images/vid-placeholder.mp4')}}"></video>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_video_settings">
                                                Video Summary
                                                <span class="optional-label">(Optional)</span>
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i class="fa fa-edit"></i>&nbsp;EDIT
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div style="font-size: 14px; margin-top: 0"
                                                 class="stats_video">
                                                <p align="justify" class="aj_video_name">
                                                    @if($seeker->video_summary != "")
                                                        Filename: {{$seeker->video_summary}}
                                                    @else
                                                        Video that describes You. Allowed extension:
                                                        mp4, webm, and ogg. Allowed size: < 30 MB.
                                                        <br><br>
                                                    @endif
                                                </p>
                                            </div>
                                            <div id="video_settings" style="display: none">
                                                <div class="row form-group has-feedback">
                                                    <div class="col-md-12">
                                                        <label for="attach-video" id="video-label">
                                                            <i id="remove-video" class="close">x</i>
                                                            <div class="filename" id="attached-video"
                                                                 data-toggle="tooltip" data-placement="top"
                                                                 title="Allowed extension: mp4, webm, and ogg. Allowed size: < 30 MB">
                                                                @if($seeker->video_summary != "")
                                                                    {{$seeker->video_summary}}
                                                                @else
                                                                    Select a file or drag here
                                                                @endif
                                                            </div>
                                                        </label>
                                                        <input id="attach-video" type="file"
                                                               accept="video/*" name="video_summary">
                                                        <div id="progress-upload-video"
                                                             style="border-radius: 4px">
                                                            <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                                                 role="progressbar" aria-valuenow="0"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more" id="div_delVid">
                                        @if($seeker->video_summary != "")
                                            <a class="btn btn-link btn-block" id="btn_delete_video">
                                                <i class="fa fa-eraser"></i>&nbsp;DELETE VIDEO
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Attachments--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small id="show_attachments_settings">
                                            Attachments
                                            <span class="pull-right"
                                                  style="cursor: pointer; color: #FA5555"><i class="fa fa-archive"></i>&ensp;Add</span>
                                        </small>
                                        <hr class="hr-divider">
                                        <div id="stats_attachments" style="font-size: 14px; margin-top: 0">
                                            @if(count($attachments) != 0)
                                                <form action="{{route('delete.attachments')}}"
                                                      id="form-delete-attachments">
                                                    <ul class="myCheckbox" id="attachments_list">
                                                        <li><input type="checkbox" class="attachments_cb"
                                                                   id="selectAll">{{count($attachments) > 1 ?
                                                               'Select '.count($attachments).' files' :
                                                               'Select '.count($attachments).' file'}}</li>
                                                        @foreach($attachments as $row)
                                                            <li><input type="checkbox" name="attachments_cbs[]"
                                                                       class="attachments_cb"
                                                                       value="{{$row->id}}">{{$row->files}}</li>
                                                            <input type="hidden" name="attachments[]"
                                                                   value="{{$row->image}}">
                                                        @endforeach
                                                    </ul>
                                                </form>
                                            @else
                                                <p align="justify">
                                                    Upload your personal CV, Certification, etc.
                                                    Allowed extension: jpg, jpeg, gif, png, pdf,
                                                    doc, docx, xls, xlsx, odt, ppt, pptx. Allowed
                                                    size: < 5 MB.</p>
                                            @endif
                                        </div>

                                        <form class="form-horizontal" role="form" method="POST"
                                              enctype="multipart/form-data" id="form-attachments"
                                              action="{{route('create.attachments')}}">
                                            {{ csrf_field() }}
                                            <div id="attachments_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <input type="file" name="attachments[]"
                                                               style="display: none;" accept="image/*,.pdf,
                                                    .doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"
                                                               id="attach-files" required multiple>
                                                        <div class="input-group">
                                                            <input type="text" id="txt_attach"
                                                                   class="browse_files form-control"
                                                                   placeholder="Upload file here..."
                                                                   readonly style="cursor: pointer"
                                                                   data-toggle="tooltip"
                                                                   data-placement="top"
                                                                   title="Allowed extension: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Allowed size: < 5 MB">
                                                            <span class="input-group-btn">
                                                            <button class="browse_files btn btn-danger" type="button">
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
                                <div class="card-read-more" id="btn_attachments" style="display: none">
                                    <button class="btn btn-link btn-block" data-placement="top"
                                            data-toggle="tooltip" title="Click here to submit your changes!"
                                            id="btn_save_attachments">
                                        <i class="fa fa-archive"></i>&nbsp;SAVE CHANGES
                                    </button>
                                </div>
                                @if(count($attachments) != 0)
                                    <div class="card-read-more" id="btn_delete_attachments">
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
                    {{--Language Skill--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      id="form-lang" action="{{route('create.languages')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_lang_settings">
                                                Language Skill
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-language"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_lang" style="font-size: 14px; margin-top: 0">
                                                @if(count($languages) == 0)
                                                    <p>Your language skill, local or foreign language.<br><br></p>
                                                @else
                                                    @foreach($languages as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="64"
                                                                             class="media-object"
                                                                             src="{{asset('images/lang.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-language"></i>&nbsp;
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->name}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"
                                                                                   onclick="editLang('{{encrypt
                                                                                   ($row->id)}}')">
                                                                                   EDIT&ensp;<i class="fa fa-edit"></i></a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete.languages',['id' => encrypt($row->id),'lang' => $row->name])}}"
                                                                                   class="delete-lang"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 12px;text-transform: none">
                                                                            <table style="font-size: 12px;margin-top: 0">
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-comments"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Speaking
                                                                                        Level
                                                                                    </td>
                                                                                    <td>&nbsp;:&nbsp;
                                                                                    </td>
                                                                                    <td align="justify">
                                                                                        @if($row->spoken_lvl != "")
                                                                                            <span style="text-transform: uppercase">{{$row->spoken_lvl}}</span>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-pencil-alt"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Writing
                                                                                        Level
                                                                                    </td>
                                                                                    <td>&nbsp;:&nbsp;
                                                                                    </td>
                                                                                    <td align="justify">
                                                                                        @if($row->written_lvl != "")
                                                                                            <span style="text-transform: uppercase">{{$row->written_lvl}}</span>
                                                                                        @else
                                                                                            -
                                                                                        @endif
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
                                                @endif
                                            </div>

                                            <div id="lang_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Language</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-language"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="e.g: English"
                                                                   name="name" maxlength="100"
                                                                   id="name_lang" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Speaking Level
                                                            <span class="optional-label">
                                                                                (Optional)</span></small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-comments"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    name="spoken_lvl" id="spoken_lvl">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                <option value="good">Good</option>
                                                                <option value="fair">Fair</option>
                                                                <option value="poor">Poor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Writing Level
                                                            <span class="optional-label">
                                                                                (Optional)</span></small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-pencil-alt"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    name="written_lvl" id="written_lvl">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                <option value="good">Good</option>
                                                                <option value="fair">Fair</option>
                                                                <option value="poor">Poor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_lang">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_lang"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-language"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Skill--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      id="form-skill" action="{{route('create.skills')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_skill_settings">
                                                Skill
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-user-secret"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_skill"
                                                 style="font-size: 14px; margin-top: 0">
                                                @if(count($skills) == 0)
                                                    <p align="justify">
                                                        Things you are good at, for example Data
                                                        Analysis, Accounting, App Developing, Time
                                                        Management, Creativity, etc.</p>
                                                @else
                                                    @foreach($skills as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="64"
                                                                             class="media-object"
                                                                             src="{{asset('images/skill.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-user-secret"></i>&nbsp;
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->name}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"
                                                                                   onclick="editSkill('{{encrypt
                                                                                   ($row->id)}}')">
                                                                                    EDIT&ensp;<i class="fa fa-edit"></i></a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete.skills',
                                                                                ['id' => encrypt($row->id),
                                                                                'skill' => $row->name])}}"
                                                                                   class="delete-skill"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 12px;text-transform: none">
                                                                            <i class="fa fa-chart-line"></i>&nbsp;
                                                                            @if($row->level != "")
                                                                                <span style="text-transform: uppercase">
                                                                                            {{$row->level}}</span>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-divider">
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div id="skill_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Skill Name</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user-secret"></i>
                                                                            </span>
                                                            <input class="form-control" name="name"
                                                                   type="text" required maxlength="100"
                                                                   placeholder="e.g: Programming"
                                                                   id="name_skill">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Skill Level
                                                            <span class="optional-label">
                                                                                (Optional)</span></small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-chart-line"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    name="level" id="skill_lvl">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                <option value="good">Good</option>
                                                                <option value="fair">Fair</option>
                                                                <option value="poor">Poor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_skill">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_skill"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-user-secret"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    {{--Personal Data & Contact--}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{route('update.profile')}}">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <input type="hidden" name="check_form" value="personal">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_personal_data_settings">
                                                Personal Data
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i class="fa fa-edit"></i>&nbsp;EDIT
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <table style="font-size: 14px; margin-top: 0"
                                                   id="stats_personal_data">
                                                <tr>
                                                    <td><i class="fa fa-id-card"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>{{$user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-birthday-cake"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        {{$seeker->birthday == "" ? 'Birthday (-)' :
                                                        \Carbon\Carbon::parse($seeker->birthday)->format('j F Y')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-transgender"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->gender != "")
                                                            {{$seeker->gender}}
                                                        @else
                                                            Gender (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-hand-holding-heart"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->relationship != "")
                                                            {{$seeker->relationship}}
                                                        @else
                                                            Relationship Status (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-flag"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->nationality != "")
                                                            {{$seeker->nationality}}
                                                        @else
                                                            Nationality (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-globe"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td style="text-transform: none">
                                                        @if($seeker->website != "")
                                                            {{$seeker->website}}
                                                        @else
                                                            Personal Website (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-hand-holding-usd"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td style="text-transform: none"
                                                        id="expected_salary2">
                                                        @if($seeker->lowest_salary != "")
                                                            <script>
                                                                var low = ("{{$seeker->lowest_salary}}").split(',').join("") / 1000000,
                                                                    high = ("{{$seeker->highest_salary}}").split(',').join("") / 1000000;
                                                                document.getElementById("expected_salary2").innerText = "IDR " + low + " to " + high + " millions";
                                                            </script>
                                                        @else
                                                            Expected Salary (anything)
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                            <div id="personal_data_settings" style="display: none">
                                                <small>Name</small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user"></i>
                                                                            </span>
                                                            <input placeholder="Name" maxlength="191"
                                                                   value="{{$user->name}}"
                                                                   type="text" class="form-control"
                                                                   name="name" required autofocus>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small>Birthday</small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-birthday-cake"></i>
                                                                            </span>
                                                            <input class="form-control datepicker"
                                                                   name="birthday" type="text" required
                                                                   placeholder="yyyy-mm-dd"
                                                                   value="@if($seeker->birthday != ""){{$seeker->birthday}}@endif"
                                                                   maxlength="10">
                                                        </div>
                                                    </div>
                                                </div>
                                                <small>Gender</small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-transgender"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" name="gender"
                                                                    required>
                                                                <option value="male"
                                                                        @if($seeker->gender == "male") selected @endif>
                                                                    Male
                                                                </option>
                                                                <option value="female"
                                                                        @if($seeker->gender == "female") selected @endif>
                                                                    Female
                                                                </option>
                                                                <option value="other"
                                                                        @if($seeker->gender == "other") selected @endif>
                                                                    Rather not say
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Relationship Status</small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-hand-holding-heart">
                                                                                </i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --"
                                                                    name="relationship" required>
                                                                <option value="single"
                                                                        {{$seeker->relationship == "single" ?
                                                                        'selected' : ''}}>Single
                                                                </option>
                                                                <option value="married"
                                                                        {{$seeker->relationship == "married" ?
                                                                        'selected' : ''}}>Married
                                                                </option>
                                                                <option value="divorced"
                                                                        {{$seeker->relationship == "divorced" ?
                                                                        'selected' : ''}}>Divorced
                                                                </option>
                                                                <option value="widowed"
                                                                        {{$seeker->relationship == "widowed" ?
                                                                        'selected' : ''}}>Widowed
                                                                </option>
                                                                <option value="other"
                                                                        {{$seeker->relationship == "other" ?
                                                                        'selected' : ''}}>Rather not say
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Nationality
                                                    <span class="optional-label">(Optional)</span>
                                                </small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-flag"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    name="nationality"
                                                                    data-live-search="true">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                @foreach($nations as $row)
                                                                    <option value="{{$row->name}}"
                                                                            @if($row->name == $seeker->nationality) selected @endif>{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Personal Website
                                                    <span class="optional-label">(Optional)</span>
                                                </small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-globe"></i>
                                                                            </span>
                                                            <input placeholder="http://example.com"
                                                                   type="text" class="form-control"
                                                                   name="website" maxlength="191"
                                                                   value="@if($seeker->website != ""){{$seeker->website}}@endif">
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Expected Salary (IDR)</small>
                                                <div class="row form-group checkRupiahValue">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <strong>Rp</strong></span>
                                                            <input type="text" name="lowest"
                                                                   placeholder="1,000,000" id="lowest"
                                                                   maxlength="15" minlength="5"
                                                                   class="form-control rupiah" required
                                                                   onkeyup="return checkRupiahValue()"
                                                                   value="{{$seeker->lowest_salary}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group checkRupiahValue">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <strong>Rp</strong></span>
                                                            <input type="text" name="highest"
                                                                   placeholder="5,000,000" id="highest"
                                                                   class="form-control rupiah" required
                                                                   maxlength="15" minlength="5"
                                                                   onkeyup="return checkRupiahValue()"
                                                                   value="{{$seeker->highest_salary}}">
                                                        </div>
                                                        <span class="help-block">
                                                                            <small class="aj_rp"
                                                                                   style="text-transform: none"></small>
                                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_personal_data"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-user"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{route('update.profile')}}">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <input type="hidden" name="check_form" value="contact">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_contact_settings">
                                                Contact
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i class="fa fa-edit"></i>&nbsp;EDIT
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <table style="font-size: 14px; margin-top: 0"
                                                   id="stats_contact">
                                                <tr>
                                                    <td><i class="fa fa-envelope"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td style="text-transform: none">{{$user->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-phone"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->phone != "")
                                                            {{$seeker->phone}}
                                                        @else
                                                            Phone number (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-home"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->address != "")
                                                            {{$seeker->address}}
                                                        @else
                                                            Address (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-address-card"></i></td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        @if($seeker->zip_code != "")
                                                            {{$seeker->zip_code}}
                                                        @else
                                                            ZIP/Post Code (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                            <div id="contact_settings" style="display: none">
                                                <small>Primary E-mail (verified)</small>
                                                <div class="row form-group has-feedback">
                                                    <div class="col-md-12">
                                                        <input value="{{$user->email}}" type="email"
                                                               class="form-control" disabled>
                                                        <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                                    </div>
                                                </div>
                                                <small>Phone
                                                    <span class="optional-label">(Optional)</span>
                                                </small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                            </span>
                                                            <input placeholder="08123xxxxxxx"
                                                                   type="text" maxlength="13"
                                                                   class="form-control" name="phone"
                                                                   onkeypress="return numberOnly(event, false)"
                                                                   value="@if($seeker->phone != ""){{$seeker->phone}}@endif">
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Address
                                                    <span class="optional-label">(Optional)</span>
                                                </small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-home"></i>
                                                                            </span>
                                                            <textarea style="resize:vertical"
                                                                      name="address"
                                                                      placeholder="Current address..."
                                                                      class="form-control">@if($seeker->address != ""){{$seeker->address}}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Zip Code
                                                    <span class="optional-label">(Optional)</span>
                                                </small>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-address-card"></i>
                                                                            </span>
                                                            <input placeholder="612xx" type="text"
                                                                   class="form-control" name="zip_code"
                                                                   onkeypress="return numberOnly(event, false)"
                                                                   value="@if($seeker->zip_code != ""){{$seeker->zip_code}}@endif"
                                                                   maxlength="5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_contact"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-address-book"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Summary--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{route('update.profile')}}">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <input type="hidden" name="check_form" value="summary">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_summary_settings">
                                                Summary <span class="optional-label">(Optional)</span>
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i class="fa fa-edit"></i>&nbsp;EDIT
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <blockquote id="stats_summary">
                                                <p align="justify" class="aj_summary">
                                                    @if($seeker->summary != "")
                                                        {{$seeker->summary}}
                                                    @else
                                                        A Resume summary is a short, snappy
                                                        introduction highlighting your career
                                                        progress and skill set. Grab the hiring
                                                        Managers’s attention!
                                                    @endif
                                                </p>
                                            </blockquote>

                                            <div id="summary_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                    <textarea name="summary" class="form-control use-tinymce"
                                                              placeholder="Write your summary here...">{{$seeker->summary != "" ? $seeker->summary : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_summary"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-comment-dots"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Experiences--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{route('create.experiences')}}" id="form-exp">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_exp_settings">
                                                Work Experience
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-briefcase"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_exp" style="font-size: 14px; margin-top: 0">
                                                @if(count($experiences) == 0)
                                                    <p align="justify">
                                                        Please fill your current and previous work
                                                        experience and responsibilities.</p>
                                                @else
                                                    @foreach($experiences as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="100"
                                                                             class="media-object"
                                                                             src="{{asset('images/exp.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-briefcase">&nbsp;</i>
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->job_title}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"
                                                                                   onclick="editExp('{{encrypt($row->id)}}')">
                                                                                    EDIT&ensp;<i class="fa fa-edit"></i>
                                                                                </a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete.experiences',
                                                                                ['id' => encrypt
                                                                                ($row->id),'exp' =>
                                                                                $row->job_title])}}"
                                                                                   class="delete-exp"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;
                                                                                    DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 14px;text-transform: none">
                                                                            <table style="font-size: 14px; margin-top: 0">
                                                                                <tr>
                                                                                    <td><i class="fa fa-building"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Agency Name</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->company}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-level-up-alt"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Job Level</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\App\JobLevel::find
                                                                                    ($row->joblevel_id)->name}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-warehouse"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Job Function</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\App\FungsiKerja::find
                                                                                    ($row->fungsikerja_id)->nama}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-industry"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Industry</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\App\Industri::find
                                                                                    ($row->industri_id)->nama}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-map-marked"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Location</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{substr(\App\Cities::find
                                                                                    ($row->city_id)->name,0,2) == "Ko" ?
                                                                                    substr(\App\Cities::find($row->city_id)
                                                                                    ->name,5) : substr(\App\Cities::find
                                                                                    ($row->city_id)->name,10)}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-money-bill-wave"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Salary</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>@if($row->salary_id != "")
                                                                                            {{\App\Salaries::find
                                                                                            ($row->salary_id)->name}}
                                                                                        @else
                                                                                            Rather not say
                                                                                        @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-calendar-alt"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Since</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\Carbon\Carbon::parse
                                                                                    ($row->start_date)->format('j F Y')}}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-calendar-check"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Until</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>@if($row->end_date != "")
                                                                                            {{\Carbon\Carbon::parse
                                                                                            ($row->end_date)->format('j F Y')}}
                                                                                        @else
                                                                                            Present
                                                                                        @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-user-clock"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Job Type</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>@if($row->jobtype_id != "")
                                                                                            {{\App\JobType::find
                                                                                            ($row->jobtype_id)->name}}
                                                                                        @else
                                                                                            (empty)
                                                                                        @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-user-tie"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Report to</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>@if($row->report_to != "")
                                                                                            {{$row->report_to}}
                                                                                        @else
                                                                                            (empty)
                                                                                        @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-comments"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Job Description</td>
                                                                                </tr>
                                                                            </table>
                                                                            {!! $row->job_desc != "" ?
                                                                            $row->job_desc : '(empty)'!!}
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-divider">
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div id="exp_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Job Title</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-briefcase"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   id="job_title" name="job_title"
                                                                   placeholder="Job Title"
                                                                   maxlength="40" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Job Level</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-level-up-alt"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="job_level"
                                                                    data-live-search="true"
                                                                    name="joblevel_id" required>
                                                                @foreach($job_levels as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Company Name</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-building"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   id="company" name="company"
                                                                   placeholder="e.g: PT. SISKA"
                                                                   maxlength="100" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Job Function</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-warehouse"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="job_funct"
                                                                    data-live-search="true"
                                                                    name="fungsikerja_id" required>
                                                                @foreach($job_functions as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Industry</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-industry"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="industry"
                                                                    data-live-search="true"
                                                                    name="industri_id" required>
                                                                @foreach($industries as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Location</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-map-marked"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="city_id"
                                                                    data-live-search="true"
                                                                    name="city_id" required>
                                                                @foreach($provinces as $province)
                                                                    <optgroup
                                                                            label="{{$province->name}}">
                                                                        @foreach($province->cities as $city)
                                                                            @if(substr($city->name, 0, 2)=="Ko")
                                                                                <option value="{{$city->id}}">{{substr($city->name,4)}}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{$city->id}}">{{substr($city->name,9)}}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Salary <span class="optional-label">
                                                                                (Optional)</span>
                                                        </small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <strong>Rp</strong></span>
                                                            <select class="form-control selectpicker"
                                                                    id="salary_id"
                                                                    data-live-search="true"
                                                                    name="salary_id">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                @foreach($salaries as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Start Date</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar-alt"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   name="start_date" type="text"
                                                                   id="start_date" required
                                                                   maxlength="10"
                                                                   placeholder="yyyy-mm-dd">
                                                        </div>
                                                        <small>
                                                            <input type="checkbox" id="cb_end_date"
                                                                   onclick="showEndDate()"
                                                                   name="end_date" checked>
                                                            &nbsp;Currently work here
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row form-group" style="margin-top: -.5em">
                                                    <div class="col-lg-6">
                                                        <small>Job Type <span class="optional-label">
                                                                                (Optional)</span>
                                                        </small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user-clock"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    id="job_type" name="jobtype_id">
                                                                <option value="" selected>-- Choose --
                                                                </option>
                                                                @foreach($job_types as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6" id="end_date">
                                                        <small>End Date</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar-check"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   name="end_date" type="text"
                                                                   placeholder="yyyy-mm-dd"
                                                                   maxlength="10">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Report To <span class="optional-label">
                                                                                (Optional)</span>
                                                        </small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user-tie"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   name="report_to" id="report_to"
                                                                   placeholder="Your leader job title"
                                                                   maxlength="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Job Description
                                                            <span class="optional-label">
                                                                                (Optional)</span>
                                                        </small>
                                                        <textarea id="job_desc" name="job_desc"
                                                                  class="form-control use-tinymce"
                                                                  placeholder="Tell us your work responsibility. Our survey suggested that 92% of HR consider that job description is very important"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_exp">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_exp"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-briefcase"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Education--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      id="form-edu" action="{{route('create.educations')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_edu_settings">
                                                Education
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-graduation-cap"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_edu" style="font-size: 14px; margin-top: 0">
                                                @if(count($educations) == 0)
                                                    <p align="justify">
                                                        Please fill your educational background details.
                                                    </p>
                                                @else
                                                    @foreach($educations as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="100"
                                                                             class="media-object"
                                                                             src="{{asset('images/edu.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-school">&nbsp;</i>
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->school_name}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"

                                                                                   onclick="editEdu('{{encrypt
                                                                                   ($row->id)}}')">
                                                                                    EDIT&ensp;<i class="fa fa-edit"></i>
                                                                                </a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete.educations',
                                                                                ['id' => encrypt
                                                                                ($row->id),'edu' =>
                                                                                $row->school_name])}}"
                                                                                   class="delete-edu"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;
                                                                                    DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 14px;text-transform: none">
                                                                            <table style="font-size: 14px; margin-top: 0">
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-graduation-cap"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Education Degree</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\App\Tingkatpend::find
                                                                                ($row->tingkatpend_id)->name}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-user-graduate"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Education Major</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\App\Jurusanpend::find
                                                                                ($row->jurusanpend_id)->name}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-hourglass-start"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Start Period</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->start_period}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-hourglass-end"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;End Period</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->end_period == "" ?
                                                                                'Present' : $row->end_period}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-grin-stars"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;GPA</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>@if($row->nilai != "")
                                                                                            {{$row->nilai}}
                                                                                        @else
                                                                                            (-)
                                                                                        @endif</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-trophy"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Honors/Awards</td>
                                                                                </tr>
                                                                            </table>
                                                                            {!! $row->awards != "" ?
                                                                            $row->awards : '(empty)'!!}
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-divider">
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div id="edu_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>School Name</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-school"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="Universitas Negeri Surabaya"
                                                                   name="school_name" id="school_name"
                                                                   maxlength="100" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Degree</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-graduation-cap"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --"
                                                                    id="tingkatpend"
                                                                    data-live-search="true"
                                                                    name="tingkatpend_id" required>
                                                                @foreach($degrees as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>GPA <span class="optional-label">(Optional)</span>
                                                        </small>
                                                        <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-grin-stars"></i>
                                                        </span>
                                                            <input class="form-control gpa"
                                                                   name="nilai" type="text"
                                                                   maxlength="4" id="nilai"
                                                                   onkeypress="return numberOnly(event,false)"
                                                                   placeholder="0.00">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Major</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user-graduate"></i>
                                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --"
                                                                    id="jurusanpend"
                                                                    data-live-search="true"
                                                                    name="jurusanpend_id" required>
                                                                @foreach($majors as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Start Period</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-hourglass-start"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   name="start_period" type="text"
                                                                   id="start_period" placeholder="yyyy"
                                                                   maxlength="4" required>
                                                        </div>
                                                        <small>
                                                            <input type="checkbox" id="cb_end_period"
                                                                   value="{{\Carbon\Carbon::now()->year}}"
                                                                   onclick="showEndPeriod()"
                                                                   name="end_period" checked>
                                                            &nbsp;Currently study here
                                                        </small>
                                                    </div>
                                                    <div class="col-lg-6" id="end_period">
                                                        <small>End Period</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-hourglass-end"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   name="end_period" type="text"
                                                                   placeholder="yyyy" maxlength="4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Honors or Awards
                                                            <span class="optional-label">(Optional)</span>
                                                        </small>
                                                        <textarea name="awards" id="awards"
                                                                  class="form-control use-tinymce"
                                                                  placeholder="Write something here..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_edu">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_edu"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-school"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Training/Certification--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      id="form-cert" action="{{route('create.trainings')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_cert_settings">
                                                Training / Certification
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-certificate"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_cert" style="font-size: 14px; margin-top: 0">
                                                @if(count($trainings) == 0)
                                                    <p align="justify">
                                                        Professional Certification, Organizational
                                                        Training, etc that you have taken.</p>
                                                @else
                                                    @foreach($trainings as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="100"
                                                                             class="media-object"
                                                                             src="{{asset('images/cert.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-certificate"></i>&nbsp;
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->name}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"
                                                                                   onclick="editCert('{{encrypt
                                                                                   ($row->id)}}')">
                                                                                    EDIT&ensp;<i class="fa fa-edit"></i>
                                                                                </a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete
                                                                                .trainings',['id' => encrypt
                                                                                ($row->id),'cert' => $row->name])}}"
                                                                                   class="delete-cert"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;
                                                                                    DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 14px;text-transform: none">
                                                                            <table style="font-size: 14px; margin-top: 0">
                                                                                <tr>
                                                                                    <td><i class="fa fa-university"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Issued by</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->issuedby}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-calendar-alt"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Issued Date</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{\Carbon\Carbon::parse
                                                                                ($row->isseuddate)->format('j F Y')}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-comments"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Job Description</td>
                                                                                </tr>
                                                                            </table>
                                                                            {!! $row->descript != "" ?
                                                                            $row->descript : '(empty)'!!}
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-divider">
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div id="cert_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Name</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-certificate"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="e.g: Professional Web Programming"
                                                                   name="name" maxlength="100"
                                                                   id="name_cert" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Issued By</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-university"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="Company or institution name"
                                                                   name="issuedby" maxlength="100"
                                                                   id="issuedby" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Issued Date</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar-alt"></i>
                                                                            </span>
                                                            <input class="form-control datepicker"
                                                                   name="issueddate" maxlength="10"
                                                                   placeholder="yyyy-mm-dd"
                                                                   id="issueddate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Description
                                                            <span class="optional-label">
                                                                                (Optional)</span></small>
                                                        <textarea class="form-control use-tinymce" name="descript"
                                                                  placeholder="Write something here..."
                                                                  id="desc_cert"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_cert">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_cert"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-certificate"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Organizations--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST"
                                      id="form-org" action="{{route('create.organizations')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_org_settings">
                                                Organization Experience
                                                <span class="pull-right"
                                                      style="cursor: pointer; color: #FA5555"><i
                                                            class="fa fa-users"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_org" style="font-size: 14px; margin-top: 0">
                                                @if(count($organizations) == 0)
                                                    <p align="justify">
                                                        Any non professional organization experience
                                                        (Student, event, or non profit organizations
                                                        experience)
                                                    </p>
                                                @else
                                                    @foreach($organizations as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle">
                                                                        <img width="100"
                                                                             class="media-object"
                                                                             src="{{asset('images/org.png')}}">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="media-heading">
                                                                            <i class="fa fa-users">&nbsp;</i>
                                                                            <small style="text-transform: uppercase">
                                                                                {{$row->name}}
                                                                            </small>
                                                                            <span class="pull-right">
                                                                                <a style="color: #00ADB5;cursor: pointer;"
                                                                                   onclick="editOrg('{{encrypt
                                                                                   ($row->id)}}')">
                                                                                    EDIT&ensp;<i class="fa fa-edit"></i>
                                                                                </a>
                                                                                <small style="color: #7f7f7f">
                                                                                    &nbsp;&#124;&nbsp;
                                                                                </small>
                                                                                <a href="{{route('delete
                                                                                .organizations',['id' =>
                                                                                encrypt($row->id),'org' =>
                                                                                $row->name])}}"
                                                                                   class="delete-org"
                                                                                   style="color: #FA5555;">
                                                                                    <i class="fa fa-eraser"></i>&ensp;
                                                                                    DELETE</a>
                                                                            </span>
                                                                        </p>
                                                                        <blockquote
                                                                                style="font-size: 14px;text-transform: none">
                                                                            <table style="font-size: 14px; margin-top: 0">
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-hourglass-start"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Start Period</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->start_period}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class="fa fa-hourglass-end"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;End Period</td>
                                                                                    <td>&nbsp;:&nbsp;</td>
                                                                                    <td>{{$row->end_period == "" ?
                                                                                'Present' : $row->end_period}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><i class="fa fa-comments"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;Description</td>
                                                                                </tr>
                                                                            </table>
                                                                            {!! $row->descript != "" ?
                                                                            $row->descript : '(empty)'!!}
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-divider">
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div id="org_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Organization Name</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-users"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="e.g: Rabbit Media"
                                                                   name="name" maxlength="40"
                                                                   id="name_org" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Organization Title</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-briefcase"></i>
                                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="e.g: General Advisor"
                                                                   name="title" maxlength="60"
                                                                   id="org_title" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Start Period</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-hourglass-start"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   placeholder="yyyy" type="text"
                                                                   name="start_period" required
                                                                   id="start_period2" maxlength="4">
                                                        </div>
                                                        <small>
                                                            <input type="checkbox" id="cb_end_period2"
                                                                   value="{{\Carbon\Carbon::now()->year}}"
                                                                   onclick="showEndPeriod()"
                                                                   name="end_period" checked>
                                                            &nbsp;Currently involved here
                                                        </small>
                                                    </div>
                                                    <div class="col-lg-6" id="end_period2">
                                                        <small>End Period</small>
                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-hourglass-end"></i>
                                                                            </span>
                                                            <input class="form-control"
                                                                   placeholder="yyyy" type="text"
                                                                   name="end_period" maxlength="4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <small>Description
                                                            <span class="optional-label">
                                                                                (Optional)</span></small>
                                                        <textarea class="form-control use-tinymce" name="descript"
                                                                  placeholder="Write something here..."
                                                                  id="org_desc"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_org">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL"
                                                               class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_org"
                                                class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-users"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Test Result--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>Test Result</small>
                                        <hr class="hr-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="media">
                                                    <div class="media-left media-middle">
                                                        <img width="100" class="media-object"
                                                             alt="English First"
                                                             src="{{asset('images/ef.png')}}">
                                                    </div>
                                                    <div class="media-body">
                                                        <small class="media-heading">
                                                            EF Standard English Test - Express
                                                            <a href="#">
                                                                                <span class="pull-right"
                                                                                      style="color: #FA5555">
                                                                                    (Take Test ?)</span></a>
                                                        </small>
                                                        <blockquote style="font-size: 12px">
                                                            <p>
                                                                SISKA has been cooperated with EF
                                                                (English First) to provide an
                                                                International Standard and FREE English
                                                                Test facility with. What are you
                                                                waiting for!? Check it out and try to
                                                                measure your English skills!</p>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="hr-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="media">
                                                    <div class="media-left media-middle">
                                                        <img width="100" class="media-object"
                                                             alt="Communication Test"
                                                             src="{{asset('images/comm_test.png')}}">
                                                    </div>
                                                    <div class="media-body">
                                                        <small class="media-heading">
                                                            Communication Style Test
                                                            <a href="#">
                                                                                <span class="pull-right"
                                                                                      style="color: #FA5555">
                                                                                    (Take Test ?)</span></a>
                                                        </small>
                                                        <blockquote style="font-size: 12px">
                                                            <p>
                                                                Know your communication style, whether
                                                                you are an Investigator, Leader,
                                                                Counselor, or Communicator? Find the
                                                                answer to a brilliant career!
                                                            </p>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="hr-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="media">
                                                    <div class="media-left media-middle">
                                                        <img width="100" class="media-object"
                                                             alt="Interest Test"
                                                             src="{{asset('images/int_test.png')}}">
                                                    </div>
                                                    <div class="media-body">
                                                        <small class="media-heading">
                                                            Interest Test
                                                            <a href="#">
                                                                                <span class="pull-right"
                                                                                      style="color: #FA5555">
                                                                                    (Take Test ?)</span></a>
                                                        </small>
                                                        <blockquote style="font-size: 12px">
                                                            <p>
                                                                Work interest is determining your
                                                                career. Various facilities and
                                                                professions to success. Find it out,
                                                                your work interests!
                                                            </p>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.partials.auth.Seekers._scripts_auth')
    @include('layouts.partials.auth.Seekers._scripts_ajax')
@endpush