<!-- 订单详情 -->

    <!-- 头部 -->
    <div class="header">
        订单详细<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
    </div>
    <!-- 表格 -->
    <div class="table">
        <p>药方编号<span><?php echo $arr['prescription_id']?></span>
            医馆<span><?php echo $arr['hospital_name']?></span>
            医师<span><?php echo $arr['doctor_name']?></span>
            付数<span><?php echo $arr['piece']?></span>
            味数<span><?php echo $arr['kinds_per_piece']?></span>
            原药/代煎<span><?php if($arr['production_type']=="1"){?>
            原药
            <?php }else if($arr['production_type']=="2"){?>
                代煎
                <?php }?>
            </span></p>
    </div>
    <div class="foot">
        <div class="foot-l">
            <ul>
                <?php if(!empty($arr['drr'])){?>
                <?php foreach($arr['drr'] as $k=>$v){?>
                <li>

                    <img src="<?php echo $v['medicine_photo']?>" alt="">
                    <p id="zhongl"><?php echo $v['weight']?>g</p>
                    <p id="yaoming"><?php echo $v['medicine_name']?></p>

                </li>
                <?php }}else{?>
                暂无药材信息
                <?php  }?>


            </ul>
        </div>
        <div class="foot-r">
            <div class="foot-r-t">
                <h1>备注</h1>
                <p><?php echo $arr['notes']?>

                </p>
            </div>
            <div class="foot-r-z">
                <h2>药方照片</h2>
                <ul>
                    <?php if(!empty($arr['brr'])){?>
                    <?php foreach($arr['brr'] as $k=>$v){?>
                    <li><img src="<?php echo $v['photo_img']?>" style="width:88px;height: 55px;" ></li>
                    <?php }}else{?>
                  暂无药方数据
                    <?php }?>
                </ul>
            </div>
            <div class="foot-r-f">
                <h1>配送信息</h1>
                <?php if(!empty($arr['crr'])){?>
                <?php foreach($arr['crr'] as $k=>$v){?>
                <p><img src="img/ddxx-1_03.gif" alt=""><span><?php echo $v['patient_name']?></span></p>
                <p><img src="img/ddxx-2_03.gif" alt=""><span><?php echo $v['mobile']?></span></p>
                <p><img src="img/ddxx-3_03.gif" alt=""><span><?php echo $v['address']?></span></p>
                <?php }}else{?>
                暂无配送信息
                <?php }?>
            </div>
        </div>
    </div>
