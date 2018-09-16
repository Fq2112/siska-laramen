@section('title', ''.$user->name.'\'s Dashboard &ndash; Interview Invitation | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Interview Invitation</h4>
                            <small>Here is the current and previous status of your interview invitations.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('seeker.invitation.interview')}}">
                                <select class="form-control selectpicker" name="time" data-container="body">
                                    <option value="1" {{$time == 1 ? 'selected' : ''}}>All Time</option>
                                    <option value="2" {{$time == 2 ? 'selected' : ''}}>Today</option>
                                    <option value="3" {{$time == 3 ? 'selected' : ''}}>Last 7 Days</option>
                                    <option value="4" {{$time == 4 ? 'selected' : ''}}>Last 30 Days</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-9 to-animate">
                            <small class="pull-right">
                                <em>There seems to be none of the interview invitation was found&hellip;</em>
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
    <script>
        $("#form-time select").on('change', function () {
            $("#form-time")[0].submit();
        });
    </script>
@endpush