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
                    {{-- <a id="exportexcel" class="btn btn-sm btn-info">Excel</a> --}}
                    <a href="{{ URL::route('budget.export.excel',['month' => $month , 'quater' => $quater, 'setyear' => $setyear  ]) }}" class="btn btn-sm btn-info">Excel</a>
                    <a href="{{ URL::route('budget.export.pdf',['month' => $month , 'quater' => $quater , 'setyear' => $setyear  ]) }}" class="btn btn-sm btn-warning">PDF</a>
                    <a href="{{ URL::route('budget.export.word',['month' => $month , 'quater' => $quater , 'setyear' => $setyear  ]) }}" class="btn btn-sm btn-default">Word</a>
                @endif
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>    

    <div style="height:800px;">
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
                                @if( count($section) > 0 )
                                @foreach( $section as $key => $item )
                                    @php( $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary') )
                                    @php( $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence') )
                                    @php( $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') )
                                    <tr>
                                        <td class="text-left">{{ $item->section_name }}</td>
                                        <td class="text-center">{{ number_format( $paid, 2 ) }}</td>
                                        <td class="text-center">{{ number_format( $absence , 2 ) }}</td>
                                        <td class="text-center">{{ number_format( $fine, 2 ) }}</td>                           
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            @if( count($section) > 0 )
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="1" ><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum('payment_salary'), 2 ) }}</strong> </td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum('payment_absence'), 2 )  }}</strong> </td>
                                        <td class="text-center"><strong>{{ number_format( $payment->sum('payment_fine'), 2 )  }}</strong> </td>
                                    </tr>
                                </tfoot>
                            @endif
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
                <div class="smart-widget-header"> เปอร์เซนต์ รายการเบิกจ่ายแยกตามจังหวัด</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donut-curit-by-province" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จำนวน รายการเบิกจ่ายแยกตามหน่วยงาน</div>
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
            url:"{{ url('api/report/department/budget') }}",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                if(data.row > 0){

                    if(data.row > 0){
                        for(var i=0;i<data.row;i++){
                            chartdata_map.push({
                                'id': data.recuritdata[i].id,
                                'value': data.recuritdata[i].value,                               
                                'custom': data.recuritdata[i].custom,   
                            });

                            chartdata_province.push({
                                'label': data.recuritdata[i].province,
                                'value': data.recuritdata[i].value,                               
                            });
                        }
                    }

                    if(data._row > 0){
                        for(var i=0;i<data._row;i++){
                            chartdata_section.push({
                                'label': data.recuritdatabysection[i].label,
                                'value': data.recuritdatabysection[i].value,                               
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
                        });
                    })
                }
            }
        })
    })
</script>

<script type="text/javascript">
    function customaction(mapcode,data){
       $count = data.recuritdata.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata[i].message);
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