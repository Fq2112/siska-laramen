@extends('layouts.mst_user')
@section('title', 'Seeker\'s Home | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <style>
        [data-scrollbar] {
            max-height: 550px;
        }
    </style>
@endpush
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
        {{--job vacancies--}}
        <div class="fh5co-services">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 section-heading text-center">
                        <h2 class="to-animate"><span>Job Vacancies</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Pilihlah lowongan kerja sesuai dengan yang Anda inginkan dan
                                    segera daftarkan diri Anda!</h3>
                            </div>
                            <div class="col-md-12 to-animate-2">
                                <ul class="nav nav-tabs to-animate" id="faq-nav-tabs">
                                    <li class="active" id="faq-s">
                                        <a data-toggle="tab" href="#popular">Most Popular Vacancy</a>
                                    </li>
                                    <li id="faq-a">
                                        <a data-toggle="tab" href="#latest">Latest Vacancy</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dc-view-switcher to-animate-2"
                             style="margin-top: 1em;margin-bottom: -2.5em;margin-right: -.8em">
                            <label>View: </label>
                            <button data-trigger="grid-view"></button>
                            <button data-trigger="list-view" class="active"></button>
                        </div>
                    </div>
                </div>
                <div class="row to-animate">
                    <div class="tab-content">
                        <div id="popular" class="tab-pane to-animate active row">
                            <div class="row">
                                <div class="col-lg-12" data-scrollbar>
                                    <img src="{{asset('images/loading3.gif')}}" id="image"
                                         class="img-responsive ld ld-breath">
                                    <div data-view="list-view" class="download-cards" id="fav-list-vacancy">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="latest" class="tab-pane to-animate row">
                            <div class="row">
                                <div class="col-lg-12" data-scrollbar>
                                    <div data-view="list-view" class="download-cards" id="late-list-vacancy"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center to-animate-2">
                        <hr style="margin-top: 0">
                        <a href="{{route('search.vacancy')}}">
                            <button class="btn btn myBtn">
                                show more vacancy <i class="fa fa-search-plus"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{--favorite agencies--}}
        <div class="fh5co-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Most Favorite Agencies</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Perusahaan-perusahaan terfavorit ini mencari talenta seperti
                                    Anda. Jadi, tunggu apa lagi?!</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 to-animate" data-scrollbar>
                                @foreach($agencies as $agency)
                                    <div class="col-lg-4">
                                        <article class="download-card Card">
                                            <a href="{{$agency->link}}">
                                                <div class="download-card__icon-box">
                                                    @if(\App\User::find($agency->user_id)->ava == ""||
                                                    \App\User::find($agency->user_id)->ava == "agency.png")
                                                        <img src="{{asset('images/agency.png')}}">
                                                    @else
                                                        <img src="{{asset('storage/users/'.\App\User::find
                                                        ($agency->user_id)->ava)}}">
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="Card-thumbnailOverlay">
                                                <div class="text-center">
                                                    <a href="{{route('agency.profile',['id'=>$agency->id])}}">
                                                        <button class="Card-Btn">
                                                            <strong>
                                                                {{\App\User::find($agency->user_id)->name}}</strong>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--best vacancies--}}
        <div class="fh5co-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Best Vacancies in your city</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Peluang karier menarik telah menanti Anda di
                                    kota-kota berikut!</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 to-animate">
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 red">
                                        <img src="{{asset('images/cities/surabaya.jpg')}}" alt="Surabaya">
                                        <figcaption>
                                            <h3><span> Surabaya</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'surabaya'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 blue">
                                        <img src="{{asset('images/cities/jakarta.jpg')}}" alt="Jakarta"/>
                                        <figcaption>
                                            <h3><span> Jakarta</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'jakarta'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104">
                                        <img src="{{asset('images/cities/yogyakarta.jpg')}}"
                                             alt="Yogyakarta"/>
                                        <figcaption>
                                            <h3><span> Yogyakarta</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'yogyakarta'])}}"></a>
                                    </figure>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 red">
                                        <img src="{{asset('images/cities/makassar.jpg')}}" alt="Makassar"/>
                                        <figcaption>
                                            <h3><span> Makassar</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'makassar'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 blue">
                                        <img src="{{asset('images/cities/bandung.jpg')}}" alt="Bandung"/>
                                        <figcaption>
                                            <h3><span> Bandung</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'bandung'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104">
                                        <img src="{{asset('images/cities/medan.jpg')}}" alt="Medan"/>
                                        <figcaption>
                                            <h3><span> Medan</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['loc'=>'medan'])}}"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-explore" data-section="explore">
        {{--industries--}}
        <div class="fh5co-explore">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Favorite Industries</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">
                                    Apa industri favorit Anda? Temukan peluang karir di industri berikut!</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="responsive-list">
                                    <ul id="responsive-list-content">
                                        @foreach($favIndustries as $row)
                                            <li style="background-image: url({{asset('images/industries/'.$row->icon)}})">
                                                <div class="card-front">
                                                    <h2><b>{{$row->nama}}</b></h2></div>
                                                <div class="card-back" id="card-back-text">
                                                    <a href="{{route('search.vacancy',['industry_ids'=> $row->id])}}">
                                                        <h2>
                                                            <b>
                                                                {{count(\App\Vacancies::where('industry_id',$row->id)->get())}}
                                                                lowongan
                                                            </b>
                                                        </h2>
                                                    </a>
                                                </div>
                                                <!-- Content -->
                                                <div class="all-content">
                                                    <h1>&nbsp;</h1>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--most sought job--}}
        <div class="fh5co-explore">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Most Sought Jobs in 2018</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">
                                    Nah, ini dia posisi-posisi pekerjaan yang paling banyak dicari tahun ini!</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 red">
                                        <img src="{{asset('images/job/developing.jpg')}}" alt="Surabaya"/>
                                        <figcaption>
                                            <h3><span> Teknologi Informasi</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['jobfunc_ids'=> '79,85,86,87,88,89,90,91'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104 blue">
                                        <img src="{{asset('images/job/sales.jpeg')}}" alt="Jakarta"/>
                                        <figcaption>
                                            <h3><span> Penjualan</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['jobfunc_ids'=> '59,60,61'])}}"></a>
                                    </figure>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <figure class="snip1104">
                                        <img src="{{asset('images/job/marketing.jpeg')}}"
                                             alt="Yogyakarta"/>
                                        <figcaption>
                                            <h3><span> Pemasaran</span></h3>
                                        </figcaption>
                                        <a href="{{route('search.vacancy',['jobfunc_ids'=> '51,52,53,59'])}}"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @guest
        <div class="getting-started getting-started-1" style="background: #FA5555">
            <div class="getting-grid" style="background-image:  url({{asset('images/join.jpeg')}});">
                <div class="desc" id="list-ads">
                    <h2>Mengapa harus membuat akun <span>SISKA</span> ?</h2>
                    <ul>
                        <li>Rekomendasi lowongan sesuai resume.</li>
                        <li>Resume akan langsung dikirimkan ke agency terkait ketika rekruitmennya berakhir.</li>
                        <li>Akses gratis online quiz (TPA & TKD) dan psycho test (Online Interview) oleh ahli
                            psikologi.
                        </li>
                    </ul>
                </div>
            </div>
            <a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();" class="getting-grid2">
                <div class="call-to-action text-center">
                    <p class="sign-up">Buat Akun Sekarang <i class="fa fa-hand-point-right"></i></p>
                </div>
            </a>
        </div>
    @endguest

    <section id="fh5co-blog" data-section="blog">
        <div class="fh5co-blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Read Our Blog</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Berikut kami sajikan beberapa tips dan ulasan yang akan
                                    menemani dan menginspirasi perjalanan karier Anda.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" data-scrollbar>
                    @foreach($blogs as $blog)
                        <div class="col-md-6 to-animate blog">
                            <div class="blog-grid" style="background-image: url({{asset('images/blog/'.$blog->dir)}});">
                                <div class="date">
                                    <span>{{\Carbon\Carbon::parse($blog->created_at)->format('j')}}</span>
                                    <small>{{\Carbon\Carbon::parse($blog->created_at)->formatLocalized('%b')}}</small>
                                </div>
                            </div>
                            <a href="#" class="desc">
                                <div class="desc-grid">
                                    <h3>{{\Illuminate\Support\Str::words($blog->judul,5,"...")}}</h3>
                                </div>
                                <div class="reading">
                                    <i class="icon-arrow-right2"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <hr style="margin-top: 0">
                        <a href="#">
                            <button class="btn btn myBtn">
                                show more blog <i class="fa fa-search-plus"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(Auth::guest() || Auth::user()->role != 'seeker')
        <div class="getting-started getting-started-1">
            <div class="getting-grid" style="background-image: url({{asset('images/full_image_3.jpg')}});">
                <div class="desc" id="list-ads">
                    <h2>Mengapa beriklan di <span>SISKA</span> ?</h2>
                    <ul>
                        <li>Iklan lowongan paling terjangkau dengan fitur yang beragam.</li>
                        <li>Kostumisasi jadwal rekruitmen.</li>
                        <li>Online assessment yang dikembangkan institusi terpercaya.</li>
                    </ul>
                </div>
            </div>
            <a href="{{route('home-agency')}}#pricing" class="getting-grid2">
                <div class="call-to-action text-center">
                    <p class="sign-up">Pasang Iklan Sekarang <i class="fa fa-hand-point-right"></i></p>
                </div>
            </a>
        </div>
    @endif

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
                            <div class="col-md-12 to-animate-2">
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
                <div class="row to-animate">
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

    @guest
        <style>
            @media (min-width: 1440px) {
                #custom-search-input input {
                    width: 464px;
                }
            }

            @media (min-width: 1281px) and (max-width: 1439px) {
                #custom-search-input input {
                    width: 324px;
                }
            }

            @media (min-width: 1025px) and (max-width: 1280px) {
                #custom-search-input input {
                    width: 189px;
                }
            }

            @media (min-width: 768px) and (max-width: 1024px) {
                #custom-search-input input {
                    width: 324px;
                }
            }

            @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
                #custom-search-input input {
                    width: 68px;
                }
            }
        </style>
        <section id="fh5co-partner" class="fh5co-bg-color" data-section="partner">
            <div class="getting-started getting-started-1"
                 style="background: linear-gradient(#eb4b4b, #732f2f), #4b2222;">
                <div class="getting-grid" style="background-image: url({{asset('images/mitra.jpg')}});">
                    <div class="desc" id="list-ads">
                        <h2>Mengapa harus menggunakan <span>SiskaLTE</span> dan bermitra dengan <span>SISKA</span> ?
                        </h2>
                        <ul>
                            <li>Kelola lowongan sekaligus rekruitmennya dalam Instansi Anda secara mandiri.
                                <a href="https://github.com/Fq2124/siska-lte" target="_blank" style="color:#FFC12D">
                                    Klik disini</a> untuk instalasi SiskaLTE (<em>open source</em>).
                            </li>
                            <li>Sinkronisasi data lowongan SiskaLTE dari seluruh Instansi yang telah bermitra dengan
                                SISKA.
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="openPartnershipModal();" class="getting-grid2">
                    <div class="call-to-action text-center">
                        <p class="sign-up">Bermitra Sekarang <i class="fa fa-handshake"></i></p>
                    </div>
                </a>
            </div>
        </section>
    @endguest
@endsection
@push("lumen.ajax")
    <script src="{{ asset('js/filter-gridList.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.dc-view-switcher button[data-trigger="grid-view"]').click();

            setTimeout(getFavVacancy, 200);
            setTimeout(getLateVacancy, 200);
        });

        function getFavVacancy() {
            $.ajax({
                url: "{{route('load.fav.vacancies')}}",
                type: "GET",
                beforeSend: function () {
                    $('#image').show();
                    $("#fav-list-vacancy").hide();
                },
                complete: function () {
                    $('#image').hide();
                    $("#fav-list-vacancy").show();
                },
                success: function (data) {
                    loadData(data);
                    $("#fav-list-vacancy").empty().append($result);
                },
                error: function () {
                    swal({
                        title: 'Oops..',
                        text: 'Something went wrong! Please refresh this page.',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            return false;
        }

        function getLateVacancy() {
            $.ajax({
                url: "{{route('load.late.vacancies')}}",
                type: "GET",
                beforeSend: function () {
                    $('#image').show();
                    $("#fav-list-vacancy").hide();
                },
                complete: function () {
                    $('#image').hide();
                    $("#fav-list-vacancy").show();
                },
                success: function (data) {
                    loadData(data);
                    $("#late-list-vacancy").empty().append($result);
                },
                error: function () {
                    swal({
                        title: 'Oops..',
                        text: 'Something went wrong! Please refresh this page.',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            return false;
        }

        function loadData(data) {
            $result = '';
            $.each(data, function (i, val) {
                $result +=
                    '<article class="download-card">' +
                    '<a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">' +
                    '<div class="download-card__icon-box"><img src="' + val.user.ava + '"></div></a>' +
                    '<div class="download-card__content-box">' +
                    '<div class="content">' +
                    '<h2 class="download-card__content-box__catagory">' + val.updated_at + '</h2>' +
                    '<a href="{{route('detail.vacancy',['id' => ''])}}/' + val.id + '">' +
                    '<h3 class="download-card__content-box__title">' + val.judul + '</h3></a>' +
                    '<a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">' +
                    '<p class="download-card__content-box__description">' + val.user.name + '</p></a>' +
                    '<table style="font-size: 16px"><tbody>' +
                    '<tr><td><i class="fa fa-map-marked"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.city + '</td></tr>' +
                    '<tr><td><i class="fas fa-money-bill-wave"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.salary + '</td></tr>' +
                    '</tbody></table></div></div>' +
                    '<div class="card-read-more">' +
                    '<a href="{{route('detail.vacancy',['id' => ''])}}/' + val.id + '" class="btn btn-link btn-block">' +
                    'Read More</a></div></article>';
            });
        }

        $("#form-partnership").on("submit", function (e) {
            e.preventDefault();

            var email = $("#partnership_email").val(), instansi = $("#partnership_name").val();
            $.ajax({
                type: "POST",
                url: "{{route('join.partnership')}}",
                data: new FormData($("#form-partnership")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal("SISKA Partnership", "Permintaan berhasil! Kami akan mengirimkan API Key & API Secret " +
                            "untuk SiskaLTE Instansi Anda melalui email: " + email + ". Mohon tunggu untuk " +
                            "beberapa menit kedepan dan tetap periksa email Anda, terimakasih.", "success");
                        $("#partnership_name, #partnership_email").val('');
                        grecaptcha.reset(recaptcha_partnership);
                        $("#loginModal").modal('hide');

                    } else if (data == 1) {
                        swal('SISKA Partnership', 'API key untuk SiskaLTE "' + instansi + '" sudah ' +
                            'tersedia!', 'error');

                    } else if (data == 2) {
                        swal('SISKA Partnership', 'Permintaan bermitra untuk "' + instansi + '" sudah dilakukan ' +
                            'sebelumnya! Mohon tunggu dan tetap periksa email Anda, terimakasih.', 'error');
                    }
                },
                error: function () {
                    swal("Error!", "Something went wrong, please refresh the page.", "error");
                }
            });
            return false;
        });

    </script>
@endpush