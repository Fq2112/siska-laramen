@section('title', ''.$user->name.'\'s Dashboard &ndash; Vacancy Status | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Vacancy Status</h4>
                            <small>Here is the current and previous status of your vacancies.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('agency.vacancy.status')}}">
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
                                @if(count($confirmAgency) > 1)
                                    Showing <strong>{{count($confirmAgency)}}</strong> vacancy status
                                @elseif(count($confirmAgency) == 1)
                                    Showing an vacancy status
                                @else
                                    <em>There seems to be none of the vacancy status was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($confirmAgency as $row)
                                @php
                                    $date = \Carbon\Carbon::parse($row->created_at);
                                    $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')) . '/' .
                                    \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                    $invoice = 'INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row->id;
                                @endphp
                            @endforeach

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$confirmAgency->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush