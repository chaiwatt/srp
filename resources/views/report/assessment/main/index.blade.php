@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                {{-- รายการประเมินผล ปีงบประมาณ : {{ $project->year_budget }} --}}
                รายการประเมินผล ปีงบประมาณ : 
            </div>
        </div>

    </div>

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
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                    
                    @if( $month != null || $quater != null )
                        <a href="{{ URL::route('assessment.main.export.excel',['month' => $month , 'quater' => $quater , 'setyear' => $setyear ]) }}" class="btn btn-sm btn-info">Excel</a>
                        <a href="{{ URL::route('assessment.main.export.pdf',['month' => $month , 'quater' => $quater , 'setyear' => $setyear]) }}" class="btn btn-sm btn-warning">PDF</a>
                        {{-- <a href="{{ URL::route('followup.export.word',['month' => $month , 'quater' => $quater , 'setyear' => $setyear]) }}" class="btn btn-sm btn-default">Word</a> --}}
                    @endif
                    
                </div>
                {!! Form::close() !!}
            </div>
        </div> 


</div>
    <div class="padding-md">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" style="background-color:white;">
                <thead>
                    <tr>
                        <th rowspan="2">สังกัด</th>
                        <th rowspan="2">จำนวนผู้ประเมิน</th>
                        <th colspan="3" class="text-center">ผลการประเมิน</th>
                        <th rowspan="2">จำนวนผู้ติดตาม</th>
                        <th colspan="6" class="text-center">สถานะผู้ประเมิน</th>
                        <th colspan="2" class="text-center">ต้องการสนับสนุน</th>
                        <th colspan="2" class="text-center">สัมพันธ์ในครอบครัว</th>
                    </tr>
                    <tr>                                   
                        <th class="text-center">ดีเด่น</th>
                        <th class="text-center">ดี</th>
                        <th class="text-center">ปรับปรุง</th>
                        <th class="text-center">มีงาน</th>
                        <th class="text-center">ไม่มีงาน</th>
                        <th class="text-center">ศึกษาต่อ</th>
                        <th class="text-center">ตาย</th>
                        <th class="text-center">ถูกจับ</th>
                        <th class="text-center">ติดตามไม่ได้</th>
                        <th class="text-center">ต้องการ</th>
                        <th class="text-center">ไม่ต้องการ</th>
                        <th class="text-center">ดี</th>
                        <th class="text-center">มีปัญหา</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalsassessment=0;
                        $totalbest=0;
                        $totalgood=0;
                        $totalfair=0;
                        $totalfollow = 0;
                        $totalhasjob = 0;
                        $totalnojob = 0;
                        $totaleducate = 0;
                        $totaldead = 0;
                        $totalarrest = 0;
                        $totaluncontact = 0;
                        $totalneedhelp = 0;
                        $totalnoneedhelp = 0;
                        $totalgoodrelation = 0;
                        $totalbadrelation = 0;
                    @endphp
                    @foreach ($department as $item)
                    @php
                        $totalsassessment += $assessee->count();
                        $totalbest += $assessee->where('score_id',1)->count();
                        $totalgood += $assessee->where('score_id',2)->count();
                        $totalfair += $assessee->where('score_id',3)->count();
                        $totalfollow += $assessee->where('follower_status_id','!=',0)->count() ;
                        $totalhasjob += $assessee->where('follower_status_id',2)->count();
                        $totalnojob += $assessee->where('follower_status_id',3)->count();
                        $totaleducate += $assessee->where('follower_status_id',4)->count();
                        $totaldead += $assessee->where('follower_status_id',5)->count();
                        $totalarrest += $assessee->where('follower_status_id',6)->count();
                        $totaluncontact += $assessee->where('follower_status_id',7)->count();
                        $totalneedhelp += $assessee->where('needsupport_id',2)->count();
                        $totalnoneedhelp += $assessee->where('needsupport_id',3)->count();
                        $totalgoodrelation += $assessee->where('familyrelation_id',2)->count();
                        $totalbadrelation += $assessee->where('familyrelation_id',3)->count();
                    @endphp
                        <td>{{$item->departmentname}}</td>
                        <td class="text-center">{{$assessee->count()}}</td>
                        <td class="text-center">{{$assessee->where('score_id',1)->count()}}</td>
                        <td class="text-center">{{$assessee->where('score_id',2)->count()}}</td>
                        <td class="text-center">{{$assessee->where('score_id',3)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id','!=',0)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',2)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',3)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',4)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',5)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',6)->count()}}</td>
                        <td class="text-center">{{$assessee->where('follower_status_id',7)->count()}}</td>
                        <td class="text-center">{{$assessee->where('needsupport_id',2)->count()}}</td>
                        <td class="text-center">{{$assessee->where('needsupport_id',3)->count()}}</td>
                        <td class="text-center">{{$assessee->where('familyrelation_id',2)->count()}}</td>
                        <td class="text-center">{{$assessee->where('familyrelation_id',3)->count()}}</td>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-center" ><strong>สรุปรายการ</strong> </td>
                        <td class="text-center"><strong>{{ $totalsassessment }}</strong></td>                                        
                        <td class="text-center"><strong>{{ $totalbest }}</strong></td>                                        
                        <td class="text-center"><strong>{{ $totalgood }}</strong></td>   
                        <td class="text-center"><strong>{{ $totalfair }}</strong></td>   
                        <td class="text-center"><strong>{{ $totalfollow }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalhasjob }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalnojob }}</strong></td>  
                        <td class="text-center"><strong>{{ $totaleducate }}</strong></td>  
                        <td class="text-center"><strong>{{ $totaldead }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalarrest }}</strong></td>  
                        <td class="text-center"><strong>{{ $totaluncontact }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalneedhelp }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalnoneedhelp }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalgoodrelation }}</strong></td>  
                        <td class="text-center"><strong>{{ $totalbadrelation }}</strong></td>  
                    </tr>
                </tfoot>
            </table>        
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