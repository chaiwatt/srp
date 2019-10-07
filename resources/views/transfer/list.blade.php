@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการ โอนงบประมาณ</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                รายการโอนงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="{{ url('transfer/create/') }}" class="btn btn-success"><i class="fa fa-plus"></i> โอนงบประมาณ</a>
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


    @foreach( $budgetlist as  $val )
    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการโอนงบประมาณ {{$val->budget_name}}</div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>หน่วยงาน</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">งวดงานที่รับโอน</th>
                            <th class="text-center">จำนวนเงินโอน</th>
                            <th class="text-center">คงเหลือ</th>
                            <th class="text-center">ร้อยละรับโอน</th>
                            <th class="text-right">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalallocation =0;
                            $totalnumtransfer =0;
                            $totalsumtransfer =0;
                        @endphp

                        @foreach( $department as $key => $item )
                        @php
                            $_allocation = $allocation->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->where('allocation_price','!=',0)->first();

                            $_transfercount = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->count();

                            $_sumtransfer = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->sum('transfer_price');

                            $_transfer_id = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->first();
                            
                        @endphp
                            @if (count($_allocation) != 0 && $_transfercount !=0 )
                                @php
                                    $totalallocation += $_allocation->allocation_price;
                                    $totalnumtransfer += $_transfercount;
                                    $totalsumtransfer += $_sumtransfer;
                                @endphp
                                <tr>
                                    <td>{{ $item->department_name }}</td>
                                    <td class="text-center">{{ number_format( $_allocation->allocation_price, 2 ) }}</td>
                                    <td class="text-center">{{ $_transfercount }}</td>
                                    <td class="text-center">{{ number_format( $_sumtransfer , 2 ) }}</td>
                                    <td class="text-center">{{ number_format( ($_allocation->allocation_price - $_sumtransfer) , 2 ) }}</td>
                                    <td class="text-center">{{ number_format( ($_sumtransfer/$_allocation->allocation_price )*100, 2) }}</td>
                                    <td class="text-right">
                                        <a href="{{ url('transfer/view/'.$_transfer_id->transfer_id) }}" class="btn btn-info btn-xs"> เพิ่มเติม</a>
                                    </td> 
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format( $totalallocation, 2 )  }}</strong></td>
                            <td class="text-center"><strong>{{$totalnumtransfer}}</strong></td>
                            <td class="text-center"><strong>{{ number_format($totalsumtransfer , 2 ) }}</strong></td>
                            <td class="text-center"><strong>{{number_format( ($totalallocation - $totalsumtransfer) , 2 ) }}</strong></td>
                            <td class="text-center"><strong>{{number_format( ($totalsumtransfer/$totalallocation)*100, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endforeach


</div>

@stop

@section('pageScript')
{{-- <script type="text/javascript">
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/budget') }}",
            dataType:"Json",
            data:{
                budget : "{{ $budget }}",
            },
            success : function(data){
                var html = "<option value=''>เลือกค่าใช้จ่าย</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.budget[i].budget_id == data.filter_budget ){
                            html += "<option value='"+ data.budget[i].budget_id +"' selected>" + data.budget[i].budget_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.budget[i].budget_id +"' > " + data.budget[i].budget_name +"</option>"
                        }
                    }
                }

                $("#budget").html(html);
                // $("#budget").select2();
            }
        })
    })
</script> --}}
@stop