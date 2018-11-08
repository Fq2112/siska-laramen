@extends('layouts.mst_user')
@section('title', 'Agency\'s Home | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">@endpush
@section('content')
    <section id="fh5co-home" data-section="home" data-stellar-background-ratio="0.5"
             style="background-color: #ffffff">
        <div id="carousel-example" class="carousel slide carousel-fullscreen carousel-fade"
             data-ride="carousel">
            <ol class="carousel-indicators">
                @php $i = 0; @endphp
                @foreach($carousels as $row)
                    <li data-target="#carousel-example" data-slide-to="{{$i++}}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($carousels as $row)
                    <div class="item" style="background-image: url({{asset('images/carousel/'.$row->image)}});">
                        <div class="carousel-overlay"></div>
                        <div class="carousel-caption">
                            <h1 class="to-animate">{{$row->title}}</h1>
                            <h2 class="to-animate">{{$row->captions}}</h2>
                        </div>
                    </div>
                @endforeach
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
        <div class="core-features">
            <div class="grid2 to-animate" style="background-image: url({{asset('images/features.jpeg')}});">
            </div>
            <div class="grid2 fh5co-bg-color">
                <div class="core-f">
                    <h2 class="to-animate">Our Programs and Features</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="core">
                                <i class="icon-cloud-download to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Free Download</h3>
                                    <p>Far far away, behind the word mountains, far from the countries
                                        Vokalia and Consonantia, there live the blind texts.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-laptop to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Responsive Layout</h3>
                                    <p>Far far away, behind the word mountains, far from the countries
                                        Vokalia and Consonantia, there live the blind texts.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-hand-paper-o to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>24/7 Help &amp; Support</h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="core">
                                <i class="icon-lightbulb-o to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Free Update</h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-trophy to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Featured Template</h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts.</p>
                                </div>
                            </div>
                            <div class="core">
                                <i class="icon-columns2 to-animate-2"></i>
                                <div class="fh5co-post to-animate">
                                    <h3>Lots of Elements</h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts.</p>
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
                                <div class="price-before-disc">Rp{{number_format($plan->price,2,',','.')}}</div>
                                <div class="price-after-disc">Rp{{$price}}</div>
                                <div class="discount">Save {{$plan->discount}}%</div>
                                <p>{{$plan->caption}}</p>
                                <hr>
                                <p align="justify"><strong>Yang bisa Anda dapatkan:</strong></p>
                                <ul style="margin-bottom: 0">
                                    <li><strong>{{$plan->job_ads}}</strong></li>
                                    @if($plan->id == 2)
                                        <li>Quiz untuk <strong>{{$plan->quiz_applicant}}</strong> applicants</li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_quiz_applicant,0,',','.')}}/applicant</strong>)
                                        </li>
                                    @elseif($plan->id == 3)
                                        <li>Quiz untuk <strong>{{$plan->quiz_applicant}}</strong> applicants</li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_quiz_applicant,0,',','.')}}/applicant</strong>)
                                        </li>
                                        <li>Psycho Test untuk <strong>{{$plan->psychoTest_applicant}}</strong>
                                            applicants
                                        </li>
                                        <li style="list-style: none">(<strong>Rp{{number_format
                                        ($plan->price_psychoTest_applicant,0,',','.')}}/applicant</strong>)
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
                        <h2 class="to-animate"><span>Common Questions</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Segala sesuatu yang Anda harus ketahui sebelum menggunakan
                                    aplikasi SISKA dan kami disini untuk membantu Anda!</h3>
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
                                                    masukkan alamat email yang Anda gunakan untuk akun SISKA Anda.
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
                                                <p>Pertama, masuk ke akun SISKA Anda. Pergi ke ikon profil Anda di
                                                    bagian kanan atas halaman. Klik "Manage Account" yang berbentuk
                                                    seperti simbol gerigi. Isi kolom dan simpang data Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2a"
                                             href="#a2-a03">
                                            <h4 class="panel-title">Bagaimana caranya untuk membuat akun SISKA?
                                                <i class="fa fa-chevron-down pull-right"></i></h4>
                                        </div>
                                        <div id="a2-a03" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Pergi ke halaman utama <a href="http://karir.org">SISKA</a> dan
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
                                                    posting di <a href="http://karir.org">SISKA</a>, klik tombol
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
                                    <div class="panel panel-info to-animate-2">
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
                                                    alamat email yang Anda gunakan untuk akun SISKA Anda. Klik 'Kirim'
                                                    dan kami akan mengirimkan password Anda ke email Anda. Pastikan
                                                    untuk memeriksa spam mail / junk Anda jika Anda tidak dapat
                                                    menemukan email di kotak masuk Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-info to-animate-2">
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
                                                            href="tel:+628563094333">+62-85-6309 4333</a> untuk
                                                    berbicara dengan Business Consultant kami.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-info to-animate-2">
                                        <div class="panel-heading" data-toggle="collapse" data-parent=".accordion-2b"
                                             href="#b2-a03">
                                            <h4 class="panel-title">Berapa harga untuk mengirimkan lowongan
                                                pekerjaan? <i class="fa fa-chevron-down pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="b2-a03" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Silahkan hubungi <a href="tel:+628563094333">+62-85-6309 4333</a>
                                                    untuk berbicara dengan Business Consultant kami mengenai harga jasa
                                                    kami.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-group" id="accordion-2d">
                                    <div class="panel panel-info to-animate-2">
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
                                    <div class="panel panel-info to-animate-2">
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
                <h2>Mengapa beriklan di <span>SISKA ?</span></h2>
                <ul>
                    <li>Iklan lowongan paling terjangkau.</li>
                    <li>Online assessment yang dikembangkan institusi terpercaya.</li>
                    <li>Kostumisasi rekrutmen dan program MT di kampus-kampus ternama.</li>
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
        $('html, body').animate({
            scrollTop: $('#' + window.location.hash).offset().top
        }, 500);

        $(".getting-grid2").click(function () {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 500);
            return false;
        });

        function vacancyCheck(id, job_ads) {
            @guest
            openLoginModal();
            @else
            @if(Auth::user()->isSeeker() || Auth::guard('admin')->check())
            swal({
                title: 'ATTENTION!',
                text: 'This feature only works when you\'re signed in as a Job Agency.',
                type: 'warning',
                timer: '3500'
            });
            @else
            if ('{{\App\Vacancies::where('agency_id',\App\Agencies::where('user_id',Auth::user()->id)->first()->id)
                    ->count()}}' > 0) {

                if ('{{\App\Vacancies::where('agency_id',\App\Agencies::where('user_id',Auth::user()->id)->first()->id)
                        ->where('isPost',false)->count()}}' > 0) {

                    if ('{{\App\Vacancies::where('agency_id',\App\Agencies::where('user_id',Auth::user()->id)->first()->id)
                            ->where('isPost', false)->count()}}' >= job_ads) {
                        $("#form-plans-" + id)[0].submit();
                    }
                    else {
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
                    }

                } else {
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
                }

            } else {
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
            }
            @endif
            @endguest
        }
    </script>
@endpush