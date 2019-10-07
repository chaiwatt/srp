@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการยกเลิกจ้างงาน ผู้จ้างเหมา</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setting->setting_year }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
        </div>
        <div class="txt01 txt-center">
            <h1>************************************</h1>
        </div>
        		
        <table style="width:100%; " >	
                <thead>
                    <tr>
                        <th>หน่วยงาน</th>
                        @if( count($position) > 0 )
                        @foreach( $position as $item )
                            <th class="text-center">{{ $item->position_name }}</th>
                        @endforeach
                        @endif
                        <th class="text-center">รวม</th>
                    </tr>
                </thead>

                <tbody>
                    @if( count($numdepartment) > 0 )
                    @foreach( $numdepartment as $key => $item )
                    @php
                        $surveyname = $resign->where('department_id',$item->department_id)->first();
                    @endphp
                        @if ($resign->where('department_id' , $item->department_id)->count() != 0)
                            <tr>
                                <td >{{ $item->departmentname }}</td>
                                    @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $value = $resign->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->count() )
                                            <td class="text-center">{{ $value }}</td>
                                        @endforeach
                                    @endif
                                <td class="text-center">{{ $resign->where('section_id' , $item->section_id)->count() }}</td>
                            </tr>
                        @endif
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    @if( count($numdepartment) > 0 )
                        <tr>
                            <td class="text-center" ><strong>รวม</strong> </td>
                                @if( count($position) > 0 )
                                    @foreach( $position as $value )
                                        @php( $value = $resign->where('position_id' , $value->position_id)->count() )
                                        <td class="text-center">{{ $value }}</td>
                                    @endforeach
                                @endif
                            <td class="text-center"><strong>{{ $resign->count() }}</strong> </td>
                        </tr>
                    @endif
                </tfoot>
            </table>	
            <div class="txt01">
                <h1>แยกตามเหตุผล</h1>  
            </div>
                       
            <table style="width:100%; " >
                <thead>
                    <tr>
                        <th>เหตุผลการลาออก</th>
                        <th class="text-center">จำนวน</th>
                    </tr>
                </thead>

                <tbody>
                    @if( count($reason) > 0 )
                        @foreach( $reason as $key => $item )
                            <tr>
                                <td >{{ $item->reasonname }}</td>
                                <td class="text-center">{{ $resign->where('reason_id' , $item->reason_id)->count() }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

                <tfoot>
                    @if( count($numdepartment) > 0 )
                        <tr>
                            <td class="text-center" ><strong>รวม</strong> </td>
                            <td class="text-center"><strong>{{ $resign->count() }}</strong> </td>
                        </tr>
                    @endif
                </tfoot> 
            </table>
	</div>
@stop