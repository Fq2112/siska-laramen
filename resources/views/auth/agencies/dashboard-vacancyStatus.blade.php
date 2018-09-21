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
                                    Showing a vacancy status
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
                                    $vac_ids = \App\ConfirmAgency::where('id', $row->id)->pluck('vacancy_ids')->toArray();
                                    $vacancies = \App\Vacancies::whereIn('id',$vac_ids[0])->get();
                                    $plan = \App\Plan::find($row->plans_id);
                                    $pm = \App\PaymentMethod::find($row->payment_method_id);
                                    $pc = \App\PaymentCategory::find($pm->payment_category_id);
                                    $date = \Carbon\Carbon::parse($row->created_at);
                                    $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')) . '/' .
                                    \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                    $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row->id;
                                @endphp
                                <div class="media to-animate">
                                    <div class="media-left media-middle">
                                        <a href="{{route('agency.profile',['id'=>$agency->id])}}">
                                            @if($row->isPaid == true)
                                                <img width="100" class="media-object"
                                                     src="{{asset('images/stamp_paid.png')}}">
                                            @else
                                                <img width="100" class="media-object"
                                                     src="{{asset('images/stamp_unpaid.png')}}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <small class="media-heading">
                                            <a style="color: {{$row->isPaid == true ? '#00adb5' : '#fa5555'}}"
                                               target="_blank"
                                               href="{{route('invoice.job.posting',['id'=>encrypt($row->id)])}}">
                                                <i class="fa fa-file-invoice-dollar"></i>&ensp;{{$invoice}}</a>
                                        </small>
                                        <blockquote style="font-size: 12px;color: #7f7f7f">
                                            <form class="pull-right to-animate-2" id="form-paymentProof-{{$row->id}}"
                                                  method="post" action="{{route('upload.paymentProof')}}">
                                                {{csrf_field()}}
                                                <div class="anim-icon anim-icon-md upload {{$row->isPaid == true ? '' :
                                                'ld ld-breath'}}"
                                                     onclick="uploadPaymentProof('{{$row->id}}')" data-toggle="tooltip"
                                                     data-placement="bottom" title="Payment Proof"
                                                     style="font-size: 25px">
                                                    <input type="hidden" name="confirmAgency_id" value="{{$row->id}}">
                                                    <input type="checkbox" checked>
                                                    <label for="upload"></label>
                                                </div>
                                            </form>
                                            <ul class="list-inline">
                                                @foreach($vacancies as $vacancy)
                                                    <li><a class="tag" target="_blank" href="{{route('detail.vacancy',
                                                    ['id' => $vacancy->id])}}"><i class="fa fa-briefcase"></i>&ensp;
                                                            {{$vacancy->judul}} &ndash; <strong>{{$vacancy->isPost ==
                                                            true ? 'POSTED' : 'NOT POSTED YET'}}</strong></a></li>
                                                @endforeach
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class="fa fa-thumbtack"></i>&ensp;Plans Package:
                                                        <strong style="text-transform: uppercase">{{$plan->name}}</strong></a>
                                                </li>
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class="fa fa-credit-card"></i>&ensp;Payment:
                                                        {{$pc->name}} &ndash;
                                                        <strong style="text-transform: uppercase">{{$pm->name}}</strong>
                                                    </a></li>
                                            </ul>
                                            <small>Ordered on {{$row->created_at->format('j F Y')}}</small>
                                            @if($row->isPaid == false)
                                                <a href="{{route('delete.job.posting',['id'=>encrypt($row->id)])}}"
                                                   class="delete-jobPosting">
                                                    <div class="anim-icon anim-icon-md apply ld ld-heartbeat"
                                                         data-toggle="tooltip" data-placement="right"
                                                         title="Click here to abort this order!"
                                                         style="font-size: 15px">
                                                        <input type="checkbox" checked>
                                                        <label for="apply"></label>
                                                    </div>
                                                </a>
                                                <small class="to-animate-2">
                                                    P.S.: You are only permitted to abort this order before the payment
                                                    deadline.
                                                </small>
                                            @endif
                                        </blockquote>
                                    </div>
                                </div>
                                <hr class="hr-divider">
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