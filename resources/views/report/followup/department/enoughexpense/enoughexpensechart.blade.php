@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานการติดตามฝึกอบรมวิชาชีพ</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                รายงานการติดตามฝึกอบรมวิชาชีพ(รายได้เพียงพอ) ปีงบประมาณ : {{$setting->setting_year}} 
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
                <div id="chartContainer"></div>
            </div>
            <div class="col-md-6">
                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> เปอร์เซนต์ ผู้มีรายได้เพียงพอหลังฝึกอบรมแยกตามจังหวัด</div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            <div id="donut-curit-by-province" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> จำนวน ผู้มีรายได้เพียงพอหลังฝึกอบรมแยกตามหน่วยงาน</div>
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
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
</script>

<script type="text/javascript">
    var chartdata_map = [];
    var chartdata_province = [];
    var chartdata_section = [];
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/report/department/occupationfollowupenoughexpense') }}",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                if(data.row > 0){

                    if(data.row > 0){
                        for(var i=0;i<data.row;i++){
                            chartdata_map.push({
                                'id': data.occupationdata[i].id,
                                'value': data.occupationdata[i].value,                               
                                'custom': data.occupationdata[i].custom,   
                            });

                            chartdata_province.push({
                                'label': data.occupationdata[i].province,
                                'value': data.occupationdata[i].value,                               
                            });
                        }
                    }

                    if(data._row > 0){
                        for(var i=0;i<data._row;i++){
                            chartdata_section.push({
                                'label': data.occupationdatabysection[i].label,
                                'value': data.occupationdatabysection[i].value,                               
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
       $count = data.occupationdata.length;
        for (i = 0; i < $count ; i++) {
            if (data.occupationdata[i].id == mapcode.toUpperCase()) {
               alert (data.occupationdata[i].message);
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