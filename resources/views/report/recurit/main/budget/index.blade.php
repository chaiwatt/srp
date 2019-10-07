@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานรายการเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานรายการเบิกจ่ายเงินเดือน ปีงบประมาณ : {{$setting->setting_year}} 
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
                    <a href="{{ URL::route('main.budget.export.excel',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-info">Excel</a>
                    <a href="{{ URL::route('main.budget.export.pdf',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-warning">PDF</a>
                    <a href="{{ URL::route('main.budget.export.word',['month' => $month , 'quater' => $quater ]) }}" class="btn btn-sm btn-default">Word</a>
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>    


    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายการเบิกจ่ายเงินเดือน
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
                                    <th class="text-center">หน่วยงาน</th>
                                    <th class="text-center">เบิกจ่ายเงินเดือน</th>
                                    <th class="text-center">หักขาดงาน</th>
                                    <th class="text-center">หักอื่นๆ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($department) > 0 )
                                    @foreach( $department as $item )
                                        @php( $paid = $payment->where('department_id' , $item->department_id)->sum('payment_salary')  )
                                        @php( $absence = $payment->where('department_id' , $item->department_id)->sum('payment_absence')  )
                                        @php( $fine = $payment->where('department_id' , $item->department_id)->sum('payment_fine')  )
                                        <tr>
                                            <td class="text-left">{{ $item->department_name }}</td>
                                            <td class="text-center">{{ $paid }}</td>
                                            <td class="text-center">{{ $absence }}</td>
                                            <td class="text-center">{{ $fine }}</td> 
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                            @if( count($department) > 0 )
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="1"><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong>{{ $payment->sum('payment_salary') }}</strong></td>
                                        <td class="text-center"><strong>{{ $payment->sum('payment_absence') }}</strong></td>
                                        <td class="text-center"><strong>{{ $payment->sum('payment_fine') }}</strong></td>
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
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
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
            url:"{{ url('api/report/main/budget') }}",
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