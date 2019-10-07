@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานอบรมวิชาชีพ</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                แผนภาพรายการฝึกอบรมวิชาชีพ ปีงบประมาณ : {{$setyear}} 
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
    
    <div class="row">
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมคุมประพฤติ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept1" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมราชทัณฑ์</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept2" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมพินิจ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept3" style="height: 250px;"></div>
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
            url:"{{ url('api/report/main/occupation') }}",
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
                            formatter: function (y) { return y+"%"},
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept2',
                            data: chartdata_province_dept2,
                            formatter: function (y) { return y+"%"},
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept3',
                            data: chartdata_province_dept3,
                            formatter: function (y) { return y+"%"},
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