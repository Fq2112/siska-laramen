@extends('layouts.mst_user')
@section('title', 'Online Quiz (TPA and TKD): '.$vacancy->judul.' - '.$agency->name.' | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/quiz.css')}}">
    <link rel="stylesheet" href="{{asset('css/bubble-button.css')}}">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 7em">
        <div class="fh5co-services">
            <div class="container" style="width: 100%">
                <div class="row">
                    <div class="col-lg-12 section-heading text-center" style="padding-bottom: 0">
                        <h2 class="to-animate" style="text-transform: none;"><span>Online Quiz (TPA & TKD)</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">{{$vacancy->judul.' - '.$agency->name}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="online_quiz">
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
                                                        <td>
                                                            <strong class="time-remaining"
                                                                    style="font-size: 24px;"></strong>
                                                        </td>
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
                                    <div class="status-timer" style="animation-duration:1s">
                                        <i class="fa fa-stopwatch"></i><span class="time-remaining"
                                                                             style="margin-left: 5px"></span>
                                    </div>
                                    @foreach($questions as $question)
                                        @php $options = \App\QuizOptions::where('question_id',$question->id)->get()
                                        ->shuffle()->all(); @endphp
                                        <div class="mm-survey-page" data-page="{{$no++}}">
                                            <div class="mm-survery-content">
                                                <div class="mm-survey-question">
                                                    {!!$question->question_text!!}
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
                                        <form method="post" id="form-submit-quiz">
                                            {{csrf_field()}}
                                            <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="score" id="quiz_score">
                                            <button class="bubbly-button" type="button">Submit</button>
                                        </form>
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

        var x, count, current, percent, quiz_time_limit, timeRemaining, timeInterval, results;

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
            });

            @php $x = 1; $y = 1; @endphp
            @foreach($questions as $question)
            $('.op{{$question->id}}').attr('name', 'op{{$x++}}').attr('data-item', '{{$y++}}');
            @endforeach

            $('.mm-page-1').addClass('active');

            quiz_time_limit = '{{$quiz->time_limit}}';

            var d1 = new Date(),
                d2 = new Date(d1);
            d2.setMinutes(d1.getMinutes() + parseInt(quiz_time_limit));
            timeRemaining = d2.getTime();
            timeInterval = setInterval(reduceTime, 1000);
        }

        function reduceTime() {
            var now = new Date().getTime(), distance = timeRemaining - now,
                days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                hours = pad(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))),
                minutes = pad(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))),
                seconds = pad(Math.floor((distance % (1000 * 60)) / 1000)),
                $time = hours + ':' + minutes + ':' + seconds,
                $class = distance < 60999 ? 'ld ld-heartbeat' : '',
                $color = distance < 60999 ? '#fa5555' : '#00adb5';

            if (distance <= 0) {
                clearInterval(timeInterval);
                swal({
                    title: 'Time\'s up!',
                    type: 'warning',
                }).then(function () {
                    setTimeout(collectData, 100);
                });
                $time = '00:00:00';
            }

            $('.status-timer').addClass($class).css('color', $color);
            $('.time-remaining').text($time).css('color', $color);
        }

        function pad(n) {
            return (n < 10 ? '0' : '') + n;
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
                $('.mm-progress-bar-text').text(results == undefined ? 'Question ' + x + ' of {{count($questions)}}' :
                    'Results Review: Question ' + x + ' of {{count($questions)}}');
                return x;
            });
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
                if (results == undefined) {
                    clearInterval(timeInterval);
                    setTimeout(collectData, 100);

                } else {
                    $('.mm-survey-bottom').slideUp();
                    $('.mm-survey-results').slideDown();
                    $('.mm-progress-bar-text').text('Results Review');

                    $('html, body').animate({
                        scrollTop: $('#online_quiz').offset().top
                    }, 500);
                }
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
                    var map = {},
                        o = JSON.parse(data), ax = Object.keys(o).map(function (k) {
                            return o[k]
                        }),
                        answer = '', total = 0, ttl = 0, g, c = 0;

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

                    $('.mm-survey-progress-bar').css({'width': 100 + '%'});
                    $('.mm-progress-bar-text').text('Results Review');
                    $('.status-timer').removeClass('ld ld-heartbeat');
                    $('.mm-survey').addClass('okay');
                    $('.mm-survey-container').addClass('good');
                    $('.mm-survey-page').addClass('pass');
                    $('.mm-survey-item input[type=radio]').attr('disabled', 'disabled');
                    $('.mm-survey-controller button').removeAttr('disabled');
                    $('.mm-finish-btn button').text('Next');

                    results = ((ttl / count) * 100).toFixed(2);
                    $('.mm-survey-results-score').html(results);
                    $('#quiz_score').val(results);
                    submitQuiz();
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

        function submitQuiz() {
            $.ajax({
                type: "POST",
                url: "{{route('submit.quiz')}}",
                data: new FormData($("#form-submit-quiz")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data) {
                        console.log('Quiz #{{$quiz->unique_code}} is successfully submitted!');
                    }
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
            return false;
        }

        function goBack() {
            $('.mm-back-btn').on('click', function () {
                getCurrentSlide();
                $('.mm-survey-bottom').slideDown();
                $('.mm-survey-results').slideUp();

                $('html, body').animate({
                    scrollTop: $('#online_quiz').offset().top
                }, 500);
            });
        }

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });
    </script>
@endpush