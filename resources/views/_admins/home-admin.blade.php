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
                            <p>Total: <strong>{{count($agencies)}}</strong> job agencies</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('table.seekers')}}" class="seeker">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-user-graduate"></i></div>
                            <div class="count">{{$newSeeker}}</div>
                            <h3>New {{$newSeeker > 1 ? 'Seekers' : 'Seeker'}}</h3>
                            <p>Total: <strong>{{count($seekers)}}</strong> job seekers</p>
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
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Users
                                <small>Chart</small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-times"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="users_chart" style="height:350px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Monthly Income
                                <small>Graph</small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-times"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="income_graph" style="height:350px;"></div>
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
                                                        <span>{{\App\Jenisblog::find($blog->jenisblog_id)->nama}}</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>{{$blog->judul}}</a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>{{$blog->updated_at->diffForHumans()}}</span> by
                                                        <a>{{$blog->uploder}}</a>
                                                    </div>
                                                    <p class="excerpt">
                                                        {!!$blog->konten!!}
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
@push("scripts")
    <script>
        var theme = {
                color: [
                    '#00adb5', '#fa5555', '#BDC3C7', '#3498DB',
                    '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
                ],

                title: {
                    itemGap: 8,
                    textStyle: {
                        fontWeight: 'normal',
                        color: '#408829'
                    }
                },

                dataRange: {
                    color: ['#1f610a', '#97b58d']
                },

                toolbox: {
                    color: ['#408829', '#408829', '#408829', '#408829']
                },

                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.5)',
                    axisPointer: {
                        type: 'line',
                        lineStyle: {
                            color: '#408829',
                            type: 'dashed'
                        },
                        crossStyle: {
                            color: '#408829'
                        },
                        shadowStyle: {
                            color: 'rgba(200,200,200,0.3)'
                        }
                    }
                },

                dataZoom: {
                    dataBackgroundColor: '#eee',
                    fillerColor: 'rgba(64,136,41,0.2)',
                    handleColor: '#408829'
                },
                grid: {
                    borderWidth: 0
                },

                categoryAxis: {
                    axisLine: {
                        lineStyle: {
                            color: '#408829'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                },

                valueAxis: {
                    axisLine: {
                        lineStyle: {
                            color: '#408829'
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                },
                timeline: {
                    lineStyle: {
                        color: '#408829'
                    },
                    controlStyle: {
                        normal: {color: '#408829'},
                        emphasis: {color: '#408829'}
                    }
                },

                k: {
                    itemStyle: {
                        normal: {
                            color: '#68a54a',
                            color0: '#a9cba2',
                            lineStyle: {
                                width: 1,
                                color: '#408829',
                                color0: '#86b379'
                            }
                        }
                    }
                },
                map: {
                    itemStyle: {
                        normal: {
                            areaStyle: {
                                color: '#ddd'
                            },
                            label: {
                                textStyle: {
                                    color: '#c12e34'
                                }
                            }
                        },
                        emphasis: {
                            areaStyle: {
                                color: '#99d2dd'
                            },
                            label: {
                                textStyle: {
                                    color: '#c12e34'
                                }
                            }
                        }
                    }
                },
                force: {
                    itemStyle: {
                        normal: {
                            linkStyle: {
                                strokeColor: '#408829'
                            }
                        }
                    }
                },
                chord: {
                    padding: 4,
                    itemStyle: {
                        normal: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            },
                            chordStyle: {
                                lineStyle: {
                                    width: 1,
                                    color: 'rgba(128, 128, 128, 0.5)'
                                }
                            }
                        },
                        emphasis: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            },
                            chordStyle: {
                                lineStyle: {
                                    width: 1,
                                    color: 'rgba(128, 128, 128, 0.5)'
                                }
                            }
                        }
                    }
                },
                gauge: {
                    startAngle: 225,
                    endAngle: -45,
                    axisLine: {
                        show: true,
                        lineStyle: {
                            color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                            width: 8
                        }
                    },
                    axisTick: {
                        splitNumber: 10,
                        length: 12,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    axisLabel: {
                        textStyle: {
                            color: 'auto'
                        }
                    },
                    splitLine: {
                        length: 18,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    pointer: {
                        length: '90%',
                        color: 'auto'
                    },
                    title: {
                        textStyle: {
                            color: '#333'
                        }
                    },
                    detail: {
                        textStyle: {
                            color: 'auto'
                        }
                    }
                },
                textStyle: {
                    fontFamily: 'Arial, Verdana, sans-serif'
                }
            },
            echartPieCollapse = echarts.init(document.getElementById('users_chart'), theme),
            echartBar = echarts.init(document.getElementById('income_graph'), theme);

        echartPieCollapse.setOption({
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                x: 'center',
                y: 'bottom',
                data: ['Job Agency', 'Job Seeker']
            },
            toolbox: {
                show: true,
                feature: {
                    magicType: {
                        show: true,
                        type: ['pie', 'funnel']
                    },
                    restore: {
                        show: true,
                        title: "Restore"
                    },
                    saveAsImage: {
                        show: true,
                        title: "Save Image"
                    }
                }
            },
            calculable: true,
            series: [{
                name: 'Total: {{count($users)}} users',
                type: 'pie',
                radius: [25, 90],
                center: ['50%', 170],
                roseType: 'area',
                x: '50%',
                max: 40,
                sort: 'ascending',
                data: [{
                    value: '{{count($agencies)}}',
                    name: 'Job Agency'
                }, {
                    value: '{{count($seekers)}}',
                    name: 'Job Seeker'
                }]
            }]
        });

        echartBar.setOption({
            title: {
                text: 'Vacancy Advertising',
                subtext: 'Monthly Income (in millions)'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['Income (IDR)']
            },
            toolbox: {
                show: true
            },
            calculable: true,
            xAxis: [{
                type: 'category',
                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }],
            yAxis: [{
                type: 'value'
            }],
            series: [{
                name: 'Income (IDR)',
                type: 'bar',
                data: [
                    @for($i=1;$i<=12;$i++)
                            @php
                                $total = 0;
                                $postings = \App\ConfirmAgency::where('isPaid',true)->whereMonth('date_payment',$i);
                                foreach ($postings->get() as $posting){
                                    $total += $posting->total_payment;
                                }
                                $income = number_format($total/1000000,1,'.','');
                            @endphp
                        '{{$income}}',
                    @endfor
                ],
                markPoint: {
                    data: [{
                        type: 'max',
                        name: 'Highest'
                    }, {
                        type: 'min',
                        name: 'Lowest'
                    }]
                },
                markLine: {
                    data: [{
                        type: 'average',
                        name: 'Average'
                    }]
                }
            }]
        });
    </script>
@endpush
