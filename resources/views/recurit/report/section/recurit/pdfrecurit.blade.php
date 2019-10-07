@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width: 918px;">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการจ้างงาน รายบุคคล</h1>
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
                    <th >ชื่อ นามสกุล</th>
                    <th >เลขประจำตัว</th>
                    <th >การศึกษา</th>
                    <th >อายุ</th>
                    <th >เลขที่จ้างงาน</th>
                    <th >ตำแหน่ง</th>
                    <th >เริ่มจ้าง</th>
                    <th >สิ้นสุดจ้าง</th>


                </tr>
            </thead>
            <tbody>
                @if( count($employ) > 0 )
                @foreach( $employ as $key => $item )
                    @php
                        $_register = $register->where('register_id', $item->register_id)->first();
                    @endphp
                    @if (count($_register) !=0 )
                        @php
                            $_education = $education->where('register_id',$_register->register_id)
                                                ->where('register_education_name','!=',"")
                                                ->last();
                        @endphp
                        <tr>
                            <td>{{ $_register->prefixname }}{{ $_register->name }} {{ $_register->lastname }}</td>
                            <td>{{ $_register->person_id }}</td>
                            <td>{{ $_education->register_education_name }}</td>
                            <td>{{ $_register->ageyear }}</td>
                            <td>{{$_register->department_id}}{{$_register->section_id}}{{$_register->position_id}}{{$_register->register_id}}-{{$_register->year_budget}}</td>
                            <td>{{ $_register->positionname }}</td>
                            <td>{{ $_register->starthiredateinput }}</td>
                            <td>{{ $_register->endhiredateinput }}</td>

                        </tr>  
                    @endif
                @endforeach
                @endif
            </tbody>
        </table>
	</div>
@stop