@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>   
        <li>เพิ่มรายการประเมิน</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    เพิ่มรายการประเมิน ปีงบประมาณ: {{ $project->year_budget }}
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เพิ่มรายการประเมิน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'followup/edit' , 'method' => 'post' ]) !!} 
                    <input type="hidden" id="projectfollowupid" name="id" value="{{ $projectfollowup->project_followup_id }}" />
                        <div class="form-group">
                            <label>ชื่อโครงการติดตาม</label>
                            <input type="text" name="name" class="form-control" value="{{$projectfollowup->project_followup_name}}" required />
                        </div>
                        <div class="form-group">
                            <label>วันที่เริ่มโครงการ</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="startdate" readonly="" autocomplete="off" required="" value="{{$projectfollowup->projectstartdate}}">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>วันที่สิ้นสุดโครงการ</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="enddate" readonly="" autocomplete="off" required="" value="{{ $projectfollowup->projectenddate }}" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        
 
                        <div class="form-group">
                            <label>เลือกจังหวัด</label>
                            <select class="select2 width-100" name="province[]" id="province" multiple="" required  >
                                @if( count($province) > 0 )
                                    @foreach( $province as $item )  
                                        @php
                                                $val = $selectedprovince->where('map_code',$item->map_code)->first();
                                        @endphp
                                            @if (count($val) !=0 )
                                                    <option value="{{ $item->province_id }}" selected  >{{ $item->province_name }}</option>
                                                @else
                                                    <option value="{{ $item->province_id }}" >{{ $item->province_name }}</option>
                                            @endif
                                    @endforeach

                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>สำนักงานที่ติดตาม</label>
                            <select class="select2 width-100" id="section" name="section[]" multiple="" required  >
                            </select>
                        </div>

                        <div class="form-group">
                                <label>งบประมาณ</label>
                                <input type="text" name="budget" class="form-control" required value="{{$projectfollowup->project_budget}}" />
                            </div>
                        <div class="form-group">
                            <label>เพิ่มเติม</label>
                            <textarea name="description" class="form-control">{{ $projectfollowup->details }}</textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('pageScript')


<script type="text/javascript">

    $(document).ready(function() {
        $('.select2').select2();
    });


    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:false,
        orientation: "buttom",
    });

    function sectionList(){
        var values = $('#province').val();
        if (values == null){
            $("#section").empty();
            $("#section").html( "" );
            return;
        }

        $.ajax({
            type:"get",
            url : "{{ url('api/sectionlist') }}",
            dataType:"Json",
            data : {
                provincelist : values,
                id : $('#projectfollowupid').val(),
            },
            success : function(response){
                if( response.row > 0 ){
                    html = "";

                    for( var i=0;i<response.row;i++ ){
                
                        if( response.selectselected[i].check == 1 ){
                            html += "<option value='"+ response.section[i].section_id +"' selected>"+ response.section[i].section_name +"</option>";
                        }
                        else{
                            html += "<option value='"+ response.section[i].section_id +"' >"+ response.section[i].section_name +"</option>";
                        }
                    }
                    $("#section").html( html );
                }
            }
        })
    }

        $("#province").change(function(){
            sectionList();
        })

        $(document).ready(function(){
            var values = $('#province').val();
                if (values != null){
                    sectionList();
                }
        });



</script>
@stop