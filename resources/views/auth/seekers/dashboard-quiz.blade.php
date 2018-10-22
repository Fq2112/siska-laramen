@section('title', ''.$user->name.'\'s Dashboard &ndash; Quiz Invitation | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Quiz Invitation</h4>
                            <small>Here is the current and previous status of your quiz invitations.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-12 to-animate">
                            <small class="pull-right">
                                <em>There seems to be none of the quiz invitation was found&hellip;</em>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush