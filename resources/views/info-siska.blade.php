@extends('layouts.mst_user')
@section('title', 'Information | '.env('APP_TITLE'))
@push('styles')
    <link href="{{ asset('css/myMaps.css') }}" rel="stylesheet">
    <style>
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
            font-weight: 500;
            padding: 10px 0;
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

                {{--@php $i = 3; @endphp
                @foreach($carousels as $row)
                    <li data-target="#carousel-example" data-slide-to="{{$i++}}"></li>
                @endforeach--}}
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image: url({{asset('images/carousel/kariernesia-seeker.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate">YOUR FAST FORWARD <span>CAREER</span> SOLUTION PROVIDER</h1>
                        <h2 class="to-animate"><span>{{env('APP_NAME')}}</span> hadir untuk menjembatani para
                            <span>seekers</span> dengan lowongan pekerjaan terbaik secara cepat dan cerdas.
                            Start now to hire or get hired with us!</h2>
                        <div class="call-to-action">
                            <a href="{{route('home-seeker')}}" class="demo to-animate">JOB SEEKERS</a>
                            <a href="{{route('home-agency')}}" class="download to-animate">JOB AGENCIES</a>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url({{asset('images/carousel/agencies.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate"><span>{{number_format($active_vacancies)}}</span> Lowongan Menantimu!</h1>
                        <h2 class="to-animate">Halo <span>seekers</span>! Ayo gabung, lengkapi profilmu (CV), dan kirimkan lamaranmu sekarang.</h2>
                        <div class="call-to-action">
                            <a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();"
                               class="demo to-animate">JOIN NOW</a>
                            <a href="{{route('search.vacancy')}}" class="download to-animate">SEARCH VACANCY</a>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url({{asset('images/carousel/candidates.jpg')}});">
                    <div class="carousel-overlay"></div>
                    <div class="carousel-caption">
                        <h1 class="to-animate"><span>{{number_format($active_seekers)}}</span> Kandidat Menantimu!</h1>
                        <h2 class="to-animate">Halo <span>agencies</span>! Ayo gabung, lengkapi data perusahaanmu, buat lowongan, dan posting lowonganmu sekarang.</h2>
                        <div class="call-to-action">
                            <a href="{{route('home-agency')}}#join" class="download to-animate">JOIN NOW</a>
                            <a href="{{route('home-agency')}}#pricing" class="demo to-animate">POST VACANCY</a>
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

    <section id="fh5co-services" data-id="#privacy-policy" data-section="services">
        <div class="fh5co-services">
            <div class="container">
                <div class="row" id="privacy-policy">
                    <div class="col-lg-12 section-heading text-center">
                        <h2 class="to-animate"><span>Privay Policy</span></h2>
                        <div class="row to-animate">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <p>
                                    {{env('APP_NAME')}} tidak hanya berusaha untuk memberikan pelayanan berkualitas yang sesuai
                                    harapan pengguna, tapi kami juga memberikan pengalaman yang aman dan terjamin.
                                </p>
                                <hr>
                                <p>
                                    <small>
                                        Informasi yang dikirim tetap bersifat pribadi dan hanya digunakan oleh
                                        perusahaan
                                        sebagai bahan evaluasi dan digunakan oleh Seeker untuk melamar secara online.
                                        Informasi tersebut tidak akan diberikan ke Agency.
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row to-animate">
                    <div class="col-lg-12">
                        <div class="media">
                            <div class="media-left media-middle">
                                <img width="128" class="media-object" src="{{asset('images/logo siska.png')}}">
                            </div>
                            <div class="media-body">
                                <small class="media-heading">
                                    <span style="color: #00ADB5">PRIVACY</span> <span style="color: #64979c">&</span>
                                    <span style="color: #fa5555">POLICY</span>
                                </small>
                                <blockquote style="font-size: 16px">
                                    <ol style="margin-left: -1em;text-align: justify;">
                                        <li>Informasi yang dimasukkan untuk iklan lowongan dan resume akan ditampilkan
                                            sebagaimana adanya, dan tidak di-edit oleh {{env('APP_NAME')}}. Harap kaji informasi
                                            yang dibutuhkan dan pastikan informasi mana yang dapat dilihat oleh
                                            pengunjung {{env('APP_NAME')}}.
                                        </li>
                                        <li>Kecuali Anda menggunakan fasilitas bloking Agency tertentu untuk
                                            melihat resume Anda, resume akan dapat dilihat oleh seluruh Agency
                                            dan perorangan, bila melakukan pencarian.
                                        </li>
                                        <li>Bila Seeker melamar secara online, nama depan dan nomor telpon Anda akan
                                            ditampilkan ke Agency yang Anda lamar.
                                        </li>
                                        <li>Pada saat resume Anda pertama kali tampil sebagai hasil pencarian, nama
                                            depan dan nomor telpon tidak akan ditampilkan. Tetapi bila Agency atau
                                            individu melakukan pencarian dan mengirim email dari resume link, maka nama
                                            depan dan nomor telpon akan ditampilkan seketika.
                                        </li>
                                        <li>Kami sarankan untuk merahasiakan password Anda. Kami tidak akan pernah
                                            menanyakan password Anda melalui telpon ataupun email dan tidak akan
                                            memberikan password Anda ke Agency.
                                        </li>
                                        <li>Account Anda di {{env('APP_NAME')}} dilindungi dengan password. Artinya, hanya Anda
                                            yang mempunyai akses ke account Anda dan hanya Anda yang bisa mengubah
                                            segala informasi yang dimasukkan melalui account Anda.
                                        </li>
                                        <li>Setelah Anda selesai menggunakan {{env('APP_NAME')}}, jangan lupa untuk logout. Hal
                                            ini untuk memastikan bahwa tidak ada pihak lain yang mengakses account
                                            Anda, khususnya bila komputer digunakan bersama-sama atau bila Anda
                                            menggunakan komputer di tempat umum seperti perpustakaan atau kafe/warung
                                            internet.
                                        </li>
                                        <li>Cookies adalah serangkaian informasi yang dipindahkan dari situs ke hard
                                            disk komputer Anda untuk penyimpanan data. Cookies memberikan keuntungan
                                            bagi situs dalam beberapa hal dengan menyimpan informasi mengenai
                                            preferensi-preferensi Anda ketika mengunjungi sebuah situs. Banyak situs
                                            terkemuka yang menggunakan cookies untuk memberikan
                                            keistimewaan-keistimewaan yang menguntungkan bagi pengguna situs mereka.
                                            Cookies dapat mengenali komputer Anda, namun tidak dapat mengenali
                                            identitas Anda. Kebanyakan browsers dapat menerima cookies, dengan
                                            catatan browser Anda telah diset terlebih dahulu. Apabila browser Anda
                                            tidak dapat menerima cookies, maka Anda sama sekali tidak akan dapat
                                            mengakses ke situs kami.
                                        </li>
                                        <li>Apabila suatu saat nanti kami harus mengubah Polis Kerahasiaan kami, maka
                                            kami akan mencantumkannya di sini agar para pengguna dapat mengetahui
                                            informasi apa saja yang kami kumpulkan dan bagaimana kami menggunakan
                                            informasi tersebut. Data pribadi Anda akan digunakan sesuai dengan polis
                                            kerahasiaan kami. Apabila, sewaktu-waktu Anda ingin mengajukan pertanyaan
                                            ataupun memberikan komentar tentang Polis Kerahasiaan kami, maka Anda dapat
                                            menghubungi kami lewat email {{env('MAIL_USERNAME')}} atau menghubungi 
                                            telepon {{env('APP_PHONE')}} dan langsung berbicara dengan salah satu staf kami
                                        </li>
                                    </ol>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-explore" data-id="#terms-conditions" data-section="explore">
        <div class="fh5co-explore">
            <div class="container">
                <div class="row" id="terms-conditions">
                    <div class="col-lg-12 section-heading text-center">
                        <h2 class="to-animate"><span>Terms & Conditions</span></h2>
                        <div class="row to-animate-2">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs to-animate" id="faq-nav-tabs">
                                    <li class="active" id="faq-s">
                                        <a data-toggle="tab" href="#tnc-seeker">Job Seeker</a>
                                    </li>
                                    <li id="faq-a">
                                        <a data-toggle="tab" href="#tnc-agency">Job Agency</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row to-animate">
                    <div class="tab-content">
                        <div id="tnc-seeker" class="tab-pane to-animate active row">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img width="150" class="media-object img-circle"
                                                 src="{{asset('images/seeker.png')}}">
                                        </div>
                                        <div class="media-body">
                                            <small class="media-heading" style="color: #fa5555">DEFINISI</small>
                                            <blockquote style="font-size: 16px">
                                                <ul style="margin-left: -1em;text-align: justify;">
                                                    <li><strong>Perusahaan</strong> adalah {{env('APP_NAME')}} dan/atau
                                                        {{str_replace('https://', 'www.', env('APP_URL'))}}.
                                                    </li>
                                                    <li><strong>Seeker</strong> adalah pihak atau individu yang
                                                        menggunakan {{env('APP_NAME')}} untuk melamar pekerjaan atau peluang karir
                                                        dan untuk mendapatkan informasi yang tersedia di {{env('APP_NAME')}} atau
                                                        tautan lain yang terkait.
                                                    </li>
                                                    <li><strong>Agency</strong> adalah organisasi atau individu yang
                                                        menggunakan {{env('APP_NAME')}} untuk keperluan rekrutmen, memasang iklan
                                                        atau kepentingan lainnya.
                                                    </li>
                                                    <li><strong>Premium Service</strong> adalah layanan Perusahaan bagi
                                                        Seeker yang membayar sejumlah biaya tertentu agar resumenya
                                                        terkirim melalui email kepada Agency yang memasang iklan
                                                        lowongan di {{env('APP_NAME')}} yang sesuai dengan kriteria dari Seeker.
                                                    </li>
                                                </ul>
                                            </blockquote>
                                            <small class="media-heading" style="color: #fa5555">TERMS & CONDITIONS
                                            </small>
                                            <blockquote style="font-size: 16px">
                                                <ol style="margin-left: -1em;text-align: justify;">
                                                    <li>Perusahaan tidak bertanggung-jawab atas isi iklan atau
                                                        informasi apapun yang dipasang oleh Agency di {{env('APP_NAME')}}.
                                                    </li>
                                                    <li>Perusahaan berhak untuk mengedit resume, memblokir account dan
                                                        menolak memberikan layanan kepada Seeker yang dianggap
                                                        melanggar kebijakan Perusahaan, di mana interpretasinya menjadi
                                                        hak Perusahaan sepenuhnya. Keputusan Perusahaan dalam hal ini
                                                        bersifat mutlak dan tidak dapat diganggu-gugat. Seeker yang
                                                        telah melakukan pembayaran Premium Service kepada Perusahaan
                                                        tetapi ditolak untuk dilayani, berhak untuk meminta kembali
                                                        pembayaran, dengan dikenakan pemotongan biaya sebagaimana
                                                        ditentukan oleh Perusahaan.
                                                    </li>
                                                    <li>Seeker mengetahui dan menyetujui bahwa resume Seeker akan
                                                        ditampilkan dan digunakan oleh Agency untuk keperluan
                                                        rekrutmen tenaga kerja.
                                                    </li>
                                                    <li>Seeker setuju untuk tidak mencantumkan informasi yang tidak
                                                        benar, menyesatkan, melecehkan, membangkitkan kebencian,
                                                        memfitnah, bersifat diskriminatif terhadap suku, agama dan ras
                                                        tertentu (SARA) ataupun menyinggung prinsip keagamaan.
                                                    </li>
                                                    <li>Seeker merupakan satu-satunya pihak yang bertanggung-jawab
                                                        penuh atas informasi yang dicantumkan dalam surat lamaran atau
                                                        resume.
                                                    </li>
                                                    <li>Seeker setuju untuk tidak menuntut Perusahaan dan/atau
                                                        seluruh karyawannya atas kerugian apapun yang terjadi akibat
                                                        Seekeran {{env('APP_NAME')}} atau link-link lain yang terkait.
                                                    </li>
                                                    <li>Seeker tidak diperkenankan untuk menggunakan informasi yang
                                                        diperoleh dari {{env('APP_NAME')}} atau link-link lain yang terkait untuk
                                                        tujuan yang melanggar hukum, atau melanggar undang-undang hak
                                                        cipta dan hak intelektual. Pelanggaran terhadap ketentuan ini
                                                        dapat diperkarakan ke pengadilan oleh Perusahaan dan/atau
                                                        pihak-pihak lain yang dirugikan.
                                                    </li>
                                                    <li>Seeker sepakat untuk menyetujui syarat dan ketentuan lain
                                                        yang mungkin akan ditambahkan oleh Perusahaan dari waktu ke
                                                        waktu tanpa pemberitahuan sebelumnya dari Perusahaan.
                                                    </li>
                                                </ol>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tnc-agency" class="tab-pane to-animate row">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img width="150" class="media-object img-circle"
                                                 src="{{asset('images/agency.png')}}">
                                        </div>
                                        <div class="media-body">
                                            <small class="media-heading" style="color: #00ADB5">DEFINISI</small>
                                            <blockquote style="font-size: 16px">
                                                <ul style="margin-left: -1em;text-align: justify;">
                                                    <li><strong>Perusahaan</strong> adalah {{env('APP_NAME')}} dan/atau
                                                        {{str_replace('https://', 'www.', env('APP_URL'))}}.
                                                    </li>
                                                    <li><strong>Agency</strong> adalah organisasi
                                                        atau individu yang menggunakan {{env('APP_NAME')}} untuk keperluan rekrutmen,
                                                        memasang iklan atau kepentingan lainnya.
                                                    </li>
                                                </ul>
                                            </blockquote>
                                            <small class="media-heading" style="color: #00ADB5">TERMS & CONDITIONS
                                            </small>
                                            <blockquote style="font-size: 16px">
                                                <ol style="margin-left: -1em;text-align: justify;">
                                                    <li>Perusahaan berhak untuk menolak memberikan layanan kepada
                                                        Agency yang dianggap melanggar kebijakan Perusahaan, di mana
                                                        interpretasinya menjadi hak Perusahaan sepenuhnya. Keputusan
                                                        Perusahaan untuk menolak melayani atau menghentikan layanan
                                                        bersifat mutlak dan tidak dapat diganggu-gugat. Bila Agency
                                                        telah melakukan pembayaran kepada Perusahaan tetapi ditolak
                                                        atau dihentikan keanggotaannya, maka Agency berhak untuk
                                                        meminta kembali pembayaran, dengan dikenakan pemotongan biaya
                                                        sebagaimana ditentukan oleh Perusahaan.
                                                    </li>
                                                    <li>Agency setuju untuk tidak memasang iklan yang tidak benar,
                                                        menyesatkan, melecehkan, membangkitkan kebencian, memungut
                                                        biaya, memfitnah, bersifat diskriminatif terhadap suku, agama
                                                        dan ras tertentu (SARA) ataupun menyinggung prinsip keagamaan.
                                                    </li>
                                                    <li>Agency merupakan satu-satunya pihak yang bertanggung-jawab
                                                        penuh atas informasi yang dipasang di {{env('APP_NAME')}}.
                                                    </li>
                                                    <li>Agency setuju untuk membebaskan Perusahaan dan/atau seluruh
                                                        karyawannya dari tuntutan yang timbul akibat kerugian,
                                                        hilangnya uang dan sebagainya, yang terjadi akibat penggunaan
                                                        layanan yang disediakan oleh Perusahaan atau penggunaan
                                                        situs-situs dan link lain yang terkait.
                                                    </li>
                                                    <li>Agency tidak diperkenankan menggunakan data yang diperoleh
                                                        dari {{env('APP_NAME')}} untuk tujuan lain di luar tujuan untuk mengisi
                                                        lowongan pekerjaan atau peluang karir yang dimiliki Agency.
                                                        Pelanggaran terhadap ketentuan ini dapat diperkarakan ke
                                                        pengadilan oleh Perusahaan dan/atau pihak-pihak yang dirugikan.
                                                    </li>
                                                    <li>Agency sepakat untuk menyetujui syarat dan ketentuan lain
                                                        yang mungkin akan ditambahkan oleh Perusahaan dari waktu ke
                                                        waktu tanpa pemberitahuan sebelumnya kepada Agency.
                                                    </li>
                                                </ol>
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
    </section>

    <section id="fh5co-team" class="fh5co-bg-color" data-id="#team" data-section="team">
        <div class="fh5co-team">
            <div class="container">
                <div class="row" id="team">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class="to-animate"><span>Meet The Team</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">Feel free to get in touch with us!</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="team-box text-center to-animate-2">
                            <div class="user"><img class="img-reponsive" src="{{asset('images/pak-sal.jpg')}}"
                                                   alt="Roger Garfield"></div>
                            <h3>Salamun Rohman Nudin</h3>
                            <span class="position">Founder, Lead Developer</span>
                            <p>36-year-old Lecturer, an Informatics
                                Engineer from UNESA (State University of Surabaya). His course focuses on
                                e-learning and AI (Artificial Intelligence). Now, he leads the developing of {{env('APP_NAME')}}, as
                                its <em>founder</em>.</p>
                            <ul class="social-media">
                                <li><a href="#" class="facebook"><i class="fab fa-facebook-square"></i></a></li>
                                <li><a href="mailto:salamunrn@gmail.com" class="email"><i
                                                class="fa fa-envelope"></i></a></li>
                                <li>
                                    <a href="https://web.whatsapp.com/send?text=Assalamu`alaikum, Pak Salamun!&phone=+628121713320&abid=+628121713320"
                                       class="whatsapp"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="#" class="github"><i class="fab fa-github-alt"></i></a></li>
                                <li><a href="http://line.me/ti/p/~fqnkk" class="line"><i class="fab fa-line"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="team-box text-center to-animate-2">
                            <div class="user"><img class="img-reponsive" src="{{asset('images/fiqy.jpeg')}}"
                                                   alt="Roger Garfield"></div>
                            <h3>Fiqy Ainuzzaqy</h3>
                            <span class="position">Co-Founder, Product Designer</span>
                            <p>21-year-old Student, an Informatics
                                Engineer from UNESA (State University of Surabaya). He
                                starts his debut as a <em>front-end developer</em> since 2015. Now, he plays role as a
                                <em>full stack developer</em> of {{env('APP_NAME')}} apps (web version).</p>
                            <ul class="social-media">
                                <li><a target="_blank" href="https://facebook.com/fqnkk" class="facebook"><i
                                                class="fab fa-facebook-square"></i></a></li>
                                <li><a target="_blank" href="https://instagram.com/fq_whysoserious" class="instagram"><i
                                                class="fab fa-instagram"></i></a></li>
                                <li><a target="_blank" href="https://github.com/Fq2124" class="github"><i
                                                class="fab fa-github-alt"></i></a></li>
                                <li>
                                    <a href="https://web.whatsapp.com/send?text=Hello, fq!&phone={{env('APP_PHONE')}}&abid={{env('APP_PHONE')}}"
                                       class="whatsapp"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="http://line.me/ti/p/~fqnkk" class="line"><i class="fab fa-line"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="team-box text-center to-animate-2">
                            <div class="user"><img class="img-reponsive" src="{{asset('images/ilham.jpg')}}"
                                                   alt="Roger Garfield"></div>
                            <h3>Ilham Puji Saputra</h3>
                            <span class="position">Full Stack Developer</span>
                            <p>21-year-old Student, an Informatics
                                Engineer from UNESA (State University of Surabaya). He
                                starts his debut as a <em>back-end developer</em> since 2016. Now, he plays role as a
                                <em>full stack developer</em> of {{env('APP_NAME')}} apps (mobile version).</p>
                            <ul class="social-media">
                                <li><a target="_blank" href="https://facebook.com/ilham.m1ku100" class="facebook"><i
                                                class="fab fa-facebook-square"></i></a></li>
                                <li><a href="#" class="instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a target="_blank" href="https://github.com/m1ku100" class="github"><i
                                                class="fab fa-github-alt"></i></a></li>
                                <li>
                                    <a href="https://web.whatsapp.com/send?text=Hello, Ilham!&phone=+6282338434394&abid=+6282338434394"
                                       class="whatsapp"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="http://line.me/ti/p/~ilhampuji" class="line"><i
                                                class="fab fa-line"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-faq" class="fh5co-bg-color" data-id="#faqs" data-section="faq">
        <div class="fh5co-faq">
            <div class="container">
                <div class="row" id="faqs">
                    <div class="col-md-12 section-heading text-center">
                        <h2 class=""><span>Common Questions</span></h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="">Segala sesuatu yang Anda harus ketahui sebelum menggunakan
                                    aplikasi {{env('APP_NAME')}} dan kami disini untuk membantu Anda!</h3>
                            </div>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="faq-nav-tabs">
                                    <li class="active" id="faq-s">
                                        <a data-toggle="tab" href="#seeker">FAQ Job Seeker</a></li>
                                    <li id="faq-a">
                                        <a data-toggle="tab" href="#agency">FAQ Job Agency</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row to-animate">
                    <div class="tab-content">
                        <div id="seeker" class="tab-pane fade in active">
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

                        <div id="agency" class="tab-pane fade in">
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
                                                            href="tel:{{env('APP_PHONE')}}">+62-85-6309 4333</a> untuk
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
                                                <p>Silahkan hubungi <a href="tel:{{env('APP_PHONE')}}">+62-85-6309 4333</a>
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
                                                Bagaimana caranya untuk menaikkan jumlah Seeker pekerjaan?
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
@endsection
@push("scripts")
    <script>
        if(window.location.hash) {
            $('#first-navbar').addClass('navbar-fixed-top fh5co-animated slideInDown');

            $('html, body').animate({
                scrollTop: $('[data-id="'+window.location.href+'"]').offset().top + 100
            }, 500);
        }

        function goToAnchor(selector) {
            $('html, body').animate({
                scrollTop: $('[data-id="'+selector+'"]').offset().top + 100
            }, 500);
        }
    </script>
@endpush
