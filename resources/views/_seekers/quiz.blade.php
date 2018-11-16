@extends('layouts.mst_user')
@section('title', 'Quiz (Online TPA & TKD) | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/quiz.css')}}">
    <link rel="stylesheet" href="{{asset('css/bubble-button.css')}}">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 7em">
        <div class="fh5co-services">
            <div class="container" style="width: 100%">
                <div class="row">
                    <div id="online_quiz" class="col-lg-12 section-heading text-center" style="padding-bottom: 0">
                        <h2 class="to-animate" style="text-transform: none;font-size: 18px;letter-spacing: 1px">
                            <span><strong>Quiz (Online TPA & TKD)</strong></span>
                        </h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mm-survey">
                            <div class="mm-survey-progress">
                                <div class="mm-survey-progress-bar mm-progress">
                                    <span class="mm-progress-bar-text"></span>
                                </div>
                            </div>

                            <img src="{{asset('images/loading2.gif')}}" id="image"
                                 class="img-responsive ld ld-fade" style="display:none;margin: 0 auto">

                            <div class="mm-survey-results">
                                <div class="mm-survey-results-container">
                                    <table class="mm-survey-details">
                                        <tr>
                                            <td width="50%">
                                                <table>
                                                    <tr>
                                                        <td><i class="fa fa-shield-alt"></i>&nbsp;</td>
                                                        <td><strong>Quiz Code</strong></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>{{$quiz->unique_code}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-question-circle"></i>&nbsp;</td>
                                                        <td><strong>Total Question</strong></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>{{$quiz->total_question}} items</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-stopwatch"></i>&nbsp;</td>
                                                        <td><strong>Time Limit</strong></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>{{$quiz->time_limit}} minutes</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="50%">
                                                <table style="float: right">
                                                    <tr>
                                                        <td><i class="fa fa-grin-beam"></i>&nbsp;</td>
                                                        <td><strong>Your Score</strong></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td class="mm-survey-results-score"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-stopwatch"></i>&nbsp;</td>
                                                        <td><strong>Time Remaining</strong></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><strong class="time-remaining"
                                                                    style="font-size: 24px;"></strong></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <ul class="mm-survey-results-list"></ul>
                                </div>
                                <div class="mm-survey-results-controller">
                                    <div class="mm-back-btn">
                                        <button class="bubbly-button" style="padding: 3px 40px;">Back</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mm-survey-bottom">
                                <div class="mm-survey-container">
                                    <div class="status-timer">
                                        <i class="fa fa-stopwatch"></i><span class="time-remaining"
                                                                             style="margin-left: 5px"></span>
                                    </div>
                                    @php
                                        $x = 1;
                                        $questions = \App\QuizQuestions::whereIn('id',$quiz->question_ids)->take(3)->get();
                                    @endphp
                                    @foreach($questions as $question)
                                        @php $options = \App\QuizOptions::where('question_id',$question->id)->get(); @endphp
                                        <div class="mm-survey-page" data-page="{{$x++}}">
                                            <div class="mm-survery-content">
                                                <div class="mm-survey-question">
                                                    <p>{{$question->question_text}}</p>
                                                </div>
                                                @foreach($options as $option)
                                                    <div class="mm-survey-item">
                                                        <input type="radio" id="op{{$option->id}}"
                                                               data-item="2112" name="options"
                                                               class="op{{$question->id}}" value="{{$option->option}}">
                                                        <label for="op{{$option->id}}"><span></span>
                                                            <p>{{$option->option}}</p></label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mm-survey-controller">
                                    <div class="mm-prev-btn">
                                        <button class="bubbly-button">Prev</button>
                                    </div>
                                    <div class="mm-next-btn">
                                        <button class="bubbly-button" disabled>Next</button>
                                    </div>
                                    <div class="mm-finish-btn">
                                        <button class="bubbly-button">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script src="{{asset('js/bubble-button.js')}}"></script>
    <script>
        $('.mm-prev-btn').hide();

        var x, count, current, percent, quiz_time_limit, timeRemaining, timeInterval;

        init();
        getCurrentSlide();
        goToNext();
        goToPrev();
        getCount();
        buildStatus();
        deliverStatus();
        submitData();
        goBack();

        function init() {
            $('.mm-survey-container .mm-survey-page').each(function () {
                var item, page;

                item = $(this);
                page = item.data('page');

                item.addClass('mm-page-' + page);
                //item.html(page);
            });

            @php $y = 1; $z = 1; @endphp
            @foreach($questions as $question)
            $('.op{{$question->id}}').attr('name', 'op{{$y++}}').attr('data-item', '{{$z++}}');
            @endforeach

            $('.mm-page-1').addClass('active');

            quiz_time_limit = '{{$quiz->time_limit}}';
            timeRemaining = Math.round(quiz_time_limit * 60);
            timeInterval = setInterval(reduceTime, 1000);
        }

        function reduceTime() {
            var $class, $color;
            timeRemaining--;
            if (timeRemaining === 0) {
                setTimeout(collectData, 100);

            } else {
                $class = timeRemaining < 60 ? 'ld ld-heartbeat' : '';
                $color = timeRemaining < 60 ? '#fa5555' : '#00adb5';
                $('.status-timer').addClass($class).css('color', $color);
                $('.time-remaining').text(getTimeString()).css('color', $color);
            }
        }

        function getTimeString() {
            if (timeRemaining <= 0) {
                return '0:00';

            } else {
                var minutes = Math.floor(timeRemaining / 60), seconds = timeRemaining % 60;
                if (seconds < 10) {
                    seconds = '0' + seconds;
                }
                return minutes + ':' + seconds;
            }
        }

        function getCount() {
            count = $('.mm-survey-page').length;
            return count;
        }

        function goToNext() {
            $('.mm-next-btn').on('click', function () {
                goToSlide(x);
                getCount();
                current = x + 1;
                var g = current / count;
                buildProgress(g);
                getButtons();
                $('.mm-survey-page').removeClass('active');
                $('.mm-page-' + current).addClass('active');
                getCurrentSlide();
                checkStatus();
                if ($('.mm-page-' + count).hasClass('active')) {
                    if ($('.mm-page-' + count).hasClass('pass')) {
                        $('.mm-finish-btn').addClass('active');
                    }
                    else {
                        $('.mm-page-' + count + ' .mm-survery-content .mm-survey-item').on('click', function () {
                            $('.mm-finish-btn').addClass('active');
                        });
                    }
                }
                else {
                    $('.mm-finish-btn').removeClass('active');
                    if ($('.mm-page-' + current).hasClass('pass')) {
                        $('.mm-survey-container').addClass('good');
                        $('.mm-survey').addClass('okay');
                    }
                    else {
                        $('.mm-survey-container').removeClass('good');
                        $('.mm-survey').removeClass('okay');
                    }
                }
                buttonConfig();

                $('html, body').animate({
                    scrollTop: $('#online_quiz').offset().top
                }, 500);
            });
        }

        function goToPrev() {
            $('.mm-prev-btn').on('click', function () {
                goToSlide(x);
                getCount();
                current = (x - 1);
                var g = current / count;
                buildProgress(g);
                getButtons();
                $('.mm-survey-page').removeClass('active');
                $('.mm-page-' + current).addClass('active');
                getCurrentSlide();
                checkStatus();
                $('.mm-finish-btn').removeClass('active');
                if ($('.mm-page-' + current).hasClass('pass')) {
                    $('.mm-survey-container').addClass('good');
                    $('.mm-survey').addClass('okay');
                }
                else {
                    $('.mm-survey-container').removeClass('good');
                    $('.mm-survey').removeClass('okay');
                }
                buttonConfig();

                $('html, body').animate({
                    scrollTop: $('#online_quiz').offset().top
                }, 500);
            });
        }

        function buildProgress(g) {
            if (g > 1) {
                g = g - 1;
            }
            else if (g === 0) {
                g = 1;
            }
            g = g * 100;
            $('.mm-survey-progress-bar').css({'width': g + '%'});
        }

        function goToSlide(x) {
            return x;
        }

        function getCurrentSlide() {
            $('.mm-survey-page').each(function () {
                var item;

                item = $(this);

                if ($(item).hasClass('active')) {
                    x = item.data('page');
                }
                return x;
            });

            $('.mm-progress-bar-text').text('Question ' + x + ' of {{count($questions)}}');
        }

        function getButtons() {
            if (current === 0) {
                current = y;
            }

            if (current === count) {
                $('.mm-next-btn').hide();

            } else if (current === 1) {
                $('.mm-prev-btn').hide();

            } else {
                $('.mm-next-btn').show();
                $('.mm-prev-btn').show();
            }
        }

        $('.mm-survey-q li input').each(function () {
            var item;
            item = $(this);

            $(item).on('click', function () {
                if ($('input:checked').length > 0) {
                    // console.log(item.val());
                    $('label').parent().removeClass('active');
                    item.closest('li').addClass('active');
                }
            });
        });

        percent = (x / count) * 100;
        $('.mm-survey-progress-bar').css({'width': percent + '%'});

        function checkStatus() {
            $('.mm-survery-content .mm-survey-item').on('click', function () {
                var item;
                item = $(this);
                item.closest('.mm-survey-page').addClass('pass');
            });
        }

        function buildStatus() {
            $('.mm-survery-content .mm-survey-item').on('click', function () {
                var item;
                item = $(this);
                item.addClass('bingo');
                item.closest('.mm-survey-page').addClass('pass');
                $('.mm-survey-container').addClass('good');
            });
        }

        function deliverStatus() {
            $('.mm-survey-item').on('click', function () {
                if ($('.mm-survey-container').hasClass('good')) {
                    $('.mm-survey').addClass('okay');

                } else {
                    $('.mm-survey').removeClass('okay');
                }
                buttonConfig();
            });
        }

        function buttonConfig() {
            if ($('.mm-survey').hasClass('okay')) {
                $('.mm-next-btn button').prop('disabled', false);

            } else {
                $('.mm-next-btn button').prop('disabled', true);
            }
        }

        function submitData() {
            $('.mm-finish-btn').on('click', function () {
                setTimeout(collectData, 100);
            });
        }

        function collectData() {
            $.ajax({
                url: '{{route('load.quiz.answers',['id'=> $quiz->id])}}',
                type: "GET",
                beforeSend: function () {
                    $('#image').show();
                    $('.mm-survey-bottom, .mm-survey-results').hide();
                },
                complete: function () {
                    $('#image').hide();
                    $('.mm-survey-results').show();
                },
                success: function (data) {
                    var map = {}, o = JSON.parse(data), ax = Object.keys(o).map(function (k) {
                            return o[k]
                        }),
                        answer = '', total = 0, ttl = 0, g, c = 0;

                    $('.mm-progress-bar-text').text('Quiz Results Review');

                    $('.mm-survey-item input:checked').each(function (index, val) {
                        var item, data, name, n;

                        item = $(this);
                        data = item.val();
                        name = item.data('item');
                        n = parseInt(data);
                        total += n;

                        map[name] = data;

                    });

                    $('.mm-survey-results-container .mm-survey-results-list').html('');

                    for (i = 1; i <= count; i++) {
                        var t = {}, m = {}, answer_status;
                        answer += map[i] + '<br>';
                        if (map[i] == undefined) {
                            answer_status = 'Your answer:';
                            g = '(empty)';
                            p = 'incorrect';
                            c = 0;

                        } else {
                            if (map[i] == ax[i - 1]) {
                                answer_status = 'Correct answer:';
                                g = map[i];
                                p = 'correct';
                                c = 1;
                            }
                            else {
                                answer_status = 'Your answer:';
                                g = map[i];
                                p = 'incorrect';
                                c = 0;
                            }
                        }

                        $('.mm-survey-results-list').append(
                            '<li class="mm-survey-results-item ' + p + '">' +
                            '<span class="mm-item-number">' + i + '</span>' +
                            '<strong>' + answer_status + '</strong> ' + g + '</span></li>'
                        );

                        m[i] = c;
                        ttl += m[i];
                    }

                    clearTimeout(timeInterval);
                    $('.mm-survey-item input[type=radio]').attr('disabled', 'disabled');

                    var results;
                    results = ((ttl / count) * 100).toFixed(2);

                    $('.mm-survey-results-score').html(results);
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong! Please refresh the page.',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });

            $('html, body').animate({
                scrollTop: $('#online_quiz').offset().top
            }, 500);
        }

        function goBack() {
            $('.mm-back-btn').on('click', function () {
                $('.mm-survey-bottom').slideDown();
                $('.mm-survey-results').slideUp();

                $('html, body').animate({
                    scrollTop: $('#online_quiz').offset().top
                }, 500);
            });
        }
    </script>
@endpush