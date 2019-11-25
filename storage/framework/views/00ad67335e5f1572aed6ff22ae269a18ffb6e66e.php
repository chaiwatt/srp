<?php $__env->startSection('blogcontent'); ?>

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('publicreport/report')); ?>">รายงาน</a></li>
        <li>รายการฝึกอบรมวิชาชีพ(มีอาชีพ)</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                    รายการฝึกอบรมวิชาชีพ(มีอาชีพ) ปีงบประมาณ : <?php echo e($setting->setting_year); ?> 
            </div>
        </div>
    </div>

    <div class="row padding-md pull-right" >
        <div class="col-sm-12">
            <?php echo Form::open([ 'method' => 'get' , 'id' => 'myform' ]); ?>

            <div class="form-inline no-margin">
                <div class="form-group">
                    <label >เลือกเดือน</label>
                    <select class="form-control" name="month" id="month" >
                        <option value ="0" <?php if( $month == 0): ?> selected <?php endif; ?>  >เลือก เดือน</option>
                        <option value ="1" <?php if( $month == 1): ?> selected <?php endif; ?>  >มกราคม</option>
                        <option value ="2" <?php if( $month == 2): ?> selected <?php endif; ?>  >กุมภาพันธ์</option>
                        <option value ="3" <?php if( $month == 3): ?> selected <?php endif; ?>  >มีนาคม</option>
                        <option value ="4" <?php if( $month == 4): ?> selected <?php endif; ?>  >เมษายน</option>
                        <option value ="5" <?php if( $month == 5): ?> selected <?php endif; ?>  >พฤษภาคม</option>
                        <option value ="6" <?php if( $month == 6): ?> selected <?php endif; ?>  >มิถุนายน</option>
                        <option value ="7" <?php if( $month == 7): ?> selected <?php endif; ?>  >กรกฏาคม</option>
                        <option value ="8" <?php if( $month == 8): ?> selected <?php endif; ?>  >สิงหาคม</option>
                        <option value ="9" <?php if( $month == 9): ?> selected <?php endif; ?>  >กันยายน</option>
                        <option value ="10" <?php if( $month == 10): ?> selected <?php endif; ?>  >ตุลาคม</option>
                        <option value ="11" <?php if( $month == 11): ?> selected <?php endif; ?>  >พฤศจิกายน</option>
                        <option value ="12" <?php if( $month == 12): ?> selected <?php endif; ?>  >ธันวาคม</option>
                    </select>
                </div>    
                <div class="form-group">
                    <label >เลือกไตรมาส</label>
                    <select class="form-control" name="quater" id="quater">
                        <option value ="0"  <?php if( $quater == 0): ?> selected <?php endif; ?>  >เลือก ไตรมาส</option>
                        <option value ="1"  <?php if( $quater == 1): ?> selected <?php endif; ?>  >ไตรมาส1</option>
                        <option value ="2"  <?php if( $quater == 2): ?> selected <?php endif; ?>  >ไตรมาส2</option>
                        <option value ="3"  <?php if( $quater == 3): ?> selected <?php endif; ?>  >ไตรมาส3</option>
                        <option value ="4"  <?php if( $quater == 4): ?> selected <?php endif; ?>  >ไตรมาส4</option>
                    </select>
                </div><!-- /form-group -->
                <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                     
                <?php if( $month != null || $quater != null ): ?>
                    
                    
                    
                <?php endif; ?>
                
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>    

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายงานอบรมวิชาชีพ
                    <?php if(count($quatername)>0): ?>
                        : <?php echo e($quatername->quater_name); ?>

                    <?php endif; ?> 
                    <?php if(count($monthname) > 0): ?>
                        : เดือน <?php echo e($monthname->month_name); ?>

                    <?php endif; ?> 
                </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>หน่วยงาน</th>
                                    <th class="text-center">จำนวนโครงการ</th>
                                    <th class="text-center">เป้าหมายเข้าร่วม</th>
                                    <th class="text-center">เข้าร่วมจริง</th>
                                    <th class="text-center">ร้อยละเข้าร่วม</th>
                                    <th class="text-center">งบประมาณใช้จริง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_target =0 ;
                                    $total_actualparticipate =0 ;
                                    $total_sum =0 ;
                                 ?>
                                    <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                             $_target = 0;
                                             $actualparticipate = 0;
                                             $sum  = 0;
                                             $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            
                                                foreach($_readinesssection as $sec){
                                                    $_target = $_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;
                                                    $total_target =  $total_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;
                                                    $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                    $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                    $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                    $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                }
                                            if($_target!=0){
                                                $percent = number_format( ($actualparticipate/ $_target) * 100 , 2);
                                            }else{
                                                $percent=0;
                                            }
                                         ?>
                                        <tr>
                                            <td ><?php echo e($item->departmentname); ?></td>
                                            <td class="text-center"><?php echo e($_readinesssection->count()); ?></td>
                                            <td class="text-center"><?php echo e($_target); ?></td>
                                            <td class="text-center"><?php echo e($actualparticipate); ?></td>
                                            <td class="text-center"><?php echo e($percent); ?></td> 
                                            <td class="text-center"><?php echo e($sum); ?></td> 
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                

                            </tbody>
                            
                            <?php 
                                $num = $readiness->count();
                                $_readinesssection = $readinesssection->count();    
                                if($total_target!=0){
                                    $percent = number_format(( $total_actualparticipate / $total_target) * 100 , 2);
                                }else{
                                    $percent=0;
                                }
                             ?>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="1">รวม</td>
                                        <td class="text-center"><?php echo e($_readinesssection); ?></td>
                                        <td class="text-center"><?php echo e($total_target); ?></td>
                                        <td class="text-center"><?php echo e($total_actualparticipate); ?></td>
                                        <td class="text-center"><?php echo e($percent); ?></td> 
                                        <td class="text-center"><?php echo e($total_sum); ?></td>
                                    </tr>
                                </tfoot>
                            

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1><u>แผนภาพร้อยละแสดง รายการฝึกอบรมวิชาชีพ</u> </h1>
    
    <div class="row">
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมคุมประพฤติ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept1" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมราชทัณฑ์</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept2" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">กรมพินิจ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <div id="donutdept3" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div id="chartContainerdept1" ></div>
        </div>
        <div class="col-sm-4">
            <div id="chartContainerdept2" ></div>
        </div>
        <div class="col-sm-4">
            <div id="chartContainerdept3" ></div>
        </div>
    </div> 
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
</script>

<script type="text/javascript">
    var chartdata_mapdept1 = [];
    var chartdata_mapdept2 = [];
    var chartdata_mapdept3 = [];
    var chartdata_province_dept1 = [];
    var chartdata_province_dept2 = [];
    var chartdata_province_dept3 = [];
    $(function(){
        $.ajax({
            type:"get",
            url:"<?php echo e(url('api/report/main/occupation')); ?>",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                if(data._row1dept > 0){

                    if(data._row1dept > 0){
                        for(var i=0;i<data._row1dept;i++){
                            chartdata_mapdept1.push({
                                'id': data.recuritdata_dept1[i].id,
                                'value': data.recuritdata_dept1[i].value,                               
                                'custom': data.recuritdata_dept1[i].custom,   
                            });

                            chartdata_province_dept1.push({
                                'label': data.recuritdata_dept1[i].province,
                                'value': data.recuritdata_dept1[i].value,                               
                            });
                        }
                    }
                    if(data._row2dept > 0){
                        for(var i=0;i<data._row2dept;i++){
                            chartdata_mapdept2.push({
                                'id': data.recuritdata_dept2[i].id,
                                'value': data.recuritdata_dept2[i].value,                               
                                'custom': data.recuritdata_dept2[i].custom,   
                            });

                            chartdata_province_dept2.push({
                                'label': data.recuritdata_dept2[i].province,
                                'value': data.recuritdata_dept2[i].value,                               
                            });
                        }
                    }                   
                    if(data._row3dept > 0){
                        for(var i=0;i<data._row3dept;i++){
                            chartdata_mapdept3.push({
                                'id': data.recuritdata_dept3[i].id,
                                'value': data.recuritdata_dept3[i].value,                               
                                'custom': data.recuritdata_dept3[i].custom,   
                            });

                            chartdata_province_dept3.push({
                                'label': data.recuritdata_dept3[i].province,
                                'value': data.recuritdata_dept3[i].value,                               
                            });
                        }
                    }

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept1",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept1
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept1) {
                                getallocatedept1(chartdata_mapdept1.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept2",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept2
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept2) {
                                getallocatedept2(chartdata_mapdept2.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });

                    FusionCharts.ready(function(){
                        var salesByState = new FusionCharts({
                            "type": "maps/thailand",
                            "renderAt": "chartContainerdept3",
                            "width": "100%",
                            "height": "600",
                            "dataFormat": "json",
                            "dataSource": {
                            "chart": {
                                    "animation": "0",
                                    "showbevel": "0",
                                    "usehovercolor": "1",
                                    "canvasbordercolor": "FFFFFF",
                                    "bordercolor": "FFFFFF",
                                    "showlegend": "1",
                                    "showshadow": "0",
                                    "legendposition": "BOTTOM",
                                    "legendborderalpha": "0",
                                    "legendbordercolor": "ffffff",
                                    "legendallowdrag": "0",
                                    "legendshadow": "0",
                                    "connectorcolor": "000000",
                                    "fillalpha": "80",
                                    "hovercolor": "CCCCCC",
                                    "showborder": 0
                                },
                                "colorrange": {
                                    "minvalue": "0",
                                    "startlabel": "Low",
                                    "endlabel": "High",
                                    "code": "e44a00",
                                    "gradient": "1",
                                    "color": [
                                        {
                                            "minvalue": "0",
                                            "maxvalue": "20",
                                            "code": "#fe0000",
                                            "displayValue": "20%"
                                        },
                                        {
                                            "minvalue": "21",
                                            "maxvalue": "40",
                                            "code": "#fd9111",
                                            "displayValue": "40%"
                                        },
                                        {
                                            "minvalue": "41",
                                            "maxvalue": "60",
                                            "code": "#b3d16c",
                                            "displayValue": "60%"
                                        },
                                        {
                                            "minvalue": "61",
                                            "maxvalue": "80",
                                            "code": "#9bac01",
                                            "displayValue": "80%"
                                        },
                                        {
                                            "minvalue": "81",
                                            "maxvalue": "100",
                                            "code": "#007853",
                                            "displayValue": "100%"
                                        },
                                        ],
                                    "maxvalue": 0
                                },
                            "data": chartdata_mapdept3
                            },
                            "events": {"entityClick": function(evt, chartdata_mapdept3) {
                                getallocatedept3(chartdata_mapdept3.id,data);
                                },
                            }
                        });
                    salesByState.render();
                    });


                    $(function(){
                        Morris.Donut({
                            element: 'donutdept1',
                            data: chartdata_province_dept1,
                            formatter: function (y) { return y+"%"},
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept2',
                            data: chartdata_province_dept2,
                            formatter: function (y) { return y+"%"},
                        });
                    });

                    $(function(){
                        Morris.Donut({
                            element: 'donutdept3',
                            data: chartdata_province_dept3,
                            formatter: function (y) { return y+"%"},
                        });
                    });
                }
            }
        })
    })
</script>

<script type="text/javascript">
    function getallocatedept1(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept1.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept1[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept1[i].message);
                return; 
            }
        }
    } 
    function getallocatedept2(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept2.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept2[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept2[i].message);
                return; 
            }
        }
    } 
    function getallocatedept3(mapcode,data){
       // console.log(mapcode);
       $count = data.recuritdata_dept3.length;
        for (i = 0; i < $count ; i++) {
            if (data.recuritdata_dept3[i].id == mapcode.toUpperCase()) {
               alert (data.recuritdata_dept3[i].message);
                return; 
            }
        }
    } 
</script>

<script type="text/javascript">
    $("#quater").change(function(){
        document.getElementById('month').value=0;
    })
</script>

<script type="text/javascript">
    $("#month").change(function(){
        document.getElementById('quater').value=0;
    })
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.publicreport', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>