@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('transfer') }}">รายการโครงการ</a></li>
        <li><a href="{{ url('transfer/list') }}">รายการโอนงบประมาณ</a></li>
        <li>ประวัติการโอนงบประมาณ</li>
    </ul>
    {!! Form::open([ 'url' => 'transfer/department/attach' , 'method' => 'post' , 'files' => 'true' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ประวัติการโอนงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>

        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                 <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึกไฟล์แนบ</button>
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> ประวัติการโอนงบประมาณ </div>
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
                            <th >วันที่แจ้งโอน</th>
                            <th >หน่วยงาน</th>
                            <th >รายการ</th>
                            <th class="text-center">จำนวนเงินรับโอน</th>
                            <th class="text-center" colspan="2">เอกสารแนบ</th>
                            <th class="text-center">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($transfer) > 0 )
                        @foreach( $transfer as $key => $item )
                            <tr>
                                <td>{{ $item->transferdateth }}</td>
                                <td >{{ $item->departmentname }}</td>
                                <td >{{ $item->budgetname }}</td>
                                <td class="text-center">@if ($item->transfer_price < 0 ) (การคืนเงิน) @endif {{ number_format( $item->transfer_price , 2 ) }} </td>
                                <td class="text-right">
                                    @if ($item->document_file !="")
                                        <a href="{{ asset($item->document_file) }}" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-download"></i></a> 
                                        <a href="{{ url('transfer/deletefile/'.$item->transfer_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ')" > <i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">                                   
                                    <input type="file" name="document[{{$item->transfer_id}}]"  class="doc filestyle" />
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('transfer/edit/'.$item->transfer_id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    <a href="{{ url('transfer/delete/'.$item->transfer_id) }}" class="btn btn-danger  btn-xs" onclick="return confirm('ยืนยันการลบ')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

 

@stop

@section('pageScript')
<script type="text/javascript">
    $('.doc').filestyle({
        buttonName : 'btn-default  btn-xs',
        buttonText : ' แนบไฟล์',
        input: false,
        icon: false,
    });
</script>
@stop