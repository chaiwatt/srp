@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('assesment/section') }}">รายการประเมิน</a></li>
        <li>เพิ่มการประเมินบุคคล</li>    
    </ul>
{!! Form::open([ 'url' => 'assesment/section/save' , 'method' => 'post' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มการประเมินบุคคล :  {{ $project->year_budget }} 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                <a href="{{ url('assesment/section/editassessment/'.$assesment->project_assesment_id) }}" class="btn btn-success"><i class="fa fa-pencil"></i> แก้ไขรายการ</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน: {{$assesment->assesment_name}} </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        
                        <input type="hidden" name="assesment_id" value="{{$assesment->project_assesment_id}}" />
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
                            <label class="col-lg-2 control-label">ผู้รับการประเมิน</label>
                            <select class="form-control" name="register" required>
                                    @if( count($register) > 0 )
                                    @foreach( $register as $item )
                                        <option value="{{ $item->register_id }}">{{ $item->registerprefixname }}{{ $item->registername }} {{ $item->registerlastname }}</option>
                                    @endforeach
                                    @endif
                            </select> 

                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th >รายการประเมิน</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr> 
                                            <td>ผลการประเมิน</td>
                                            <td>
                                                <select class="form-control" name="score" required>
                                                    @if( count($score) > 0 )
                                                    
                                                    @foreach( $score as $item )
                                                        <option value="{{ $item->score_id }}">{{ $item->score_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>

                                        <tr> 
                                            <td>การติดตาม</td>
                                            <td>
                                                <select class="form-control" name="followerstatus" required>
                                                    @if( count($followerstatus) > 0 )
                                                    @foreach( $followerstatus as $item )
                                                        <option value="{{ $item->follower_status_id }}">{{ $item->follower_status_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>ต้องการสนับสนุน</td>
                                            <td>
                                                <select class="form-control" name="needsupport" required>
                                                    @if( count($needsupport) > 0 )
                                                    @foreach( $needsupport as $item )
                                                        <option value="{{ $item->needsupport_id }}">{{ $item->needsupport_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>ความสัมพันธ์ในครอบครัว</td>
                                            <td>
                                                <select class="form-control" name="familyrelation" required>
                                                        @if( count($familyrelation) > 0 )
                                                        @foreach( $familyrelation as $item )
                                                            <option value="{{ $item->familyrelation_id }}">{{ $item->familyrelation_name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>การมีรายได้</td>
                                            <td>
                                                <select class="form-control" name="enoughincome" required>
                                                        @if( count($enoughincome) > 0 )
                                                        @foreach( $enoughincome as $item )
                                                            <option value="{{ $item->enoughincome_id }}">{{ $item->enoughincome_name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>                                              
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>การมีอาชีพ</td>
                                            <td>
                                                <select class="form-control" name="occupation" required>
                                                        @if( count($occupation) > 0 )
                                                        @foreach( $occupation as $item )
                                                            <option value="{{ $item->occupation_id }}">{{ $item->occupation_name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>                                 
                                            </td>
                                        </tr>
                                    {{-- @endforeach
                                    @endif --}}
                                </tbody>
                            </table>

                            <div class="form-group">
                                <label>ข้อคิดเห็นอื่นๆ</label>
                                <textarea class="form-control" name="detail"></textarea>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@stop

@section('pageScript')
<script type="text/javascript">

</script>
@stop