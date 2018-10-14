@extends('layouts.mst_admin')
@section('title', ''.Auth::guard('admin')->user()->name.'\'s Dashboard &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('table.agencies')}}" class="agency">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-user-tie"></i></div>
                            <div class="count">{{$newAgency}}</div>
                            <h3>New {{$newAgency > 1 ? 'Agencies' : 'Agency'}}</h3>
                            <p>Total: <strong>{{\App\Agencies::count()}}</strong> job agencies</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('table.seekers')}}" class="seeker">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-user-graduate"></i></div>
                            <div class="count">{{$newSeeker}}</div>
                            <h3>New {{$newSeeker > 1 ? 'Seekers' : 'Seeker'}}</h3>
                            <p>Total: <strong>{{\App\Seekers::count()}}</strong> job seekers</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('table.jobPostings')}}" class="agency">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-briefcase"></i></div>
                            <div class="count">{{$newJobPost}}</div>
                            <h3>New {{$newJobPost > 1 ? 'Vacancies' : 'Vacancy'}}</h3>
                            <p>Total: <strong>{{\App\Vacancies::where('isPost',true)->count()}}</strong> posted
                                vacancies</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('table.applications')}}" class="seeker">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-paper-plane"></i></div>
                            <div class="count">{{$newApp}}</div>
                            <h3>New {{$newApp > 1 ? 'Applications' : 'Application'}}</h3>
                            <p>Total: <strong>{{\App\Accepting::where('isApply',true)->count()}}</strong>
                                applied applications</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Transaction Summary
                                <small>Weekly progress</small>
                            </h2>
                            <div class="filter">
                                <div id="reportrange" class="pull-right"
                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="demo-container" style="height:280px">
                                    <div id="chart_plot_02" class="demo-placeholder"></div>
                                </div>
                                <div class="tiles">
                                    <div class="col-md-4 tile">
                                        <span>Total Sessions</span>
                                        <h2>231,809</h2>
                                        <span class="sparkline11 graph" style="height: 160px;">
                               <canvas width="200" height="60"
                                       style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                    </div>
                                    <div class="col-md-4 tile">
                                        <span>Total Revenue</span>
                                        <h2>$231,809</h2>
                                        <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60"
                                        style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                    </div>
                                    <div class="col-md-4 tile">
                                        <span>Total Sessions</span>
                                        <h2>231,809</h2>
                                        <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60"
                                         style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Weekly Summary
                                <small>Activity shares</small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-times"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row"
                                 style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                                <div class="col-md-7" style="overflow:hidden;">
                        <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                                      <canvas width="200" height="60"
                                              style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                  </span>
                                    <h4 style="margin:18px">Weekly sales progress</h4>
                                </div>

                                <div class="col-md-5">
                                    <div class="row" style="text-align: center;">
                                        <div class="col-md-4">
                                            <canvas class="canvasDoughnut" height="110" width="110"
                                                    style="margin: 5px 10px 10px 0"></canvas>
                                            <h4 style="margin:0">Bounce Rates</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <canvas class="canvasDoughnut" height="110" width="110"
                                                    style="margin: 5px 10px 10px 0"></canvas>
                                            <h4 style="margin:0">New Traffic</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <canvas class="canvasDoughnut" height="110" width="110"
                                                    style="margin: 5px 10px 10px 0"></canvas>
                                            <h4 style="margin:0">Device Share</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Blog
                                <small>Career Inspirations</small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-times"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($blogs) > 0)
                                <ul class="list-unstyled timeline">
                                    @foreach($blogs as $blog)
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="" class="tag">
                                                        <span>{{$blog->jenisBlog->nama}}</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>{{$blog->judul}}</a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>{{$blog->updated_at->diffForHumans()}}</span> by
                                                        <a>{{$blog->uploader}}</a>
                                                    </div>
                                                    <p class="excerpt">
                                                        {{\Illuminate\Support\Str::words($blog->konten,20," ... ")}}
                                                        <a>Read More</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>There seems to be none of the blog was found&hellip;</a>
                                                </h2>
                                                <div class="byline"></div>
                                                <p class="excerpt"></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
