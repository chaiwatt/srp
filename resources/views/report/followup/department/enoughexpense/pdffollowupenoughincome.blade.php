@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการติดตามการจัดโครงการฝึกอบรมวิชาชีพ(รายได้เพียงพอ)ผู้พ้นโทษ</h1>
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
                                <th >จังหวัด</th>
                                <th class="text-center">จำนวนโครงการ</th>
                                <th class="text-center">จำนวนผู้มีอาชีพ</th>
                                <th class="text-center">จำนวนผู้มีรายได้เพียงพอ</th>
                                <th class="text-center">ร้อยละการมีรายได้เพียงพอ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if( count($occupationdatabysection) > 0 )
                            @php                               
                                $numproject=0;
                                $totalhasoccupationenoughincome=0;  
                                $hasoccupation=0;
                                $percent=0;
                            @endphp
                            @foreach( $occupationdatabysection as $key => $item )
                                    <tr>
                                            @php
                                            $totalhasoccupationenoughincome = $totalhasoccupationenoughincome + $item['totalhasoccupationenoughincome'];
                                            $hasoccupation = $hasoccupation + $item['hasoccupation'];
                                            $numproject = $numproject + $item['numproject'];
                                            $percent = $percent + $item['percent'];
                                        @endphp
                                        <td >{{ $item['province']  }}</td>
                                        <td class="text-center">{{ $item['numproject']  }}</td> 
                                        <td class="text-center">{{ $item['hasoccupation']   }}</td> 
                                        <td class="text-center">{{ $item['totalhasoccupationenoughincome']  }}</td>
                                        <td class="text-center">{{ $item['percent'] }}</td>    
                                    </tr>
                            @endforeach
                            @php
                            if($hasoccupation !=0 ){
                                $percent  = $totalhasoccupationenoughincome  / $hasoccupation;
                            }else{
                                $percent =0;
                            }
                                
                            @endphp
                            @endif
                        </tbody>
                        @if( count($occupationdatabysection) > 0 )
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="1">รวม</td>
                                    <td class="text-center">{{ $numproject }}</td>
                                    <td class="text-center">{{ $hasoccupation }}</td>
                                    <td class="text-center">{{ $totalhasoccupationenoughincome }}</td>
                                    <td class="text-center">{{ number_format( ($percent)*100 , 2)  }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>			
	</div>
@stop