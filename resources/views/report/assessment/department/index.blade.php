@extends('layout.mains')

@section('pageCss')

@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">เว็บไซต์</a></li>
        <li><a href="{{ url('assesment/section') }}">รายการประเมินผล</a></li>
        <li>การประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                {{-- การประเมินผล: {{$assessment->assesment_name}} --}}
                การประเมินผล
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                {{-- <a href="{{ url('report/assessment/section/excel/'.$assessment->project_assesment_id) }}" class="btn btn-info">Excel</a> --}}
                {{-- <a href="{{ url('report/assessment/section/pdf/'.$assessment->project_assesment_id) }}" class="btn btn-warning">PDF</a> --}}
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
                        <a href="{{ URL::route('assessment.export.excel',['month' => $month , 'quater' => $quater , 'setyear' => $setyear ]) }}" class="btn btn-sm btn-info">Excel</a>
                        <a href="{{ URL::route('assessment.export.pdf',['month' => $month , 'quater' => $quater , 'setyear' => $setyear]) }}" class="btn btn-sm btn-warning">PDF</a>
                        {{-- <a href="{{ URL::route('followup.export.word',['month' => $month , 'quater' => $quater , 'setyear' => $setyear]) }}" class="btn btn-sm btn-default">Word</a> --}}
                    @endif
                    
                </div>
                {!! Form::close() !!}
            </div>
        </div> 
    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >หน่วยงาน</th>
                                    <th >หัวข้อการประเมิน</th>
                                    <th >ชื่อ-สกุล</th>
                                    <th >เลขที่บัตรประชาชน</th> 
                                    <th >ผลการประเมิน</th>
                                    <th >การติดตาม</th>
                                    <th >ต้องการสนับสนุน</th>
                                    <th >ความสัมพันธ์ในครอบครัว</th>
                                    <th >การมีรายได้</th>
                                    <th >การมีอาชีพ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($assessee) > 0 )
                                @foreach( $assessee as $item )
                                    <tr>
                                        <td>{{ $item->registersectionname }}</td>
                                        <td>{{ $item->projectassessmentname }}</td>
                                        <td>{{ $item->registername }}</td>
                                        <td >{{ $item->registerpersonid }}</td>
                                        <td >{{ $item->scorename }}</td>
                                        <td >{{ $item->followerstatusname }}</td>
                                        <td >{{ $item->needsupportname }} <small class="text-danger"> {{ $item->needsupport_detail }}</small></td>
                                        <td >{{ $item->familyrelationname }} <small class="text-danger"> {{ $item->familyrelation_detail }}</td>
                                        <td >{{ $item->enoughincomename}}</td>
                                        <td >{{ $item->occupationname}} <small class="text-danger"> {{ $item->occupation_detail }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
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
    $("#quater").change(function(){
        document.getElementById('month').value=0;
    })

    $("#month").change(function(){
        document.getElementById('quater').value=0;
    })
</script>

@stop