<div class="personcont_r">
    <h4><b><img src="img/rubbsh_07.jpg" alt="" class="delstaff"></b>基本信息<i  id="personshow"><img src="img/xiugai_07.jpg" alt=""></i></h4>
    <input type="hidden" value="<?php echo $brr['staff_id']?>" class="staffid">
    <ul>
        <li>员工姓名</li>
        <li>员工id</li>
        <li>员工注册账号</li>
        <li>密码</li>
        <li>职位</li>
        <li>联系电话</li>
        <li>任职日期</li>

    </ul>
    <p><img src="<?php echo $brr['photo']?>" alt=""></p>
    <ol>
        <li><?php echo $brr['staff_name']?></li>
        <li><?php echo $brr['staff_id']?></li>
        <li><?php echo $brr['mobile']?></li>
        <li>******</li>
        <li><?php echo $brr['role_name']?></li>
        <li><?php echo $brr['mobile']?></li>
        <li><?php echo substr($brr['created_at'],0,10)?></li>

    </ol>
</div>