
    <div class="shopcontbot_r">

        <h4><b><img src="img/rubbsh_07.jpg" alt="" class="deleteinfo"></b>基本信息<i id="usershow"><img src="img/xiugai_07.jpg" alt="" class="up" id="up"></i></h4>
        <?php if(!empty($drr)){?>
        <ol>
            <input type="hidden" class="up_main" value="<?php echo $main_account_id?>">
            <li><span>客户名称</span><label><?php  echo $drr['hospital_name']?></label></li>
            <li><span>客户地址</span><label><?php echo $drr['address']?></label></li>
            <li><span>主账号</span><label><?php echo $drr['mobile']?></label></li>
            <li><span>联系人</span><label><?php echo $drr['doctor_name']?></label></li>
            <li><span>联系电话</span><label><?php echo $drr['doctor_phone']?></label></li>
            <li><span>服务开始日期</span><label><?php echo $drr['created_at']?></label></li>
            <li><span>备注</span><label><?php echo $drr['hospital_name']?></label></li>
        </ol>
        <ul>
            <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
            <li style="line-height:35px;font-size:17px;"><input type="radio">分成<span>医馆分成比例</span><b><?php echo $drr['profit_margine']?>%</b></li>
            <li style="margin-left: 125px;color:#ccc;">结算日<span>当月月底</span></li>

        </ul>
<?php }else{?>
        <h1>暂无基本信息</h1>
        <?php }?>
    </div>



