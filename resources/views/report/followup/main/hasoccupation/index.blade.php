@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมวิชาชีพ(มีอาชีพ)</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                    รายการฝึกอบรมวิชาชีพ(มีอาชีพ) ปีงบประมาณ : {{$setting->setting_year}} 
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
                </div><!-- /form-group -->
                <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                     
                @if( $month != null || $quater != null )
                    <a href="{{ URL::route('followup.hasoccupation.export.excel',['month' => $month , 'quater' => $quater , 'setyear' => $setyear ]) }}" class="btn btn-sm btn-info">Excel</a>
                    <a href="{{ URL::route('followup.hasoccupation.export.pdf',['month' => $month , 'quater' => $quater , 'setyear' => $setyear ]) }}" class="btn btn-sm btn-warning">PDF</a>
                    <a href="{{ URL::route('followup.hasoccupation.export.word',['month' => $month , 'quater' => $quater , 'setyear' => $setyear ]) }}" class="btn btn-sm btn-default">Word</a>
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>    

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายการฝึกอบรมวิชาชีพ(มีอาชีพ)
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
                                    <th >สังกัดกรม</th>
                                    <th class="text-center">จำนวนโครงการ</th>
                                    <th class="text-center">จำนวนหน่วยงานที่จัด</th>
                                    <th class="text-center">จำนวนผู้เข้าร่วม</th>
                                    <th class="text-center">จำนวนผู้มีอาชีพ</th>
                                    <th class="text-center">ร้อยละการมีอาชีพ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @if( count($readinesssection) > 0 )
                                @php
                                    $total_actualparticipate=0;
                                    $total_sum=0;
                                    $totalhasoccupation = 0;
                                    $totalnumsum=0;
                                    $totalnumsection =0;
                                    $totalactualparticipate =0;
                                @endphp
                                    @foreach( $department as $item )
                                        @php
                                            $num = $readinesssection->where('department_id', $item->department_id)->groupBy('project_readiness_id')->count();
                                            $numsection = count($readinesssection->where('department_id', $item->department_id)->groupBy('section_id')->all());
                                             $actualparticipate = 0;
                                             $sum=0;
                                           
                                             $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            

                                                foreach($_readinesssection as $sec){
                                                    $actualparticipate = $participategroup->where('department_id' , $sec->department_id)->count();
                                                    $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                    $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                    $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                }    
                                            $registers = $participategroup->where('department_id', $item->department_id)->all();

                                            $hasoccupation=0;
                                            if (count($registers) !=0 ){
                                            foreach($registers as $_item){
                                               
                                                $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                        ->where('occupation_id','!=',1)
                                                                                        ->first();
                                                if(count($registerhasoccupation) != 0 ){
                                                    $hasoccupation = $hasoccupation + 1;
                                                    $totalhasoccupation++;
                                                }
                                            }
                                        }
                                        $totalnumsum += $num ;
                                        $totalnumsection += $numsection;
                                        $totalactualparticipate += $actualparticipate;
                                        @endphp

                                        <tr>
                                            <td >{{ $item->department_name }}</td>
                                            <td class="text-center">{{ $num }}</td>
                                            <td class="text-center">{{ $numsection }}</td> 
                                            <td class="text-center">{{ $actualparticipate }}</td>
                                            <td class="text-center">{{ $hasoccupation }}</td>
                                            @if ($actualparticipate !=0 )
                                            <td class="text-center">{{ number_format( ($hasoccupation/ $actualparticipate) * 100 , 2) }}</td>                                         
                                                @else
                                                <td class="text-center">0</td>                                         
                                            @endif
                                        </tr>

                                    @endforeach
                                @endif

                            </tbody>
                            <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong>{{$totalnumsum}}</strong></td>
                                        <td class="text-center"><strong>{{$totalnumsection}}</strong></td>
                                        <td class="text-center"><strong>{{$totalactualparticipate}}</strong></td>
                                        <td class="text-center"><strong>{{$totalhasoccupation}}</strong></td>
                                        @if ($totalactualparticipate !=0 )
                                        <td class="text-center"><strong>{{ number_format( ($totalhasoccupation/ $totalactualparticipate) * 100 , 2) }}</strong></td>                                         
                                            @else
                                            <td class="text-center">0</td>                                         
                                        @endif
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

</script>

<script type="text/javascript">
    var chartdata_mapdept1 = [];
    var chartdata_mapdept2 = [];
    var chartdata_mapdept3 = [];
    var chartdata_province_dept1 = [];
    var chartdata_province_dept2 = [];
    var chartdata_province_dept3 = [];
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/report/main/hasincome') }}",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                if(data._row1dept > 0){

                    if(data._row1dept > 0){
                        for(var i=0;i<data._row1dept;i++){
                            chartdata_mapdept1.push({
                                'id': data.recuritdata_dept1[i].id,
                                'value': data.recuritdata_dept1[i].value,                               
                                'custom': data.recuritdata_dept1[i].custom,   
                            });

                            chartdata_province_dept1.push({
                                'label': data.recuritdata_dept1[i].province,
                                'value': data.recuritdata_dept1[i].value,                               
                            });
                        }
                    }
                    if(data._row2dept > 0){
                        for(var i=0;i<data._row2dept;i++){
                            chartdata_mapdept2.push({
                                'id': data.recuritdata_dept2[i].id,
                                'value': data.recuritdata_dept2[i].value,                               
                                'custom': data.recuritdata_dept2[i].custom,   
                            });

                            chartdata_province_dept2.push({
                                'label': data.recuritdata_dept2[i].province,
                                'value': data.recuritdata_dept2[i].value,                               
                            });
                        }
                    }                   
                    if(data._row3dept > 0){
                        for(var i=0;i<data._row3dept;i++){
                            chartdata_mapdept3.push({
                                'id': data.recuritdata_dept3[i].id,
                                'value': data.recuritdata_dept3[i].value,                               
                                'custom': data.recuritdata_dept3[i].custom,   
                            });

                            chartdata_province_dept3.push({
                                'label': data.recuritdata_dept3[i].province,
                                'value': data.recuritdata_dept3[i].value,                               
                            });
                        }
                    }

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept1",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept1
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept1) {
                                getallocatedept1(chartdata_mapdept1.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept2",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept2
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept2) {
                                getallocatedept2(chartdata_mapdept2.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept3",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept3
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept3) {
                                getallocatedept3(chartdata_mapdept3.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });


                    $(function(){
                        Morris.Donut({
                            element: 'donutdept1',
                            data: chartdata_province_dept1,
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept2',
                            data: chartdata_province_dept2,
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept3',
                            data: chartdata_province_dept3,
                        });
                    });
                }
            }
        })
    })
</script>

<script type="text/javascript">
    function getallocatedept1(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept1.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept1[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept1[i].message);
                return; 
            }
        }
    } 
    function getallocatedept2(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept2.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept2[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept2[i].message);
                return; 
            }
        }
    } 
    function getallocatedept3(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept3.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept3[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept3[i].message);
                return; 
            }
        }
    } 
</script>

<script type="text/javascript">
    $("#quater").change(function(){
        document.getElementById('month').value=0;
    })
</script>

<script type="text/javascript">
    $("#month").change(function(){
        document.getElementById('quater').value=0;
    })
</script>


@stop