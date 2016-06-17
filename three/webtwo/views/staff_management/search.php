<?php if(!empty($arr)){?>
<ul>
    <?php foreach($arr as $k=>$v){?>
        <li value="<?php echo $v['staff_id']?>" class="staff_id"><?php echo $v['staff_name']?></li>
    <?php }?>
</ul>
<?php }else{?>
暂无员工

<?php }?>
