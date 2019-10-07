    @extends('layout.mains')

    @section('pageCss')
    @stop
    
    @section('content')
    <div class="padding-md">
    
        <ul class="breadcrumb">
            <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
            <li>รายการคืนเงิน</li>    
        </ul>
    
        <div class="row">
            <div class="col-sm-9">
                <div class="page-title">
                    รายการคืนเงิน ปีงบประมาณ : {{ $project->year_budget }}
                </div>
            </div>
        </div>
    
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
    
        <div class="row padding-md pull-right" >
                <div class="col-sm-12">
                    {!! Form::open([ 'method' => 'get' , 'id' => 'myform' ]) !!}
                    <div class="form-inline no-margin">
                        <div class="form-group">
                            <label >ปีงบประมาณ</label>
                            <select class="form-control" name="settingyear" id="settingyear" >
                                @foreach( $settingyear as $key => $item )                        
                                    <option value ="{{$item->setting_year}}" @if ($item->setting_year == $setyear) selected @endif >{{$item->setting_year}}</option>
                                @endforeach
                            </select>
                        </div> 
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
                            <a href="{{ URL::route('refund.export.main.excel',['month' => $month , 'quater' => $quater, 'setyear' => $setyear ]) }}" class="btn btn-sm btn-info">Excel</a>
                            <a href="{{ URL::route('refund.export.main.pdf',['month' => $month , 'quater' => $quater, 'setyear' => $setyear ]) }}" class="btn btn-sm btn-warning">PDF</a>
                            <a href="{{ URL::route('refund.export.main.word',['month' => $month , 'quater' => $quater, 'setyear' => $setyear ]) }}" class="btn btn-sm btn-default">Word</a>
                        @endif
                        
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>  
        
        <div class="row">
                <div class="col-sm-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการคืนเงิน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">                
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">วันที่คืน</th>
                                <th class="text-left">หน่วยงาน</th>
                                <th class="text-left">รายการค่าใช้จ่าย</th>
                                <th class="text-center">จำนวนเงินคืน</th>                            
                                <th class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalwaiting_price_view=0;
                            @endphp
                            @if( count($allrefund) > 0 )
                            @foreach( $allrefund as $key => $item )
                            @php
                                $totalwaiting_price_view += $item->waiting_price_view ;
                            @endphp
                                <tr>
                                    <td class="text-left">{{ $item->refunddate }}</td>
                                    <td class="text-left">{{ $item->departmentname }}</td>
                                    <td class="text-left">{{ $item->budgetname }}</td>
                                    <td class="text-center">{{ number_format( $item->waiting_price_view , 2 ) }}</td>                                
                                    @if( $item->waiting_status == 1)
                                        <td class="text-center"><span class="text-default">ยืนยันแล้ว</span></td>
                                        @else
                                        <td class="text-center"><span class="text-danger">รอการยืนยัน</span></td>
                                    @endif
                                </tr>                             
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                <td class="text-center"><strong>{{  number_format($totalwaiting_price_view, 2 )  }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    
    @stop
    
    @section('pageScript')
    <script type="text/javascript">
        $(".table").dataTable();
    
        $("#quater").change(function(){
            document.getElementById('month').value=0;
        })
    
        $("#month").change(function(){
            document.getElementById('quater').value=0;
        })
    </script>
    
    @stop
