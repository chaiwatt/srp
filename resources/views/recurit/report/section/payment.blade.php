@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานเบิกจ่ายรายเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานเบิกจ่ายรายเดือน
            </div>
        </div>
    </div>

    <div class="row padding-md pull-right" >
            <div class="col-sm-12">
                {!! Form::open([ 'method' => 'get' , 'id' => 'myform' ]) !!}
                <div class="form-inline no-margin">
                    <div class="form-group">
                        <label >เลือกเดือน</label>
                        <select class="form-control" name="month" id="month" >
                            <option value ="0" @if( $month == 0) selected @endif  >เลือก เดือน</option>
                            <option value ="1" @if( $month == 1) selected @endif  >มกราคม</option>
                            <option value ="2" @if( $month == 2) selected @endif  >กุมภาพันธ์</option>
                            <option value ="3" @if( $month == 3) selected @endif  >มีนาคม</option>
                            <option value ="4" @if( $month == 4) selected @endif  >เมษายน</option>
                            <option value ="5" @if( $month == 5) selected @endif  >พฤษภาคม</option>
                            <option value ="6" @if( $month == 6) selected @endif  >มิถุนายน</option>
                            <option value ="7" @if( $month == 7) selected @endif  >กรกฏาคม</option>
                            <option value ="8" @if( $month == 8) selected @endif  >สิงหาคม</option>
                            <option value ="9" @if( $month == 9) selected @endif  >กันยายน</option>
                            <option value ="10" @if( $month == 10) selected @endif  >ตุลาคม</option>
                            <option value ="11" @if( $month == 11) selected @endif  >พฤศจิกายน</option>
                            <option value ="12" @if( $month == 12) selected @endif  >ธันวาคม</option>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label >เลือกไตรมาส</label>
                        <select class="form-control" name="quater" id="quater">
                            <option value ="0"  @if( $quater == 0) selected @endif  >เลือก ไตรมาส</option>
                            <option value ="1"  @if( $quater == 1) selected @endif  >ไตรมาส1</option>
                            <option value ="2"  @if( $quater == 2) selected @endif  >ไตรมาส2</option>
                            <option value ="3"  @if( $quater == 3) selected @endif  >ไตรมาส3</option>
                            <option value ="4"  @if( $quater == 4) selected @endif  >ไตรมาส4</option>
                        </select>
                    </div><!-- /form-group -->
                    <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                    
                    
                    @if( $month != null || $quater != null )
                        {{-- <a id="exportexcel" class="btn btn-sm btn-info">Excel</a> --}}
                        <a href="{{ URL::route('recurit.report.section.export.excel',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-info">Excel</a>
                        <a href="{{ URL::route('recurit.report.section.export.pdf',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-warning">PDF</a>
                        {{-- <a href="{{ URL::route('occupation.export.word',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-default">Word</a> --}}
                    @endif
                    
                </div>
                {!! Form::close() !!}
            </div>
        </div>  

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายงานเบิกจ่ายรายเดือน 
                    @if(count($quatername)>0)
                        : {{$quatername->quater_name}}
                    @endif 
                    @if(count($monthname) > 0)
                        : เดือน {{$monthname->month_name}}
                    @endif 
                </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        @if( Session::has('success') )
                            <div class="alert alert-success alert-custom alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-check-circle m-right-xs"></i> {{ Session::get('success') }}
                            </div>
                        @elseif( Session::has('error') )
                            <div class="alert alert-danger alert-custom alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                 <i class="fa fa-times-circle m-right-xs"></i> {{ Session::get('error') }}
                            </div>
                        @endif
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">วันที่จ่าย</th>
                                    <th >คำขึ้นต้น</th>
                                    <th >ชื่อ</th>
                                    <th >นามสกุล</th>
                                    <th >ตำแหน่ง</th>
                                    <th class="text-center">เลขที่บัตรประชาชน</th>
                                    <th class="text-center">หักขาดเงิน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">ค่าจ้างที่ได้รับ</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($payment) > 0 )
                                @foreach( $payment as $key => $item )
                                    <tr>
                                        <td class="text-center">{{ str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT)  }}</td>
                                        <td class="text-center">{{ $item->paymentdateth }}</td>
                                        <td>{{ $item->registerprefixname }}</td>
                                        <td>{{ $item->registername }}</td>
                                        <td>{{ $item->registerlastname }}</td>
                                        <td>{{ $item->positionname }}</td>
                                        <td class="text-center">{{ $item->registerpersonid }}</td>
                                        <td class="text-center">{{ number_format($item->payment_absence , 2) }}</td>
                                        <td class="text-center">{{ number_format($item->payment_fine , 2) }}</td>
                                        <td class="text-center">{{ number_format($item->payment_salary , 2) }}</td>
                                    </tr>
                                @endforeach
                                @endif
                                    <tr>
                                        <td colspan="7"  class="text-right"><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum( 'payment_absence' ) , 2 ) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum( 'payment_fine' ) , 2 ) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum( 'payment_salary' ) , 2 ) }}</strong></td>
                                    </tr>
                            </tbody>
                        </table>
                        {{$payment->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">
    $("#quater").change(function(){
        document.getElementById('month').value=0;
    })

    $("#month").change(function(){
        document.getElementById('quater').value=0;
    })
</script>
@stop