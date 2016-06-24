


<div class="usereditor">

        <h3>客户管理--编辑<b id="closeuser"><img src="img/close.jpg" alt=""></b></h3>
        <div class="usereditorcont">
            <h2>基本信息</h2>
        <input type="hidden" class="up_main" value="<?php echo $main_account_id?>">
<ol>
        <li><span>客户名称</span><label><input type="text" value="<?php  echo $drr['hospital_name']?>" class="h_name"></label></li>
        <li><span>客户地址</span><label><input type="text" value="<?php echo $drr['address']?>"  class="h_address"></label></li>
        <li><span>主账号</span><label><input type="text" value="<?php echo $drr['mobile']?>" class="mobile"></label></li>
        <li><span>联系人</span><label><input type="text" value="<?php echo $drr['doctor_name']?>" class="doctor_name"></label></li>
        <li><span>联系电话</span><label><input type="text" value="<?php echo $drr['doctor_phone']?>"  class="doctor_phone"></label></li>
    </ol>
    <ul>
        <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
        <li style="line-height:35px;font-size:17px;"><input type="radio">分成<span>医馆分成比例</span><b><input type="text"  class="profit_margine" style="width:40px" value="<?php echo $drr['profit_margine']?>">%</b></li>
        <li style="margin-left: 125px;color:#ccc;">结算日<select name="" id="" class="clearing_type">
                <?php foreach($clearday as $k=>$v){?>
                    <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select></li>


    </ul>
    <button id="baocun" class="upinfo">保存</button>
</div>

    <script src="js/jquery1.8.js"></script>
    <script src="js/shouye.js"></script>
    <script src="js/jquery1-8-0.js"></script>