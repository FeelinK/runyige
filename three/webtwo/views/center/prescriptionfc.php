<link rel="stylesheet" href="lc/css/shouye.css">
<!-- 复查 -->
<div class="fc">
    <!-- 头部 -->
    <div class="header">
        复查
							<span id="btnclose" >
							<img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()">
							</span>
    </div>
    <!-- 表格 -->
    <div class="table">
        <p >药方编号<span><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
    </div>
    <div class="fccont">
        <div class="fcleft">
            <div class="fclefttop"><img src="<?php echo $progress_check_list[0]['photo']?>" width="650" height="350"/></div>
            <div class="fcleftbot">
                <?php foreach($progress_check_list as $k=>$v){?>
                <div class="fcleftbotleft" value="<?php echo $v['taken_type']?>"><img src="<?php echo $v['photo']?>" width="170" height="110"/></div>
                <?}?>
            </div>
        </div>
        <div class="fcright" style="overflow:auto;">
            <table>
                <?php foreach($prescription_detail_list as $k=>$v){?>
                <tr>
                    <td id="yname"><?php echo $v['medicine_name']?></td>
                    <td><?php echo $v['weight']?>克</td>
                    <td>
                        <input type="checkbox">
                    </td>
                </tr>
                <?php }?>
            </table>
        </div>
    </div>
    <input type="button" value="发现差错 重新配药" id="again">
    <input type="button" value="完成" id="fcover">
    <div id="psdbg-fc">
    </div>
    <div id="psdshow-fc">
        <div class="psd" id="">
            <p>个人密码<input type="text" name="password_hash" id="password_hash_fc"></p>
            <input id="psdover-fc" type="button" value="完成"/>
        </div>
    </div>
    <div id="psdbg-again" style="display: none;position: absolute;top: 0%;left: 0%;width: 100%;height: 100%;background-color: black;z-index: 1;-moz-opacity: 0.4;opacity: .40;filter: alpha(opacity=40);"></div>
    <div id="psdover-again" style=" display: none;position: absolute;margin:0 auto;top: 300px;left: 450px;width: 400px;height: 200px;padding: 8px;background-color: white;z-index:5;">
        <div class="psd" id="">
            <p>个人密码<input type="text" id="password_hash_again"></p>
            <input id="re_dispensing" type="button" value="完成" style=" width:100px;height:40px;line-height: 40px;text-align:center;background-color: #f4ad59;color:white;font-size: 14px;outline: none;border:none;border-radius: 4px;margin-left:150px;margin-top: 20px;"/>
        </div>
    </div>
</div>