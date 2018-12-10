@extends('layouts.mst_user')
@section('title', 'Psycho Test (Online Interview): Room Code #'.$roomCode.' &mdash; '.$vacancy->judul.' - '.$userAgency->name.' | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/twilio.video-conf.custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/stickyForm.css')}}">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 7em">
        <div class="fh5co-services">
            <div class="container" style="width: 100%">
                <div class="row">
                    <div class="col-lg-12 section-heading text-center" style="padding-bottom: 0">
                        <h2 class="to-animate" style="text-transform: none;"><span>Psycho Test (Online Interview)</span>
                        </h2>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">
                                    Room Code #<strong>{{$roomCode}}</strong>: {{$vacancy->judul.' - '.
                                    $userAgency->name}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="psychoTest_content"></div>
            </div>
        </div>
    </section>
    @auth('admin')
        @php strtok($roomCode, '_');$seeker_id = strtok('');$seeker = \App\Seekers::find($seeker_id); @endphp
        <div class="stickyForm">
            <span class="icon"><i class="fa fa-clipboard-list" aria-hidden="true"></i></span>
            <div class="sticky-header">
                <strong>Scoring Form</strong>
                <button type="button" class="close sticky-close"><span>×</span></button>
            </div>
            <form method="post" class="form-horizontal" id="form-scoring">
                <div class="sticky-input">
                    {{csrf_field()}}
                    <input type="hidden" name="psychoTest_id" value="{{$vacancy->getPsychoTestInfo->id}}">
                    <input type="hidden" name="seeker_id" value="{{$seeker_id}}">
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <label for="kompetensi">Kompetensi <span class="required">*</span></label>
                            <input class="form-control gpa" id="kompetensi" type="text" name="kompetensi" maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="karakter">Karakter <span class="required">*</span></label>
                            <input class="form-control gpa" id="karakter" type="text" name="karakter" maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <label for="attitude">Attitude <span class="required">*</span></label>
                            <input class="form-control gpa" id="attitude" type="text" name="attitude" maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="grooming">Grooming <span class="required">*</span></label>
                            <input class="form-control gpa" id="grooming" type="text" name="grooming" maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <label for="komunikasi">Komunikasi <span class="required">*</span></label>
                            <input class="form-control gpa" id="komunikasi" type="text" name="komunikasi" maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="anthusiasme">Anthusiasme <span class="required">*</span></label>
                            <input class="form-control gpa" id="anthusiasme" type="text" name="anthusiasme"
                                   maxlength="5"
                                   onkeypress="return numberOnly(event,false)" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <label for="note">Note</label>
                            <textarea class="form-control" id="note" name="note"
                                      placeholder="Write something about {{$seeker->user->name}} here&hellip;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="sticky-footer">
                    <button class="btn btn-block" type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="stickyTitle">
            <a href="javascript:void(0)" style="text-decoration: none;color: #000;">
                <div class="stickyTitle-content">Scoring Form</div>
            </a>
        </div>
    @endauth
@endsection
@push("scripts")
    <script src="{{asset('js/twilio-video.min.js')}}"></script>
    <script>
        var regExp = /\(([^)]+)\)/, check_candidate = false;

        Twilio.Video.createLocalTracks({
            audio: true,
            video: {width: 300}
        }).then(function (localTracks) {
            return Twilio.Video.connect('{{$accessToken}}', {
                name: '{{$roomCode}}',
                tracks: localTracks,
                video: {width: 300}
            });
        }).then(function (room) {
            console.log('Successfully joined a Room: ', room.name);

            room.participants.forEach(participantConnected);

            var previewContainer = document.getElementById(room.localParticipant.sid);
            if (!previewContainer || !previewContainer.querySelector('video')) {
                participantConnected(room.localParticipant);
            }

            room.on('participantConnected', function (participant) {
                console.log("Joining: '" + participant.identity + "'");
                participantConnected(participant);
            });

            room.on('participantDisconnected', function (participant) {
                console.log("Disconnected: '" + participant.identity + "'");
                participantDisconnected(participant);
            });
        });

        function participantConnected(participant) {
            var role;
            console.log('Participant "%s" connected', participant.identity);

            const div = document.createElement('div');
            div.id = participant.sid;
            div.classList.add('col-lg-6');
            div.innerHTML = "<div class='participant-identity'><strong>" + participant.identity + "</strong></div>";

            participant.tracks.forEach(function (track) {
                trackAdded(div, track)
            });

            participant.on('trackAdded', function (track) {
                trackAdded(div, track)
            });
            participant.on('trackRemoved', trackRemoved);

            document.getElementById('psychoTest_content').appendChild(div);

            role = regExp.exec(participant.identity);
            if (role[1] == "CANDIDATE") {
                check_candidate = true;
            }
        }

        function participantDisconnected(participant) {
            console.log('Participant "%s" disconnected', participant.identity);

            participant.tracks.forEach(trackRemoved);
            document.getElementById(participant.sid).remove();
        }

        function trackAdded(div, track) {
            div.appendChild(track.attach());
            var video = div.getElementsByTagName("video")[0];
            if (video) {
                video.classList.add("participant-video");
            }
        }

        function trackRemoved(track) {
            track.detach().forEach(function (element) {
                element.remove()
            });
        }

        @auth('admin')
        $(".stickyTitle, .stickyForm").on("click", function () {
            $(".stickyTitle").toggleClass("sticky-animation-in sticky-animation-out");
            $(".stickyForm").addClass("open");
        });

        $(".sticky-close").on("click", function (e) {
            $(".stickyTitle").toggleClass("sticky-animation-in sticky-animation-out");
            $(".stickyForm").removeClass("open");
            e.stopPropagation();
        });

        $(".gpa").on("blur", function () {
            if (parseFloat($(this).val()) > 10.00) {
                $(this).val(10.00);
            } else if ($(this).val() == "") {
                $(this).val(0);
            }
        });

        $("#form-scoring").on("submit", function (e) {
            e.preventDefault();
            if (check_candidate == true) {
                swal({
                    title: 'Scoring Form',
                    text: "Are you sure to submit it? You wont't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fa5555',
                    confirmButtonText: 'Yes, submit it!',
                    showLoaderOnConfirm: true,

                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                type: "POST",
                                url: "{{route('submit.psychoTest')}}",
                                data: new FormData($("#form-scoring")[0]),
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#form-scoring input, #form-scoring textarea").attr('disabled', 'disabled');
                                    $(".sticky-footer button").attr('disabled', 'disabled');
                                    $(".sticky-close").click();

                                    swal("Success!", "Psycho Test with Room Code #{{$roomCode}} is " +
                                        "successfully submitted!", "success");
                                },
                                error: function () {
                                    swal("Error!", "Psycho Test with Room Code #{{$roomCode}} is failed to submit! " +
                                        "Something went wrong, please refresh the page.", "error");
                                }
                            });
                        });
                    },
                    allowOutsideClick: false
                });

            } else {
                $("#form-scoring")[0].reset();
                $(".sticky-close").click();

                swal("ATTENTION!", "The candidate, {{$seeker->user->name}}, hasn't been connected to this room yet! " +
                    "Please, contact {{$seeker->gender == "female" ? 'her' : 'his'}} " +
                    "phone: {{$seeker->phone}} or email: {{$seeker->user->email}}.", "warning");
            }

            return false;
        });
        @endauth

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });
    </script>
@endpush
