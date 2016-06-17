<div class="ysxx">
    <header>客户管理<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()" style="float:right;"></span></header>
    <div class="zhuti">
        <h3>基本信息</h3>
        <?php if(!empty($arr)){?>
        <?php foreach($arr as $k=>$v){?>
        <div id="photo"><img src="<?php echo $v['doctor_img']?>"></div>
        <ul>

            <li><span>医师姓名</span><b><?php echo $v['doctor_name']?></b></li>
            <li><span>账号</span><b><?php echo $v['doctor_phone']?></b></li>
            <li><span>医馆名称</span><b><?php echo $v['hospital_name']?></b></li>
            <li><span>加入日期</span><b><?php echo substr($v['created_at'],0,10)?></b></li>
            <li><span>最后使用日期</span><b><?php echo substr($v['updated_at'],0,10)?></b></li>
        </ul>
    </div>
<?php }}else{?>

    暂无数据
    <?php }?>
