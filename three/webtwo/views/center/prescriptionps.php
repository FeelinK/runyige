<!-- 头部 -->
<div class="header" style=" width:1205px;height:78px;text-align: center;line-height: 78px;font-size: 24px;font-weight: weight;border-bottom: 1px solid #e3e4e4;margin-left:2.3%;">
    配送<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()" style=" float: right;"></span>
</div>
<!-- 表格 -->
<div class="table" style=" width:1106px;height:62px;margin:0 auto;margin-left: 5%;background-color: #e3e4e4;border-radius: 5px;margin-top: 21px;">
    <p style=" font-size: 18px;color:#bcbcbc;line-height: 62px;margin-left: 35px;">药方编号<span id="prescription_id_sf" style="margin-left: 17px;margin-right: 35px;color:#7b7b7b;"><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
</div>
<div class="pscont" style="width:1106px;height:400px;margin-left:5%;margin-top: 20px;">
    <div class="psleft" style=" width:675px;height:500px;float:left;border:1px solid #ccc;">
        <div class="pslefttop" style="width:650px;height: 360px;background-color: #9c9c9c;margin:10px auto;"><img src="<?php echo $prescriptiond_photo_list['photo_img']?>" width="650" height="350"></div>
        <div class="psleftbot" style="width:650px;height:112px;margin-top: 10px;margin-left:10px;">
            <div class="psleftbotleft" style="width:170px;height:110px;background-color: #9c9c9c;float:left;margin-right: 10px;"><img src="<?php echo $prescriptiond_photo_list['photo_img']?>" width="170" height="110"></div>
        </div>
    </div>
    <div class="psright" style="width:403px;height:300px;border:1px solid #ccc;float:right;">
        <h3 style=" margin-left:5px;height:40px;line-height: 40px;margin-top: 20px;">收件人姓名：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient_lists['addressee_name']?></h3>
        <h3 style=" margin-left:5px;height:40px;line-height: 40px;margin-top: 20px;">电话：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient_lists['mobile']?></h3>
        <h3 style=" margin-left:5px;height:40px;line-height: 40px;margin-top: 20px;">地址：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient_lists['address']?></h3>
        <h3 style=" margin-left:5px;height:40px;line-height: 40px;margin-top: 20px;">物流单号：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style=" width:130px;height:30px;margin-left:20px;" type="text" id="odd_numbers"></h3>
    </div>
</div>
<div class="psfoot"><button id="psover2" type="button" value="X" style=" width:100px;height:40px;line-height: 40px;text-align:center;background-color: #f4ad59;color:white;font-size: 14px;outline: none;border:none;border-radius: 4px;margin-left:50%;margin-top: 40px;">完成</button></div>
</div>
<div id="psdbg-ps2" style=" display: none;position: absolute;top: 0%;left: 0%;width: 100%;height: 100%;background-color: black;z-index:2;-moz-opacity: 0.4;opacity: .40;filter: alpha(opacity=40);">
</div>
<div id="psdshow-ps2" style="display: none;position: absolute;margin:0 auto;top: 300px;left: 450px;width: 400px;height: 200px;padding: 8px;background-color: white;z-index: 2;">
    <div class="psd" id="" style="width:400px;height:200px;">
        <p>个人密码<input type="text" name="password_hash" id="password_hash_qi"></p>
        <input id="psdover-ps2" type="button" value="完成" style=" width:100px;height:40px;line-height: 40px;text-align:center;background-color: #f4ad59;color:white;font-size: 14px;outline: none;border:none;border-radius: 4px;margin-left:150px;margin-top: 20px;"/>
    </div>
</div>
