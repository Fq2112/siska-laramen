@extends('layouts.mst_user')
@section('title', 'Agency\'s Home | '.env('APP_TITLE'))
@push('styles')
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <style>
        .price-box button {
            margin-left: -65px;
            position: absolute;
            left: 50%;
            bottom: 2em;
        }

        .carousel-caption h1 {
            font-size: 40px;
            text-transform: uppercase;
        }

        .carousel-caption h2 {
            font-size: 24px;
        }

        .carousel-caption h1 span, .carousel-caption h2 span {
            color: #FFC12D;
        }

        .carousel-caption .call-to-action a.demo {
            border: 2px solid #FA5555;
            background: #FA5555;
            text-decoration: none !important;
        }

        .carousel-caption .call-to-action a.download {
            border: 2px solid #00ADB5;
            background: #00ADB5;
            text-decoration: none !important;
        }

        .carousel-caption .call-to-action a {
            width: 230px;
            display: inline-block;
            font-size: 20px;
            padding: 15px 0;
            margin-right: 10px;
            -webkit-box-shadow: 0px 3px 6px -1px rgba(0, 0, 0, 0.19);
            -moz-box-shadow: 0px 3px 6px -1px rgba(0, 0, 0, 0.19);
            -ms-box-shadow: 0px 3px 6px -1px rgba(0, 0, 0, 0.19);
            -o-box-shadow: 0px 3px 6px -1px rgba(0, 0, 0, 0.19);
            box-shadow: 0px 3px 6px -1px rgba(0, 0, 0, 0.19);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            border-radius: 4px;
        }

        #fh5co-home .carousel-caption a {
            color: #fff !important;
            text-decoration: underline;
        }
    </style>
@endpush
@section('content')
    <section id="fh5co-home" data-section="home" data-stellar-background-ratio="0.5"
             style="background-color: #ffffff">
        <div id="carousel-example" class="carousel slide carousel-fullscreen" data-ride="carousel">
            <ol class="carousel-indicators">
                <li class="active" data-target="#carousel-example" data-slide-to="0"></li>
                <li data-target="#carousel-example" data-slide-to="1"></li>
                <li data-target="#carousel-example" data-slide-to="2"></li>

               {{-- @php $i = 3; @endphp
                @foreach($carousels as $row)
                    <li data-target="#carousel-example" data-slide-to="{{$i++}}"></li>
                @endforeach--}}
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image: url({{asset('images/carousel/kariernesia-agency.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate">YOUR FAST FORWARD <span>CAREER</span> SOLUTION PROVIDER</h1>
                        <h2 class="to-animate"><span>{{env('APP_NAME')}}</span> hadir untuk menjembatani para
                            <span>seekers</span> dengan lowongan pekerjaan terbaik secara cepat dan cerdas.
                            Start now to hire or get hired with us!</h2>
                        <div class="call-to-action">
                            <a href="javascript:void(0)" onclick="getStarted()" class="download to-animate">GET STARTED</a>
                            <a href="{{route('home-seeker')}}" class="demo to-animate">JOB SEEKERS</a>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url({{asset('images/carousel/candidates.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate"><span>{{number_format($active_seekers)}}</span> Kandidat Menantimu!</h1>
                        <h2 class="to-animate">Halo <span>agencies</span>! Ayo gabung, lengkapi data perusahaanmu, buat lowongan, dan posting lowonganmu sekarang.</h2>
                        <div class="call-to-action">
                            <a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();"
                               class="download to-animate">JOIN NOW</a>
                            <a href="javascript:void(0)" onclick="goToAnchor('pricing')" class="demo to-animate">POST VACANCY</a>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url({{asset('images/carousel/agencies.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate"><span>{{number_format($active_vacancies)}}</span> Lowongan Menantimu!</h1>
                        <h2 class="to-animate">Halo <span>seekers</span>! Ayo gabung, lengkapi profilmu (CV), dan kirimkan lamaranmu sekarang.</h2>
                        <div class="call-to-action">
                            <a href="{{route('home-seeker')}}#join" class="demo to-animate">JOIN NOW</a>
                            <a href="{{route('search.vacancy')}}" class="download to-animate">SEARCH VACANCY</a>
                        </div>
                    </div>
                </div>

                {{--@foreach($carousels as $row)
                    <div class="item" style="background-image: url({{asset('images/carousel/'.$row->image)}});">
                        <div class="carousel-overlay"></div>
                        <div class="carousel-caption">
                            <h1 class="to-animate">{{$row->title}}</h1>
                            <h2 class="to-animate">{{$row->captions}}</h2>
                        </div>
                    </div>
                @endforeach--}}
            </div>

            <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </section>

    <section id="fh5co-services" data-section="services">
        <div class="fh5co-services core-features">
            <div class="grid2 to-animate" style="background-image: url({{asset('images/features.jpeg')}});"></div>
            <div class="grid2 fh5co-bg-color">
                <div class="core-f">
                    <h2 class="to-animate">Our Programs and Features</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="core">
                                <i class="icon-dollar to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Affordable Job Ads</h3>
                                    <p>Terdapat 3 pilihan paket iklan (Basic, Plus, dan Enterprise) dengan fitur yang
                                        beragam dan harga yang sangat terjangkau.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-smile-o to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Online Quiz</h3>
                                    <p>Quiz/tes yang diberikan adalah TPA dan TKD yang dibuat dan dikembangkan oleh
                                        institusi terpercaya.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-hand-paper-o to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>24/7 Help &amp; Support</h3>
                                    <p>Untuk kepuasan Anda dapatkan Bantuan dan Dukungan secara GRATIS setiap hari
                                        selama 24 jam. Percayakan lowongan Anda kepada {{env('APP_NAME')}} bahkan sebelum, selama,
                                        ataupun sesudah proses job posting.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="core">
                                <i class="icon-calendar to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Customizable Timeline</h3>
                                    <p>Dapat mengatur timeline (jadwal) lowongan, mulai dari tanggal rekruitmen, online
                                        quiz, psycho test, hingga job interview. sesuai dengan paket yang dipilih.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-comments-o to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Psycho Test</h3>
                                    <p>Psiko tes ini berupa video conference (online interview) yang akan dilakukan oleh
                                        psikolog terpercaya.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-graduation-cap to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Recommended Seeker</h3>
                                    <p>Dapat melihat daftar rekomendasi pelamar berdasarkan syarat pengalaman kerja dan
                                        pendidikan minimal dari lowongan aktif yang dimiliki.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-pricing" data-section="pricing">
        <div class="fh5co-pricing">
            <div class="container">
                <div class="row" id="pricing">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Plans Built For Job Agency</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Apakah Anda butuh pelamar kerja yang
                                    <em> passionate</em> dan lebih kompeten untuk perusahaan Anda?
                                    Pasang iklan lowongan kerja Anda sekarang!</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($plans as $plan)
                        @php
                            $price = number_format($plan->price - ($plan->price * $plan->discount/100),2,',','.');
                            $number = filter_var($plan->job_ads,FILTER_SANITIZE_NUMBER_INT);
                            $totalAds = array_sum(str_split($number));
                        @endphp
                        <div class="col-lg-4 to-animate">
                            <div class="price-box {{$plan->isBest == true ? 'popular' : ''}}">
                                <div class="popular-text"
                                     style="display: {{$plan->isBest == true ? 'block' : 'none'}};">
                                    Best Value
                                </div>
                                <h2 class="pricing-plan">{{$plan->name}}</h2>
                                @if($plan->discount > 0)
                                    <div class="price-before-disc">Rp{{number_format($plan->price,2,',','.')}}</div>
                                    <div class="price-after-disc">Rp{{$price}}</div>
                                    <div class="discount">Save {{$plan->discount}}%</div>
                                @else
                                    <div class="price-after-disc">Rp{{number_format($plan->price,2,',','.')}}</div>
                                @endif
                                <p>{{$plan->caption}}</p>
                                <hr>
                                <ul style="margin-bottom: 0">
                                    <li><strong>{{$plan->job_ads}}</strong></li>
                                    @if($plan->id == 2)
                                        <li>Quiz untuk <strong>{{$plan->quiz_applicant}}</strong> partisipan</li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_quiz_applicant,0,',','.')}}/participant</strong>)
                                        </li>
                                    @elseif($plan->id == 3)
                                        <li>Quiz untuk <strong>{{$plan->quiz_applicant}}</strong> partisipan</li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_quiz_applicant,0,',','.')}}/participant</strong>)
                                        </li>
                                        <li>Psycho Test untuk <strong>{{$plan->psychoTest_applicant}}</strong>
                                            partisipan
                                        </li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_psychoTest_applicant,0,',','.')}}/participant</strong>)
                                        </li>
                                    @endif
                                </ul>
                                {!! $plan->benefit !!}
                                <form id="form-plans-{{$plan->id}}" action="{{route('show.job.posting',
                                        ['id'=>encrypt($plan->id)])}}">
                                    <button type="button" class="btn btn-primary"
                                            onclick="vacancyCheck('{{$plan->id}}','{{$totalAds}}')">
                                        <strong>Post Now</strong>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-faq" class="fh5co-bg-color" data-section="faq">
        <div class="fh5co-faq">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class=""><span>Common Questions</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="">Segala sesuatu yang Anda harus ketahui sebelum menggunakan
                                    aplikasi {{env('APP_NAME')}} dan kami disini untuk membantu Anda!</h3>
                            </div>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="faq-nav-tabs">
                                    <li class="{{ \Illuminate\Support\Facades\Request::is('/*') ? 'active' : '' }}"
                                        id="faq-s">
                                        <a data-toggle="tab" href="#seeker">
                                            FAQ Job Seeker</a></li>
                                    <li class="{{ \Illuminate\Support\Facades\Request::is('agency*') ? 'active' : '' }}"
                                        id="faq-a">
                                        <a data-toggle="tab" href="#agency">
                                            FAQ Job Agency</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="tab-content">
                        <div id="seeker"
                             class="tab-pane fade in {{\Illuminate\Support\Facades\Request::is('/*') ? 'active' : ''}}">
                            <div class="col-md-6">
                                <div class="panel-group" id="accordion-2a">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#a2-a01">
                                            <h4 class="panel-title">Memiliki masalah untuk login?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-a01" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Jangan khawatir, ini terjadi pada semua orang. Jika Anda lupa
                                                    password Anda, klik "Lupa?" di atas kotak sign in, kemudian
                                                    masukkan alamat email yang Anda gunakan untuk akun {{env('APP_NAME')}} Anda.
                                                    Klik "Kirim" dan kami akan mengirimkan password Anda ke email
                                                    Anda. Pastikan untuk memeriksa spam mail / junk Anda jika Anda
                                                    tidak dapat menemukan email di kotak masuk Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#a2-a02">
                                            <h4 class="panel-title">Bagaimana caranya saya untuk mengubah password?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-a02" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Pertama, masuk ke akun {{env('APP_NAME')}} Anda. Pergi ke ikon profil Anda di
                                                    bagian kanan atas halaman. Klik "Manage Account" yang berbentuk
                                                    seperti simbol gerigi. Isi kolom dan simpang data Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#a2-a03">
                                            <h4 class="panel-title">Bagaimana caranya untuk membuat akun {{env('APP_NAME')}}?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-a03" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Pergi ke halaman utama <a href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a> dan
                                                    mengisi kolom yang diperlukan dalam kotak sign up dan klik.
                                                    Setelah Anda telah mengirimkan informasi, silahkan cek email Anda
                                                    untuk mengaktifkan akun Anda. Pastikan untuk memeriksa spam mail
                                                    / junk Anda jika Anda tidak dapat menemukan email konfirmasi di
                                                    kotak masuk Anda.</p>

                                                <p>Setelah Anda telah mengaktifkan akun Anda , ketika Anda pertama
                                                    kali masuk , silahkan mengisi informasi dasar yang diperlukan.
                                                    Berikutnya, Anda dapat menulis resume Anda dengan mengisi
                                                    kolom-kolom yang tersedia. Menulis resume Anda dengan lengkap
                                                    sangat penting untuk meningkatkan kesempatan Anda untuk berkarir.
                                                    Pastikan resume Anda lengkap dan selalu diperbarui.</p>

                                                <p>Cukup mencari jenis karir yang Anda inginkan dan pada setiap
                                                    posting di <a href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a>, klik tombol
                                                    "apply" untuk melamar. Setelah Anda menyelesaikan
                                                    langkah-langkah, resume Anda akan dikirim ke Perusahaan. Anda
                                                    akan melihat pada deskripsi karir, tombol "apply" akan berubah
                                                    menjadi "applied".</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-group" id="accordion-2b">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#a2-b01">
                                            <h4 class="panel-title">Siapakah yang melihat resume saya?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-b01" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Ketika Anda membuat resume Anda, semua Perusahaan akan dapat
                                                    melihat resume Anda secara default. Namun, hanya perusahaan yang
                                                    berprospektif sajalah yang bisa melihat kontak informasi Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#a2-b02">
                                            <h4 class="panel-title">Mengapa saya tidak mendapat respon
                                                setelah apply secara online?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-b02" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Setiap Perusahaan memiliki metode sendiri untuk mengevaluasi resume.
                                                    Beberapa Perusahaan dapat mengirimkan balasan email otomatis atau
                                                    menghubungi Anda untuk merespon lamaran Anda. Namun, ada Perusahaan
                                                    yang
                                                    tidak akan menghubungi Anda kecuali mereka ingin memulai proses
                                                    wawancara.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#a2-b03">
                                            <h4 class="panel-title">Bagaimana caranya agar peluang saya untuk
                                                direkrut lebih besar?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-b03" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Membuat resume yang benar-benar menonjol. Anda ingin menyoroti
                                                    pengalaman spesifik dan peran Anda sehingga perusahaan tahu Anda
                                                    akan cocok dengan kebutuhan mereka. Menambahkan lebih banyak
                                                    pengalaman, pendidikan, sertifikasi dan keterampilan akan sangat
                                                    membantu.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="agency"
                             class="tab-pane fade in {{\Illuminate\Support\Facades\Request::is('agency*') ? 'active' : ''}}">
                            <div class="col-md-6">
                                <div class="panel-group" id="accordion-2c">
                                    <div class="panel panel-info">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#b2-a01">
                                            <h4 class="panel-title">Memiliki masalah untuk login?
                                                <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-a01" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Jangan khawatir, ini terjadi pada semua orang. Jika Anda lupa
                                                    password Anda, klik 'Lupa?' di atas kotak sign in, kemudian masukkan
                                                    alamat email yang Anda gunakan untuk akun {{env('APP_NAME')}} Anda. Klik 'Kirim'
                                                    dan kami akan mengirimkan password Anda ke email Anda. Pastikan
                                                    untuk memeriksa spam mail / junk Anda jika Anda tidak dapat
                                                    menemukan email di kotak masuk Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#b2-a02">
                                            <h4 class="panel-title">Bagaimana caranya saya untuk mengirimkan
                                                lowongan pekerjaan? <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-a02" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Pertama, Anda akan perlu untuk mendaftar sebagai Employer. Karena
                                                    kami saat ini sedang dalam proses untuk meningkatkan produk dan
                                                    layanan kami, Konsultan Bisnis kami akan membantu Anda dalam posting
                                                    peluang karir di website kami. Silahkan hubungi <a
                                                            href="tel:{{env('APP_PHONE')}}">{{env('APP_PHONE')}}</a> untuk
                                                    berbicara dengan Business Consultant kami.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#b2-a03">
                                            <h4 class="panel-title">Berapa harga untuk mengirimkan lowongan
                                                pekerjaan? <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-a03" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Silahkan hubungi <a href="tel:{{env('APP_PHONE')}}">{{env('APP_PHONE')}}</a>
                                                    untuk berbicara dengan Business Consultant kami mengenai harga jasa
                                                    kami.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-group" id="accordion-2d">
                                    <div class="panel panel-info">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#b2-b01">
                                            <h4 class="panel-title">Bagaimana caranya untuk membayar?
                                                <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-b01" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Anda dapat menghubungi kami untuk mendiskusikan pilihan pembayaran
                                                    dan paket produk yang Anda inginkan. Kami tidak menyediakan
                                                    pembayaran online tapi dapat beberapa pilihan bagi Anda untuk
                                                    melakukan pembayaran dengan mudah dan cepat.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#b2-b02">
                                            <h4 class="panel-title">
                                                Bagaimana caranya untuk menaikkan jumlah pelamar pekerjaan?
                                                <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-b02" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Buatlah deskripsi karir yang menarik. Anda juga dapat
                                                    mempertimbangkan untuk memasukkan kisaran gaji sehingga pencari
                                                    karir akan lebih tertarik ketika menemukan posting Anda.
                                                    Akhirnya, pastikan bahwa deskripsi perusahaan Anda adalah akurat
                                                    dan terkini.</p>
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
    </section>

    <div class="getting-started getting-started-1">
        <div class="getting-grid" style="background-image: url({{asset('images/full_image_3.jpg')}});">
            <div class="desc" id="list-ads">
                <h2>Mengapa beriklan di <span>{{env('APP_NAME')}}</span> ?</h2>
                <ul>
                    <li>Iklan lowongan paling terjangkau dengan fitur yang beragam.</li>
                    <li>Kostumisasi jadwal rekruitmen.</li>
                    <li>Online assessment yang dikembangkan institusi terpercaya.</li>
                </ul>
            </div>
        </div>
        <a href="#pricing" class="getting-grid2">
            <div class="call-to-action text-center">
                <p class="sign-up">Pasang Iklan Sekarang <i class="fa fa-hand-point-right"></i></p>
            </div>
        </a>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            var price_div = $(".price-box"),
                heights = price_div.map(function() { return $(this).height(); }).get(),
                maxHeight = Math.max.apply(null, heights);
            price_div.height(maxHeight + 21);
        });

        if (window.location.hash) {
            if(window.location.hash == '#join') {
                openRegisterModal();
            } else {
                $('#first-navbar').addClass('navbar-fixed-top fh5co-animated slideInDown');

                $('html, body').animate({
                    scrollTop: $('#' + window.location.hash).offset().top
                }, 500);
            }
        }

        $(".getting-grid2").click(function () {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 500);
            return false;
        });

        function getStarted() {
            $('html, body').animate({
                scrollTop: $('[data-section="services"]').offset().top + 100
            }, 500);
        }

        function goToAnchor(selector) {
            $('html, body').animate({
                scrollTop: $('#' + selector).offset().top + 100
            }, 500);
        }

        function vacancyCheck(id, job_ads) {
            @auth('admin')
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Agency.',
                type: 'warning',
                timer: '3500'
            });
            @else
            @if(Auth::check() && Auth::user()->isAgency())
            $.get("{{route('get.vacancyCheck',['id' => ''])}}/" + id, function (data) {
                if (data == 0) {
                    swal({
                        title: 'ATTENTION!',
                        text: "There seems to be none of the vacancy was found. If you want to post some vacancy, " +
                            "please go to the Vacancy Setup to make it.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00ADB5',
                        confirmButtonText: 'Yes, redirect me to the Vacancy Setup page.',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.location.href = '{{route('agency.vacancy.show')}}';
                            });
                        },
                        allowOutsideClick: false
                    });
                    return false;

                } else if (data == 1) {
                    swal({
                        title: 'ATTENTION!',
                        text: "All of your vacancies have been posted. If you want to post another vacancy, " +
                            "please go to the Vacancy Setup to make another one.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00ADB5',
                        confirmButtonText: 'Yes, redirect me to the Vacancy Setup page.',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.location.href = '{{route('agency.vacancy.show')}}';
                            });
                        },
                        allowOutsideClick: false
                    });
                    return false;

                } else if (data == 2) {
                    swal({
                        title: 'ATTENTION!',
                        text: "This package requires at least " + job_ads + " Vacancy that have not been posted yet. It seems that the amount of your vacancy doesn't meet the minimal amount of this package.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00ADB5',
                        confirmButtonText: 'Yes, redirect me to the Vacancy Setup page.',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.location.href = '{{route('agency.vacancy.show')}}';
                            });
                        },
                        allowOutsideClick: false
                    });
                    return false;

                } else if (data == 3) {
                    $("#form-plans-" + id)[0].submit();

                } else if (data == 4) {
                    swal({
                        title: 'ATTENTION!',
                        text: "It seems that your company profile is incomplete.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00ADB5',
                        confirmButtonText: 'Yes, redirect me to Edit Profile page.',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.location.href = '{{route('agency.edit.profile')}}';
                            });
                        },
                        allowOutsideClick: false
                    });
                    return false;
                }
            });
            @else
            openLoginModal();
            @endif
            @endauth
        }
    </script>
@endpush
