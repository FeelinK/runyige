<div class="shopcontbot_l">
    <?php if(!empty($arr)){?>
    <ul>
        <?php foreach($arr as $k=>$v){?>
            <li class="supplier_id" value="<?php echo $v['supplier_id']?>"><?php echo $v['supplier_name']?></li>
        <?php }?>
    </ul>
    <?php }else{?>
    暂无信息
    <?php }?>
</div>