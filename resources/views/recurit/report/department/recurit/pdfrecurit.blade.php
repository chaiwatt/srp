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
                                $_contractor = $contractor->where('contractor_id', $item->register_id)->first();
                                 
                            @endphp
                            @if (count($_contractor) !=0 )
                                @php
                                    $_education = $education->where('contractor_id',$_contractor->contractor_id)
                                                        ->where('contractor_education_name','!=',"")
                                                        ->last();
                                    if(count($_education) !=0 ){
                                        $educate = $_education->contractor_education_name;
                                    }else{
                                        $educate ="";
                                    }                
                                @endphp
                                <tr>
                                    <td>{{ $_contractor->prefixname }}{{ $_contractor->name }} {{ $_contractor->lastname }}</td>
                                    <td>{{ $_contractor->person_id }}</td>
                                    <td>{{ $educate }}</td>
                                    <td>{{ $_contractor->ageyear }}</td>
                                    <td>{{$_contractor->department_id}}{{$_contractor->section_id}}{{$_contractor->position_id}}{{$_contractor->contractor_id}}-{{$_contractor->year_budget}}</td>
                                    <td>{{ $_contractor->positionname }}</td>
                                    <td>{{ $_contractor->starthiredateinputth }}</td>
                                    <td>{{ $_contractor->endhiredateinputth }}</td> 

                                </tr>  
                            @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
	</div>
@stop