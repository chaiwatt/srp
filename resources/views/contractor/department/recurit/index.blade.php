@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานผลการจ้างงานรายบุคคล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานผลการจ้างงานรายบุคคล : ปีงบประมาณ {{ $project->year_budget }} 
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
                    <a href="{{ URL::route('recurit.report.department.recurit.export.excel',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-info">Excel</a>
                    <a href="{{ URL::route('recurit.report.department.recurit.export.pdf',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-warning">PDF</a>
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>  

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> ผลการจ้างงานรายบุคคล </div> 
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
                                    <th>สังกัด</th>
                                    <th >ชื่อ นามสกุล</th>
                                    <th >เลขประจำตัว</th>
                                    <th >การศึกษา</th>
                                    <th >อายุ</th>
                                    <th >เลขที่จ้างงาน</th>
                                    <th >ตำแหน่ง</th>
                                    <th >เริ่มจ้าง</th>
                                    <th >สิ้นสุดจ้าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($employ) > 0 )
                                @foreach( $employ as $key => $item )
                                    @php
                                        $_contractor = $contractor->where('contractor_id', $item->register_id)->first();
                                         
                                    @endphp
                                    @if (count($_contractor) !=0 )
                                        @php
                                            $_education = $education->where('contractor_id',$_contractor->contractor_id)
                                                                ->where('contractor_education_name','!=',"")
                                                                ->last();
                                            if(count($_education) !=0 ){
                                                $educate = $_education->contractor_education_name;
                                            }else{
                                                $educate ="";
                                            }                
                                        @endphp
                                        <tr>
                                            <td>{{ $_contractor->departmentname }}</td>
                                            <td>{{ $_contractor->prefixname }}{{ $_contractor->name }} {{ $_contractor->lastname }}</td>
                                            <td>{{ $_contractor->person_id }}</td>
                                            <td>{{ $educate }}</td>
                                            <td>{{ $_contractor->ageyear }}</td>
                                            <td>{{$_contractor->department_id}}{{$_contractor->section_id}}{{$_contractor->position_id}}{{$_contractor->contractor_id}}-{{$_contractor->year_budget}}</td>
                                            <td>{{ $_contractor->positionname }}</td>
                                            <td>{{ $_contractor->starthiredateinputth }}</td>
                                            <td>{{ $_contractor->endhiredateinputth }}</td> 
                                        </tr>  
                                    @endif
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