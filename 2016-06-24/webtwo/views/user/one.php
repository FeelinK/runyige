<div class="list">
    <?php if(!empty($drr)){?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td>药方编号</td>
            <td>医师</td>
            <td>付数</td>
            <td>味数</td>
            <td>备注</td>
            <td>原药/代煎</td>
            <td>状态</td>
            <td>金额</td>
            <td>医师</td>
        </tr>
        <?php foreach($drr as $k=>$v){?>
            <tr>
                <td><?php echo $v['prescription_id']?></td>
                <td><?php echo $v['doctor_name']?></td>
                <td><?php echo $v['piece']?></td>
                <td><?php echo $v['kinds_per_piece']?></td>
                <td><?php echo $v['notes']?></td>
                <td><?php if($v['production_type']==1){?>
                        原药
                    <?php }elseif($v['production_type']==2){?>
                        代煎
                    <?php }?>
                </td>
                <td>
                    <?php if($v['prescription_status']==1){?>
                        录入
                    <?php }elseif($v['prescription_status']==2){?>
                        审方
                    <?php }elseif($v['prescription_status']==3){?>
                        配药
                    <?php }elseif($v['prescription_status']==4){?>
                        核方
                    <?php }elseif($v['prescription_status']==5){?>
                        复查
                    <?php }elseif($v['prescription_status']==6){?>
                        煎制
                    <?php }elseif($v['prescription_status']==7){?>
                        配送
                    <?php }?>

                </td>
                <td><?php echo $v['price']?></td>
                <td><a href="" id="btnshow" onclick="showdiv();">医师数据</a></td>
            </tr>
        <?php }?>
    </table>
    <h1><
        <?php for($i=1;$i<=$quzheng;$i++){?>
            <a href="index.php?r=user/index&page=<?php echo $i?>&hospital_name=<?php echo $hospital_name?>&patient_name=<?php echo $patient_name?>&datetime=<?php echo $datetime?>&firstletter=<?php echo $firstletter?>"><?php echo $i?></a>
        <?php }?>>
    </h1>

</div>
        <?php }else{?>
<h1><center>暂无数据</center></h1>
<?php }?>