@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมวิชาชีพ(รายได้เพียงพอ)</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                    รายการฝึกอบรมวิชาชีพ(รายได้เพียงพอ) ปีงบประมาณ : {{$setting->setting_year}} 
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
                    <a href="{{ URL::route('followup.enoughincome.export.excel',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-info">Excel</a>
                    <a href="{{ URL::route('followup.enoughincome.export.pdf',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-warning">PDF</a>
                    <a href="{{ URL::route('followup.enoughincome.export.word',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-default">Word</a>
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>    

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายการฝึกอบรมวิชาชีพ(รายได้เพียงพอ)
                    @if(count($quatername)>0)
                        : {{$quatername->quater_name}}
                    @endif 
                    @if(count($monthname) > 0)
                        : เดือน {{$monthname->month_name}}
                    @endif 
                </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >หน่วยงาน</th>
                                    <th class="text-center">จำนวนโครงการ</th>
                                    <th class="text-center">จำนวนผู้มีอาชีพ</th>
                                    <th class="text-center">จำนวนผู้มีรายได้เพียงพอ</th>
                                    <th class="text-center">ร้อยละการมีรายได้เพียงพอ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($readiness) > 0 )
                                @php
                                    $totalhasoccupation = 0;
                                    $totalenoughincome =0;
                                @endphp
                                    @foreach( $department as $item )
                                        @php
                                            $num = $readiness->where('department_id', $item->department_id)->count();
                                            $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                                            $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                                            $registers = $participategroup->where('department_id', $item->department_id)->all();
                                            $hasoccupation=0;
                                            $hasoccupation_enoughincome =0;
                                            if (count($registers) !=0 ){
                                                foreach($registers as $_item){
                                                    $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                            ->where('occupation_id','!=',1)
                                                                                            ->first();
                                                    if(count($registerhasoccupation) != 0 ){
                                                        $hasoccupation = $hasoccupation + 1;
                                                        $totalhasoccupation++;
                                                    }

                                                    $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                                            ->where('occupation_id','!=',1)
                                                                                            ->where('enoughincome_id',2)
                                                                                            ->first();
                                                    if(count($registerhasoccupationenoughincome) != 0 ){
                                                        $hasoccupation_enoughincome++;
                                                        $totalenoughincome++;
                                                    }
                                                }
                                        }
                                        @endphp
                                        @if ($num != 0)
                                        <tr>
                                            <td >{{ $item->department_name }}</td>
                                            <td class="text-center">{{ $num }}</td>
                                            <td class="text-center">{{ $hasoccupation }}</td>
                                            <td class="text-center">{{ $hasoccupation_enoughincome }}</td>
                                            @if ($hasoccupation !=0 )
                                            <td class="text-center">{{ number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2) }}</td>                                         
                                                @else
                                                <td class="text-center"></td>                                         
                                            @endif 
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif

                            </tbody>
                            @if( count($readiness) > 0 )
                            @php
                                $num = $readiness->count();
                                $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                                $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                                if ($totalenoughincome !=0 ){
                                    $percent = number_format( ($totalenoughincome / $totalhasoccupation) * 100 , 2);
                                }else{
                                    $percent=0;
                                }   
                            @endphp
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="1"><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong>{{ $readiness->count() }}</strong></td>                                        
                                        <td class="text-center"><strong>{{ $totalhasoccupation }}</strong></td>
                                        <td class="text-center"><strong>{{ $totalenoughincome }}</strong></td>
                                        <td class="text-center"><strong>{{ $percent }}</strong></td>
                                    </tr>
                                </tfoot>
                            @endif

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-4">
            <div id="chartContainerdept1" ></div>
        </div>
        <div class="col-sm-4">
            <div id="chartContainerdept2" ></div>
        </div>
        <div class="col-sm-4">
            <div id="chartContainerdept3" ></div>
        </div>
    </div> 
</div>


@stop

@section('pageScript')


@stop