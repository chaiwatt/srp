@extends('layout.pdf')

@section('pageCss')
<style>
   .newfontsize {font-size:18px} ;
</style>
@stop

@section('pdfcontent')
	<div class="container" style="max-width:960px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานรายการประเมิน </h1>
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
        		
        <table style="table-layout: fixed; width:100%; " >	
                <thead>
                        <tr>
                            <th style="font-size:18px ">หน่วยงาน</th>
                            <th style="font-size:18px ">การประเมิน</th>
                            <th style="font-size:18px ">ชื่อ-สกุล</th>
                            <th style="font-size:18px ">บัตรประชาชน</th> 
                            <th style="font-size:18px ">ผลการประเมิน</th>
                            <th style="font-size:18px ">การติดตาม</th>
                            <th style="font-size:18px ">ต้องการสนับสนุน</th>
                            <th style="font-size:18px ">สัมพันธ์ในครอบครัว</th>
                            <th style="font-size:18px ">การมีรายได้</th>
                            <th style="font-size:18px ">การมีอาชีพ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($assessee) > 0 )
                        @foreach( $assessee as $item )
                            <tr>
                                <td style="width:15%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->registersectionname }}</td>
                                <td style="width:15%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->projectassessmentname }}</td>
                                <td style="width:15%; word-wrap:break-word; font-size:18px ; padding-right:10px "> {{ $item->registername }}</td>
                                <td style="width:10%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->registerpersonid }}</td>
                                <td style="width:10%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->scorename }}</td>
                                <td style="width:10%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->followerstatusname }}</td>
                                <td style="width:15%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->needsupportname }} <small class="text-danger"> {{ $item->needsupport_detail }}</small></td>
                                <td style="width:15%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->familyrelationname }} <small class="text-danger"> {{ $item->familyrelation_detail }}</td>
                                <td style="width:10%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->enoughincomename}}</td>
                                <td style="width:10%; word-wrap:break-word; font-size:18px ; padding-right:10px ">{{ $item->occupationname}} <small class="text-danger"> {{ $item->occupation_detail }}</td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
	</div>
@stop