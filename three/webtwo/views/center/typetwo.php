<div class="f-left">
    <!--<h3 style="color:black">全部<span style="background:#779800"><?php echo $zong?></span></h3>-->
    <?php if(empty($vrr)){?>

    <?php }else{?>
        <?php foreach($vrr as $k=>$v){?>
            <h3 class="patient_type_name" value="<?php echo $v['patient_type_name']?>"><?php echo $v['patient_type_name']?><span><?php echo $v['count(patient_type_name)']?></span></h3>
        <?php }}?>
</div>
<?php if(!empty($models)){?>
    <div class="f-right">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>药方编号</td>
                <td>医馆</td>
                <td>医师</td>
                <td>付数</td>
                <td>味数</td>
                <td>备注</td>
                <td>原药/代煎</td>
                <td>状态</td>
                <td>详细</td>
                <td>记录</td>

            </tr>

            <?php foreach($models as $k=>$v){?>
                <tr>
                    <td><?php echo $v['prescription_id']?></td>
                    <td><?php echo $v['hospital_name']?></td>
                    <td><?php echo $v['doctor_name']?></td>
                    <td><?php echo $v['piece']?></td>
                    <td><?php echo $v['kinds_per_piece']?></td>
                    <td><?php

                        echo substr($v['notes'],0,24)."..."?>

                    </td>
                    <td><?php if($v['production_type']=="1"){?>
                            原药
                        <?php }else if($v['production_type']=="2"){?>

                            代煎
                        <?php }?>
                    </td>
                    <td>
                        <?php  if($v['prescription_status']=="1"){?>
                            录入
                        <?php }else if($v['prescription_status']=="2"){?>
                            审方

                        <?php }else if($v['prescription_status']=="3"){?>
                            配药
                        <?php }else if($v['prescription_status']=="4"){?>
                            核方

                        <?php }else if($v['prescription_status']=="5"){?>
                            复查
                        <?php }else if($v['prescription_status']=="6"){?>
                            煎制

                        <?php }else if($v['prescription_status']=="7"){?>
                            配送
                        <?php }?>
                    </td>
                    <td><a href="javascript:void(0);" id="xxshow" onclick="showdiv();" class="prescription_id" value="<?php echo $v['prescription_id']?>">详细</a></td>
                    <td><span  id="btnshow" onclick="showdiv();"  value="<?php echo $v['prescription_id']?>" class="status">流程</span></td>
                </tr>

            <?php }?>

        </table>
        <h1>
            <
            <?php
            for($i=1;$i<=$end;$i++){
                ?>
                <a href="index.php?r=center/index&page=<?php echo $i?>&already=<?php echo $already?>&patient_type_name=<?php echo $patient_type_name?>&hospital_name=<?php echo $hospital_name?>&search=<?php echo $search?>">&nbsp;<?php echo $i?>&nbsp;</a>
            <?php }?>
            >
        </h1>    </div>
    <!--yii框架内置分页-->
<?php }else{?>
    <h1>暂无数据</h1>
<?php }?>

