@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานรายการลาออก</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานรายการลาออก ปีงบประมาณ : {{$setting->setting_year}}
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
                <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                
                
                @if( $month != null )
                    {{-- <a id="exportexcel" class="btn btn-sm btn-info">Excel</a> --}}
                    {{-- <a href="{{ URL::route('allocation.export.excel',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-info">Excel</a> --}}
                    <a href="{{ URL::route('resign.main.export.pdf',['month' => $month ]) }}" class="btn btn-sm btn-warning">PDF</a>
                    {{-- <a href="{{ URL::route('allocation.export.word',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-default">Word</a> --}}
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>    

    @if( count($numdepartment) > 0 )
    @foreach( $numdepartment as $key => $item )
    <div class="row">
        <div class="col-md-12">

            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">{{$item->department_name}}  
                    @if(count($monthname) > 0)
                        : เดือน {{$monthname->month_name}}
                    @endif 
                </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped" >
                            <thead>
                                <tr>
                                    @if( count($position) > 0 )
                                        @foreach( $position as $_item )
                                            @if ($item->department_id == $_item->department_id )
                                                <th>{{ $_item->position_name }}</th>
                                            @endif
                                        @endforeach
                                    @endif
                                    <th class="text-right">รวม</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $sumposition=0;
                                @endphp
                                @foreach( $position as $value )
                                    @if ($item->department_id == $value->department_id )
                                        @php
                                            $value = $resign->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->count();
                                            $sumposition = $sumposition +   $value ;
                                        @endphp
                                        <td>{{ $value }}</td>
                                    @endif
                                @endforeach
                                <td class="text-right"><strong>{{ $sumposition }}</strong> </td>
                            </tbody> 
                        </table>
                        <hr>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><u>เหตุผลการลาออก</u> </th>
                                    <th class="text-right">จำนวน</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if( count($reason) > 0 )
                                    @foreach( $reason as $key => $check )

                                    @if ($item->department_id == $check->department_id )
                                        <tr>
                                            <td >{{ $check->reasonname }}</td>
                                            <td class="text-right">{{ $resign->where('reason_id' , $check->reason_id)->where('department_id', $item->department_id)->count() }}</td>
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

    @endforeach
    @endif

</div>


@stop

@section('pageScript')
<script type="text/javascript">
    $("#resign").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
</script>

@stop