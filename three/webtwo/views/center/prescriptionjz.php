<!-- 头部 -->
<div class="header">
    煎制<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
</div>
<!-- 表格 -->
<div class="table">
    <p >药方编号<span><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
</div>
<div class="jzcont">
    <div class="jznum1">
        <h1>泡制</h1>
        <h2>药房编号确认<span><?php echo $prescription_list['prescription_id']?></span><input type="checkbox" id="p_prescription_id_check" style="float:right;margin-right:15px;"></h2>
        <h3>泡制时间<input type="text"  style="margin-left:99px;" id="p_soaking_time">分钟</h3>
    </div>
    <div class="jznum2">
        <h1>煎制前</h1>
        <h2>药房编号确认<span><?php echo $prescription_list['prescription_id']?></span><input type="checkbox" id="b_prescription_id_check" style="float:right; margin-right:15px;"></h2>
        <h3>付数确认<b><?php echo $prescription_list['piece']?></b><input type="checkbox" style="float:right;margin-right:15px;" id="b_piece_check"></h3>
        <h3>味数确认<b><?php echo $prescription_list['kinds_per_piece']?></b><input type="checkbox" style="float:right;margin-right:15px;" id="b_kinds_check"></h3>
        <h4>药物外观确认<input type="checkbox" style="float:right;margin-right:15px;" id="b_appearance_check"></h4>
        <h5>用水确认<input type="text" id="b_water_yield">升</h5>
        <h5>压力确认<input type="text" id="b_pressure">帕</h5>
        <h5>煎制时间确认<input type="text" style="margin-left:93px;" id="b_boiling_time">分钟</h5>
        <h5>煎药机&nbsp;&nbsp;&nbsp;<input type="text" id="decocting_machine">号</h5>
        <h6>先煎<input type="checkbox" id="b_pre_boiling"><i>后下</i><input type="checkbox" id="b_post_boiling"></h6>
        <h5>下药时间<input type="text" id="b_boiling_start_time"></h5>
    </div>
    <div class="jznum3">
        <h1>煎制后</h1>
        <h2>药房编号确认<span><?php echo $prescription_list['prescription_id']?></span><input type="checkbox" style="float:right;margin-right:15px;" id="a_prescription_id_check"></h2>
        <h2>汤剂外观确认<input type="checkbox" style="float:right;margin-right:15px;" id="a_soup_appearance_check"></h2>
        <h3>量确认<input type="text" id="a_quantity_check">升/毫升</h3>
        <h5>出药时间<input type="text" id="a_boiling_end_time"></h5>
    </div>
</div>
<div class="jzfoot"><button id="jzover" type="button" value="X" >开始</button></div>
<div id="psdbg-jz">
</div>
<div id="psdshow-jz">
    <div class="psd" id="">
        <p>个人密码<input type="text" name="password_hash" id="password_hash"></p>
        <input id="psdover-jz" type="button" value="完成"/>
    </div>
</div>