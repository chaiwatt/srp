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

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขข้อมูลการประเมิน :  {{$register->name}} {{$register->lastname}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> แก้ไขข้อมูล </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        {!! Form::open([ 'url' => 'assesment/section/asseseesave' , 'method' => 'post' ]) !!} 
                            <input type="hidden" name="assesment_id" value="{{$assessee->personal_assessment_id}}" /> 
                            <input type="hidden" name="register_id" value="{{$assessee->register_id}}" /> 
                            <input type="hidden" name="project_assessment_id" value="{{$assessee->project_assesment_id}}" /> 
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
                                                        <option value="{{ $item->score_id }}" @if ($item->score_id == $assessee->score_id) selected @endif  >{{ $item->score_name }}</option>
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
                                                        <option value="{{ $item->follower_status_id }}" @if ($item->follower_status_id == $assessee->follower_status_id) selected @endif    >{{ $item->follower_status_name }}</option>
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
                                                        <option value="{{ $item->needsupport_id }}"  @if ($item->needsupport_id == $assessee->needsupport_id) selected @endif >{{ $item->needsupport_name }}</option>
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
                                                            <option value="{{ $item->familyrelation_id }}"  @if ($item->familyrelation_id == $assessee->familyrelation_id) selected @endif >{{ $item->familyrelation_name }}</option>
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
                                                            <option value="{{ $item->enoughincome_id }}" @if ($item->enoughincome_id == $assessee->enoughincome_id) selected @endif  >{{ $item->enoughincome_name }}</option>
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
                                                            <option value="{{ $item->occupation_id }}"  @if ($item->occupation_id == $assessee->occupation_id) selected @endif >{{ $item->occupation_name }}</option>
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
                                <textarea class="form-control" name="detail">{{$assessee->othernote}}</textarea>
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
</div>


@stop

@section('pageScript')
<script type="text/javascript">

</script>
@stop