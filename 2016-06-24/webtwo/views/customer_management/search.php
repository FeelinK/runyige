<div class="shopcontbot_l">



<input type="hidden" value="<?php echo $hospital_name?>" class="one">


<?php if(!empty($arr)){?>
<?php foreach($arr as $k=>$v){?>
    <span value="<?php echo $v['main_account_id']?>"class="main_account_id"><?php echo $v['hospital_name']?></span>
<?php }?>
<?php }else{?>
暂无客户信息
<?php }?>


</div>