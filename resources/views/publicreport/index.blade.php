@extends('layout.publicreport')
@section('blogcontent')

<div >

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
               <strong>รายงานทั่วไป ปีงบประมาณ : {{$setting->setting_year}} </strong> 
            </div>
        </div>
        <div class="col-sm-12">
            <ul style="margin-left:50px">
                <li>
                <h3><a href="{{ url('publicreport/allocation') }}">รายงานรายการจ้างงาน</a></h3>
                </li>
                <li>
                    <h3><a href="{{ url('publicreport/expense') }}">รายงานค่าใช้จ่ายจ้างงาน</a></h3>
                </li>
                <li>
                    <h3><a href="{{ url('publicreport/readiness') }}">รายงานอบรมเตรียมความพร้อม</a></h3>
                </li>
                <li>
                    <h3><a href="{{ url('publicreport/occupation') }}">รายงานอบรมวิชาชีพ</a></h3>
                </li>
                <li>
                    <h3><a href="{{ url('publicreport/hasincome') }}">รายงานติดตามผลอบรมวิชาชีพ(มีอาชีพ)</a></h3>
                </li>
                <li>
                    <h3><a href="{{ url('publicreport/enoughincome') }}">รายงานติดตามผลอบรมวิชาชีพ(รายได้เพียงพอ)</a></h3>
                </li>
            </ul>       
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
@stop