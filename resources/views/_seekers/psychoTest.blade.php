@extends('layouts.mst_user')
@section('title', 'Psycho Test (Online Interview): Room Code #'.$roomCode.' &mdash; '.$vacancy->judul.' - '.$userAgency->name.' | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <style>
        #psychoTest_content {
            text-align: center;
        }

        .participant-identity {
            color: #393939b0;
        }

        .participant-video {
            width: 100%;
            background-color: #ddd;
            border-radius: 7px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            transition: box-shadow .25s;
        }

        .participant-video:hover {
            box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
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
@endsection
@push("scripts")
    <script src="{{asset('js/twilio-video.min.js')}}"></script>
    <script>
        Twilio.Video.createLocalTracks({
            audio: true,
            video: {width: 300}
        }).then(function (localTracks) {
            return Twilio.Video.connect('{{ $accessToken }}', {
                name: '{{ $roomCode }}',
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

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });
    </script>
@endpush
