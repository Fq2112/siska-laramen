@extends('layouts.mst_user')
@section('title', 'Quiz (Online TPA & TKD) | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <style>
        button[disabled] {
            cursor: no-drop;
        }

        .mm-survey {
            width: 75%;
            margin: 0 auto;
            border-radius: 2px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            transition: box-shadow .25s;
        }

        .mm-survey:hover {
            box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .mm-survey-container {
            width: 100%;
            background: #fff;
        }

        .mm-survey-results-container {
            width: 100%;
            min-height: 430px;
            background: #fff;
        }

        .mm-survey-page {
            display: none;
            font-weight: 100;
            padding: 40px;
        }

        .mm-survey-page.active {
            display: block;
        }

        .mm-survey-controller {
            position: relative;
            height: 60px;
            background: #41444B;
        }

        .mm-survey-results-controller {
            position: relative;
            height: 60px;
            background: #41444B;
        }

        .mm-back-btn {
            display: inline-block;
            position: relative;
            float: left;
            margin: 12px 15px;
        }

        .mm-prev-btn {
            display: inline-block;
            position: relative;
            float: left;
            margin: 12px 15px;
        }

        .mm-next-btn {
            display: inline-block;
            opacity: 0.55;
            position: relative;
            float: right;
            margin: 12px 15px;
        }

        .mm-finish-btn {
            display: none;
            position: relative;
            float: right;
            margin: 12px 15px;
        }

        .mm-finish-btn button {
            background: #3DD2AF !important;
            color: #fff;
        }

        .mm-survey-results-controller button {
            background: #fff;
            border: none;
            padding: 8px 18px;
        }

        .mm-survey-progress {
            width: 100%;
            height: 30px;
            background: #f5f5f5;
            overflow: hidden;
        }

        .mm-progress {
            transition: width 0.5s ease-in-out;
        }

        .mm-survey-progress-bar {
            height: 30px;
            width: 0;
            background: linear-gradient(to left, #66ced3, #fb7777);
        }

        .mm-survey-q {
            list-style-type: none;
            padding: 0;
        }

        .mm-survey-q li {
            display: block;
            /*padding: 20px 0;*/
            margin-bottom: 10px;
            width: 100%;
            background: #fff;
        }

        .mm-survey-q li input {
            width: 100%;
        }

        .mm-survery-content label {
            width: 100%;
            padding: 10px 10px;
            margin: 0 !important;
        }

        .mm-survery-content label:hover {
            cursor: pointer;
        }

        .mm-survey-question p {
            font-size: 22px;
            font-weight: 200;
            margin-bottom: 20px;
            line-height: 40px;
        }

        .mm-survery-content label p {
            display: inline-block;
            position: relative;
            top: 2px;
            left: 5px;
            margin: 0;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"] + label {
            color: #292321;
            font-weight: 300;
            font-size: 16px;
        }

        input[type="radio"] + label span {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin: 2px 4px 0 0;
            vertical-align: middle;
            cursor: pointer;
            -moz-border-radius: 50%;
            border-radius: 50%;
        }

        input[type="radio"] + label span {
            background: #fff;
            border: 2px solid #b4b4b4;
            transition: all 250ms ease;
        }

        input[type="radio"]:checked + label span {
            background: #fa5555;
            border: 2px solid #fa5555;
            box-shadow: inset 0 0 0 4px #f7f7f7;
        }

        .mm-survey-item {
            background: #f7f7f7;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(247, 247, 247, 0.15);
            border-radius: 0 0 4px 4px;
        }

        .mm-survey-item:hover {
            background: #eee;
        }

        .mm-survey-item:active {
            background: #ddd;
        }

        .mm-prev-btn button:focus, .mm-next-btn button:focus, .mm-finish-btn button:focus {
            outline: none;
            border: none;
        }

        .mm-survey.okay .mm-next-btn {
            display: inline-block;
            opacity: 1;
        }

        .mm-finish-btn.active {
            display: inline-block;
        }

        .mm-survey-results {
            display: none;
        }

        .mm-survey-results-score {
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 80px;
            font-weight: 600;
            letter-spacing: -6px;
        }

        .mm-survey-results-list {
            list-style-type: none;
            padding: 0 15px;
            margin: 0;
        }

        .mm-survey-results-item {
            color: #fff;
            margin-top: 10px;
            padding: 15px 15px 15px 0;
            font-weight: 300;
        }

        .mm-survey-results-item.correct {
            background: linear-gradient(to left, #00adb5, #66ced3);
        }

        .mm-survey-results-item.incorrect {
            background: linear-gradient(to left, #fa5555, #fb7777);
        }

        .mm-item-number {
            height: 40px;
            position: relative;
            padding: 17px;
            background: #333;
            color: #fff;
        }

        .mm-item-info {
            float: right;
        }

        .animate {
            transition: all 0.1s;
            -webkit-transition: all 0.1s;
        }

        .bubbly-button {
            font-family: 'Pacifico', cursive;
            display: inline-block;
            padding: 3px 40px;
            -webkit-appearance: none;
            color: #fff;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
        }

        .mm-prev-btn .bubbly-button, .mm-next-btn .bubbly-button, .mm-back-btn .bubbly-button {
            background-color: #fa5555;
            box-shadow: 0 2px 25px rgba(250, 85, 85, 0.5);
        }

        .mm-finish-btn .bubbly-button {
            background-color: #00adb5;
            box-shadow: 0 2px 25px rgba(0, 173, 181, 0.5);
        }

        .bubbly-button:focus {
            outline: 0;
        }

        .bubbly-button:before, .bubbly-button:after {
            position: absolute;
            content: '';
            display: block;
            width: 140%;
            height: 100%;
            left: -20%;
            z-index: -1000;
            transition: all ease-in-out 0.5s;
            background-repeat: no-repeat;
        }

        .bubbly-button:before {
            display: none;
            top: -75%;
            background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
        }

        .bubbly-button:after {
            display: none;
            bottom: -75%;
            background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
        }

        .bubbly-button:active {
            transform: scale(0.9);
        }

        .mm-prev-btn .bubbly-button:before, .mm-next-btn .bubbly-button:before, .mm-back-btn .bubbly-button:before {
            background-image: radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, transparent 20%, #fa5555 20%, transparent 30%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, transparent 10%, #fa5555 15%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%);
        }

        .mm-prev-btn .bubbly-button:after, .mm-next-btn .bubbly-button:after, .mm-back-btn .bubbly-button:after {
            background-image: radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, transparent 10%, #fa5555 15%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%), radial-gradient(circle, #fa5555 20%, transparent 20%);
        }

        .mm-finish-btn .bubbly-button:before {
            background-image: radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, transparent 20%, #00adb5 20%, transparent 30%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, transparent 10%, #00adb5 15%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%);
        }

        .mm-finish-btn .bubbly-button:after {
            background-image: radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, transparent 10%, #00adb5 15%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%), radial-gradient(circle, #00adb5 20%, transparent 20%);
        }

        .mm-prev-btn .bubbly-button:active, .mm-next-btn .bubbly-button:active, .mm-back-btn .bubbly-button:active {
            background-color: #b13e3e;
            box-shadow: 0 2px 25px rgba(177, 62, 62, 0.2);
        }

        .mm-finish-btn .bubbly-button:active {
            background-color: #006269;
            box-shadow: 0 2px 25px rgba(0, 98, 105, 0.2);
        }

        .bubbly-button.animate:before {
            display: block;
            animation: topBubbles ease-in-out 0.75s forwards;
        }

        .bubbly-button.animate:after {
            display: block;
            animation: bottomBubbles ease-in-out 0.75s forwards;
        }

        @keyframes topBubbles {
            0% {
                background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
            }
            50% {
                background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
            }
            100% {
                background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }

        @keyframes bottomBubbles {
            0% {
                background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
            }
            50% {
                background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
            }
            100% {
                background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }
    </style>
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 7em">
        <div class="fh5co-services">
            <div class="container" style="width: 100%">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12 section-heading text-center" style="padding-bottom: 0">
                            <h2 class="to-animate" style="text-transform: none;font-size: 18px;letter-spacing: 1px">
                                <span><strong>Quiz (Online TPA & TKD)</strong></span>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mm-survey">

                            <div class="mm-survey-progress">
                                <div class="mm-survey-progress-bar mm-progress"></div>
                            </div>

                            <div class="mm-survey-results">
                                <div class="mm-survey-results-container">
                                    <h3 class="mm-survey-results-score"></h3>
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
                                    <div class="mm-survey-page active" data-page="1">
                                        <div class="mm-survery-content">
                                            <div class="mm-survey-question">
                                                <p>Based on history... What is the ideal color for a Ferrari?</p>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio01" data-item="1" name="radio1"
                                                       value="red">
                                                <label for="radio01"><span></span>
                                                    <p>Red</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio02" data-item="1" name="radio1"
                                                       value="blue">
                                                <label for="radio02"><span></span>
                                                    <p>Blue</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio03" data-item="1" name="radio1"
                                                       value="green">
                                                <label for="radio03"><span></span>
                                                    <p>Green</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio04" data-item="1" name="radio1"
                                                       value="purple">
                                                <label for="radio04"><span></span>
                                                    <p>Purple</p></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mm-survey-page" data-page="2">
                                        <div class="mm-survery-content">
                                            <div class="mm-survey-question">
                                                <p>Which one of these car brands is made in Germany?</p>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio05" data-item="2" name="radio2"
                                                       value="honda">
                                                <label for="radio05"><span></span>
                                                    <p>Honda</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio06" data-item="2" name="radio2"
                                                       value="ford">
                                                <label for="radio06"><span></span>
                                                    <p>Ford</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio07" data-item="2" name="radio2"
                                                       value="mercedes">
                                                <label for="radio07"><span></span>
                                                    <p>Mercedes</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio08" data-item="2" name="radio2"
                                                       value="ferrari">
                                                <label for="radio08"><span></span>
                                                    <p>Ferrari</p></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mm-survey-page" data-page="3">
                                        <div class="mm-survery-content">
                                            <div class="mm-survey-question">
                                                <p>Which is the correct integer for Pi?</p>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio09" data-item="3" name="radio3" value="3">
                                                <label for="radio09"><span></span>
                                                    <p>3</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio10" data-item="3" name="radio3" value="4">
                                                <label for="radio10"><span></span>
                                                    <p>4</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio11" data-item="3" name="radio3"
                                                       value="3.41">
                                                <label for="radio11"><span></span>
                                                    <p>3.41</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio12" data-item="3" name="radio3"
                                                       value="3.14">
                                                <label for="radio12"><span></span>
                                                    <p>3.14</p></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mm-survey-page" data-page="4">
                                        <div class="mm-survery-content">
                                            <div class="mm-survey-question">
                                                <p>The letter 'C' is the nth number in the alphabet, choose the correct
                                                    number.</p>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio13" data-item="4" name="radio4" value="1">
                                                <label for="radio13"><span></span>
                                                    <p>1</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio14" data-item="4" name="radio4" value="2">
                                                <label for="radio14"><span></span>
                                                    <p>2</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio15" data-item="4" name="radio4" value="3">
                                                <label for="radio15"><span></span>
                                                    <p>3</p></label>
                                            </div>
                                            <div class="mm-survey-item">
                                                <input type="radio" id="radio16" data-item="4" name="radio4" value="4">
                                                <label for="radio16"><span></span>
                                                    <p>4</p></label>
                                            </div>
                                        </div>
                                    </div>
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
    <script>
        $('.mm-prev-btn').hide();

        var x;
        var count;
        var current;
        var percent;
        var z = [];

        init();
        getCurrentSlide();
        goToNext();
        goToPrev();
        getCount();
        // checkStatus();
        // buttonConfig();
        buildStatus();
        deliverStatus();
        submitData();
        goBack();

        function init() {

            $('.mm-survey-container .mm-survey-page').each(function () {

                var item;
                var page;

                item = $(this);
                page = item.data('page');

                item.addClass('mm-page-' + page);
                //item.html(page);

            });

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
                var y = (count + 1);
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
            });

        }

        function goToPrev() {

            $('.mm-prev-btn').on('click', function () {
                goToSlide(x);
                getCount();
                current = (x - 1);
                var g = current / count;
                buildProgress(g);
                var y = count;
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
                else {

                }

                return x;

            });

        }

        function getButtons() {

            if (current === 0) {
                current = y;
            }
            if (current === count) {
                $('.mm-next-btn').hide();
            }
            else if (current === 1) {
                $('.mm-prev-btn').hide();
            }
            else {
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
                else {
                    //
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
                }
                else {
                    $('.mm-survey').removeClass('okay');
                }
                buttonConfig();
            });
        }

        function lastPage() {
            if ($('.mm-next-btn').hasClass('cool')) {
                alert('cool');
            }
        }

        function buttonConfig() {
            if ($('.mm-survey').hasClass('okay')) {
                $('.mm-next-btn button').prop('disabled', false);
            }
            else {
                $('.mm-next-btn button').prop('disabled', true);
            }
        }

        function submitData() {
            $('.mm-finish-btn').on('click', function () {
                collectData();
                $('.mm-survey-bottom').slideUp();
                $('.mm-survey-results').slideDown();
            });
        }

        function collectData() {

            var map = {};
            var ax = ['0', 'red', 'mercedes', '3.14', '3'];
            var answer = '';
            var total = 0;
            var ttl = 0;
            var g;
            var c = 0;

            $('.mm-survey-item input:checked').each(function (index, val) {
                var item;
                var data;
                var name;
                var n;

                item = $(this);
                data = item.val();
                name = item.data('item');
                n = parseInt(data);
                total += n;

                map[name] = data;

            });

            $('.mm-survey-results-container .mm-survey-results-list').html('');

            for (i = 1; i <= count; i++) {

                var t = {};
                var m = {};
                answer += map[i] + '<br>';

                if (map[i] === ax[i]) {
                    g = map[i];
                    p = 'correct';
                    c = 1;
                }
                else {
                    g = map[i];
                    p = 'incorrect';
                    c = 0;
                }

                $('.mm-survey-results-list').append('<li class="mm-survey-results-item ' + p + '"><span class="mm-item-number">' + i + '</span><span class="mm-item-info">' + g + ' - ' + p + '</span></li>');

                m[i] = c;
                ttl += m[i];

            }

            var results;
            results = ((ttl / count) * 100).toFixed(0);

            $('.mm-survey-results-score').html(results + '%');

        }

        function goBack() {
            $('.mm-back-btn').on('click', function () {
                $('.mm-survey-bottom').slideDown();
                $('.mm-survey-results').slideUp();
            });
        }

        var animateButton = function (e) {

            e.preventDefault;
            //reset animation
            e.target.classList.remove('animate');

            e.target.classList.add('animate');
            setTimeout(function () {
                e.target.classList.remove('animate');
            }, 700);
        };

        var bubblyButtons = document.getElementsByClassName("bubbly-button");

        for (var i = 0; i < bubblyButtons.length; i++) {
            bubblyButtons[i].addEventListener('click', animateButton, false);
        }
    </script>
@endpush