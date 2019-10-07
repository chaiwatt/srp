@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานฝึกอบรมและเตรียมความพร้อม</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                รายงานฝึกอบรมและเตรียมความพร้อม ปีงบประมาณ : {{$setting->setting_year}} 
            </div>
        </div>
    </div>  

    <div style="height:800px;">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายการฝึกอบรม </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่</th>
                                    <th >โครงการ</th>                                    
                                    <th class="text-center">จำนวนหน่วยงาน</th>
                                    <th class="text-center">เป้าหมายเข้าร่วม</th>
                                    <th class="text-center">เข้าร่วม</th>                                    
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $totalsection =0;
                                    $totaltarget = 0;
                                    $totalactualparticipate =0;
                                @endphp

                                @if( count($projectreadiness) > 0 )
                                @foreach( $projectreadiness as $key => $item )                 
                                    @php                                           
                                        $actualparticipate = $participategroup->where('project_readiness_id' , $item->project_readiness_id)->count();                                            
                                        $num = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->groupBy('section_id')->count();
                                        $_target = $readiness->where('project_readiness_id',$item->project_readiness_id)->first()->targetparticipate * $num ;    
                                        $totalsection += $num;
                                        $totaltarget += $_target;
                                        $totalactualparticipate += $actualparticipate;
                                    @endphp
                                    <tr>
                                        <td >{{ $item->adddate  }}</td>
                                        <td >{{ $item->project_readiness_name }}</td>                                            
                                        <td class="text-center">{{ $num }}</td>
                                        <td class="text-center">{{$_target}}</td>
                                        <td class="text-center">{{ $actualparticipate }}</td>   
                                    </tr>
                                @endforeach
                                
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong>{{ $totalsection }}</strong> </td>                                             
                                    <td class="text-center"><strong>{{ $totaltarget }}</strong> </td>   
                                    <td class="text-center"><strong>{{ $totalactualparticipate }}</strong> </td> 
                                
                                </tr>
                            </tfoot>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div id="chartContainer"></div>
        </div>
        <div class="col-md-6">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เปอร์เซนต์ การเข้าร่วมฝึกอบรมแยกตามจังหวัด</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donut-curit-by-province" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จำนวน การเข้าร่วมฝึกอบรมแยกตามหน่วยงาน</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donut-curit-by-section" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">
    // $(".table").dataTable({
    //     "language": {
    //     "search": "ค้นหา "
    //     },
    //     "pageLength": 5
    // });
</script>

<script type="text/javascript">
    var chartdata_map = [];
    var chartdata_province = [];
    var chartdata_section = [];
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/report/department/readiness') }}",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                if(data.row > 0){

                    if(data.row > 0){
                        for(var i=0;i<data.row;i++){
                            chartdata_map.push({
                                'id': data.readinessdata[i].id,
                                'value': data.readinessdata[i].value,                               
                                'custom': data.readinessdata[i].custom,   
                            });

                            chartdata_province.push({
                                'label': data.readinessdata[i].province,
                                'value': data.readinessdata[i].value ,                               
                            });
                        }
                    }

                    if(data._row > 0){
                        for(var i=0;i<data._row;i++){
                            chartdata_section.push({
                                'label': data.readinessdatabysection[i].label,
                                'value': data.readinessdatabysection[i].value,                               
                            });
                        }
                    }

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainer",
                            "width": "100%",
                            "height": "840",
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
                            "data": chartdata_map
                            },
                            "events": {"entityClick": function(evt, chartdata_map) {
                                customaction(chartdata_map.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donut-curit-by-province',
                            data: chartdata_province,
                            formatter: function (y) { return y+"%"},
                        });
                    })

                    $(function(){
                        Morris.Donut({
                            element: 'donut-curit-by-section',
                            data: chartdata_section,
                            xkey: 'id',
                            formatter: function (y) { return y+"คน"},
                        });
                    })
                }
            }
        })
    })
</script>

<script type="text/javascript">
    function customaction(mapcode,data){
       $count = data.readinessdata.length;
        for (i = 0; i < $count ; i++) {
            if (data.readinessdata[i].id == mapcode.toUpperCase()) {
               alert (data.readinessdata[i].message);
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


<script type="text/javascript">
    
       $("#exportexcel").click(function(event) {
    //    event.preventDefault();
        var _month = document.getElementById("month").value ;
        var _quater = document.getElementById("quater").value ;

        $(function(){
            $.ajax({
                type:"get",
                url:"{{ url('report/recurit/department/excel') }}",
                dataType:"Json",
                data:{
                    month : _month,
                    quater : _quater,
                },
                success : function(data){
                    var a = document.createElement("a");
                    a.href = data.file; 
                    a.download = data.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }
            })
        })


       });
  
    </script>



@stop