@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width:960px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานรายการประเมิน {{$assessment->assesment_name}} </h1>
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
                    <th style="width:17%">ชื่อ-สกุล</th>
                    <th >เลขที่บัตรประชาชน</th>
                    <th >ผลการประเมิน</th> 
                    <th >การติดตาม</th>
                    <th >ต้องการสนับสนุน</th>
                    <th >ความสัมพันธ์ในครอบครัว</th>
                    <th >การมีรายได้</th>
                    <th >การมีอาชีพ</th>
                </tr>
            </thead>
            <tbody>
                @if( count($assessee) > 0 )
                @foreach( $assessee as $item )
                    <tr>
                        <td>{{ $item->registername }}</td>
                        <td >{{ $item->registerpersonid }}</td>
                        <td >{{ $item->scorename }}</td>
                        <td >{{ $item->followerstatusname }}</td>
                        <td >{{ $item->needsupportname }} <small class="text-danger"> {{ $item->needsupport_detail }}</small></td>
                        <td >{{ $item->familyrelationname }} <small class="text-danger"> {{ $item->familyrelation_detail }}</td>
                        <td >{{ $item->enoughincomename}}</td>
                        <td >{{ $item->occupationname}} <small class="text-danger"> {{ $item->occupation_detail }}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
	</div>
@stop