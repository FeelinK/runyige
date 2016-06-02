<div class="list">
    <?php if(!empty($ww)){?>
    <input type="hidden" value="<?php echo $doctor_name?>" class="doctor_nametwo">

    <table cellpadding="0" cellspacing="0">
        <tr>
            <td>药方编号</td>
            <td>医师</td>
            <td>付数</td>
            <td>味数</td>
            <td>金额</td>
        </tr>
        <?php foreach($ww as $k=>$v){?>
            <tr>
                <td><?php echo $v['prescription_id']?></td>
                <td><?php echo $v['doctor_name']?></td>
                <td><?php echo $v['piece']?></td>
                <td><?php echo $v['kinds_per_piece']?></td>

                <td><?php echo $v['price']?></td>
            </tr>
        <?php }?>



    </table>
    <h1><
        <?php for($i=1;$i<=$quzheng;$i++){?>
            <a href="index.php?r=user/doctordatayue&page=<?php echo $i?>&hospital_name=<?php echo $hospital_name?>&doctor_name=<?php echo $doctor_name?>&datetime=<?php echo $datetime?>&firstletter=<?php echo $firstletter?>"><?php echo $i?></a>

        <?php }?>
        >
    </h1>
</div>
<?php }else{?>
    <h1><center>暂无数据</center></h1>
<?php }?>