<!-- 头部 -->
    <div class="header">
        药方进度<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
    </div>
    <!-- 表格 -->
    <div class="table" id="progress">
        <p >药方编号<span id="prescription_id"><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
    </div>
    <div class="liucheng">
        <span id="lc_go6"  style=" margin-top: 30px;">
            <span id="lc_go5"  style=" margin-top: 30px;">
                <span id="lc_go4"  style=" margin-top: 30px;">
                     <span id="lc_go3"  style=" margin-top: 30px;">
                          <span id="lc_go2"  style=" margin-top: 30px;">
                                  <div id="lc_lr">
                                       <div class="luru" id="lc0" style="margin-top:0px;">
                                           <h3><b>1</b></h3>
                                           <h2>录入</h2>
                                           <p></p>
                                           <p></p>
                                           <h1></h1>
                                           <h4></h4>
                                           <button id="btnshow1" type="button" value="开始"  style="margin-left:14px;">开始</button>
                                           <a style="display: none" id="lr_gai1">修改</a>
                                           <div id="lc_cs1" style="display: none"></div>
                                       </div>
                                  </div>
                                        <div class="shengfang" id="lc2" >
                                            <h3><b >2</b></h3>
                                            <h2>审方</h2>
                                            <p></p>
                                            <p></p>
                                            <h1></h1>
                                            <h4></h4>
                                            <button id="btnshow2" type="button" value="开始" style="display:none;">开始</button>
                                            <a style="display: none" id="lr_gai2">修改</a>
                                            <div id="lc_cs2"></div>
                                        </div>
                          </span>
                                      <div class="peiyao" id="lc3">
                                            <h3><b >3</b></h3>
                                            <h2>配药</h2>
                                            <p></p>
                                            <p></p>
                                            <h1></h1>
                                            <h4></h4>
                                            <div id="lc_cs3"></div>
                                      </div>
                     </span>
                                    <div class="hefang" id="lc4">
                                        <h3><b >4</b></h3>
                                        <h2>核方</h2>
                                        <p></p>
                                        <p></p>
                                        <h1></h1>
                                        <h4></h4>
                                        <div id="lc_cs4"></div>
                                    </div>
                </span>
                                    <div class="fucha" id="lc5">
                                        <h3><b >5</b></h3>
                                        <h2>复查</h2>
                                        <p></p>
                                        <p></p>
                                        <h1></h1>
                                        <h4></h4>
                                        <button id="btnshow5" type="button" value="开始" onclick="showdiv();" style="display:none">开始</button>
                                        <a style="display: none" id="lr_gai5">修改</a>
                                        <div id="lc_cs5"></div>

                                    </div>
            </span>
                                    <div class="jianzhi" id="lc6">
                                        <h3><b >6</b></h3>
                                        <h2>煎制</h2>
                                        <p></p>
                                        <p></p>
                                        <h1></h1>
                                        <h4></h4>
                                        <button id="btnshow6" type="button" value="开始" onclick="showdiv();" style="display:none">开始</button>
                                        <a style="display: none" id="lr_gai6">修改</a>
                                        <div id="lc_cs6"></div>
                                    </div>
        </span>
        <div class="peisong1" id="lc7">
            <h3><b >7</b></h3>
            <h2>配送</h2>
            <p></p>
            <p></p>
            <h1></h1>
            <h4></h4>
            <button id="btnshow7" type="button" value="开始" onclick="showdiv();" style="display:none">开始</button>
            <a style="display: none;" id="lr_gai7">修改</a>
            <div id="lc_cs7"></div>
        </div>
        <div class="over1" id="lc8">
            <h3><b >8</b></h3>
            <h2>完成</h2>
            <p></p>
            <p></p>
            <h1></h1>
            <h4></h4>
            <div id="lc_cs8"></div>
           </div>
          </div>
    </div>
<script language="javascript" src="js/jquery1-8-0.js"></script>
<script>
  $(document).ready(function(){
        var process = <?php echo $progress_list;?>;
        var process_sum = <?php echo $progress_sum?>;
        if(process_sum==0){
             $("#btnshow1").show();                  //显示第一个的开始按钮
              $("#lc_cs1").hide();                                    //隐藏第一个的背景
        }else if(process_sum==1){
             var str = "";
                 $("#lc_cs1").hide();                 //隐藏第一个的背景
                 $("#lc_cs2").hide();                 //隐藏第二个的背景
                 var start_time = process[0]["start_time"];
                 var end_time = process[0]["end_time"];
                 str += '<div style="margin-top:-3px;">';
                 str += '<h3><b>' + process[0]["progress_id"] + '</b></h3>';
                 str += '<h2>' + process[0]["progress_name"] + '</h2>';
                 str += '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                if(end_time==null){
                    str+= '<p><span>结束</span></p>';
                    str+= '<h1></h1>';
                    str+= '<h4></h4>';
                }else{
                    $("#btnshow2").show();              //显示第二个的开始按钮
                    str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                    str+= '<h1>' + process[0]["time_consuming"] + '</h1>';
                    str+= '<h4>' + process[0]["staff_name"] + '</h4>';
                }
                 str += '<a id="lr_gai1">修改</a>';
                 str += '</div>';
                     $("#lc0").html(str);

        }else if(process_sum==2){
            $("#lc_cs1").hide();                 //隐藏第一个的背景
            $("#lc_cs2").hide();                 //隐藏第二个的背景
            var str="";
            for(i in process){
                var start_time = process[i]["start_time"];
                var end_time = process[i]["end_time"];
                str+= '<div style="margin-top:36px;">';
                str+= '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                str+= '<h2>' + process[i]["progress_name"] + '</h2>';
                str+= '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                if(end_time==null){
                    str+= '<p><span>结束</span></p>';
                    str+= '<h1></h1>';
                    str+= '<h4></h4>';
                }else{
                    str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                    str+= '<h1>' + process[i]["time_consuming"] + '</h1>';
                    str+= '<h4>' + process[i]["staff_name"] + '</h4>';
                }
                str+= '<a id="lr_gai'+[i]+'">修改</a>';
                str+= '</div>';
            }
            $("#lc_go2").html(str);
        }else if(process_sum==3){
            $("#lc_cs1").hide();                 //隐藏第一个的背景
            $("#lc_cs2").hide();                 //隐藏第二个的背景
            $("#lc_cs3").hide();                 //隐藏第三个的背景
            var str="";
            for(i in process){
                var start_time = process[i]["start_time"];
                var end_time = process[i]["end_time"];
                str+= '<div style="margin-top:36px;" id="lc_id'+[i]+'">';
                str+= '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                str+= '<h2>' + process[i]["progress_name"] + '</h2>';
                str+= '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                if(end_time==null){
                    str+= '<p><span>结束</span></p>';
                    str+= '<h1></h1>';
                    str+= '<h4></h4>';
                }else{
                    str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                    str+= '<h1>' + process[i]["time_consuming"] + '</h1>';
                    str+= '<h4>' + process[i]["staff_name"] + '</h4>';
                }
                if(i==2) {
                    str+= '';
                }else{
                    str+= '<a id="lr_gai'+[i]+'">修改</a>';
                }
                str+= '</div>';
            }
            $("#lc_go3").html(str);
        }else if(process_sum==4){
                $("#lc_cs1").hide();                 //隐藏第一个的背景
                $("#lc_cs2").hide();                 //隐藏第二个的背景
                $("#lc_cs3").hide();                 //隐藏第三个的背景
                $("#lc_cs4").hide();                 //隐藏第四个的背景
                $("#lc_cs5").hide();                 //隐藏第五个的背景
            var progress_check_list = <?php echo $progress_check_list;?>;
                var str = "";
                var str1 = "";
                for (i in process) {
                    var start_time = process[i]["start_time"];
                    var end_time = process[i]["end_time"];
                    str += '<div style="margin-top:36px;" id="lc_id' + [i] + '">';
                    str += '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                    str += '<h2>' + process[i]["progress_name"] + '</h2>';
                    str += '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                    if(end_time==null){
                        str+= '<p><span>结束</span></p>';
                        str+= '<h1></h1>';
                        str+= '<h4></h4>';
                    }else{
                        str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                        str+= '<h1>' + process[i]["time_consuming"] + '</h1>';
                        str+= '<h4>' + process[i]["staff_name"] + '</h4>';
                        $("#btnshow5").show();               //显示第五个的开始按钮
                    }
                    if (i == 2 || i == 3) {
                        str += '';
                    } else {
                        str += '<a id="lr_gai' + [i] + '">修改</a>';
                    }
                    if (i == 3) {
                        str += '<p><img width="110" height="70" src="' + progress_check_list[0]['photo'] + '"/></p>';
                        str += '<p><img width="110" height="70" src="' + progress_check_list[1]['photo'] + '"/></p>';
                        str += '<p><img width="110" height="70" src="' + progress_check_list[2]['photo'] + '"/></p>';
                    }
                    str += '</div>';
                }
            $("#lc_go4").html(str);
        }else if(process_sum==5){
            $("#lc_cs1").hide();                 //隐藏第一个的背景
            $("#lc_cs2").hide();                 //隐藏第二个的背景
            $("#lc_cs3").hide();                 //隐藏第三个的背景
            $("#lc_cs4").hide();                 //隐藏第四个的背景
            $("#lc_cs5").hide();                 //隐藏第五个的背景
            $("#lc_cs6").hide();                 //隐藏第六个的背景
            var progress_check_list = <?php echo $progress_check_list;?>;
            var str = "";
            var str1 = "";
            for (i in process) {
                var start_time = process[i]["start_time"];
                var end_time = process[i]["end_time"];
                str += '<div style="margin-top:36px;" id="lc_id' + [i] + '">';
                str += '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                str += '<h2>' + process[i]["progress_name"] + '</h2>';
                str += '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                if(end_time==null){
                    str+= '<p><span>结束</span></p>';
                    str+= '<h1></h1>';
                    str+= '<h4></h4>';
                }else{
                    str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                    str+= '<h1>' + process[i]["time_consuming"] + '</h1>';
                    str+= '<h4>' + process[i]["staff_name"] + '</h4>';
                    $("#btnshow6").show();               //显示第六个的开始按钮
                }
                if (i == 2 || i == 3) {
                    str += '';
                } else {
                    str += '<a id="lr_gai' + [i] + '">修改</a>';
                }
                if (i == 3) {
                    str += '<p><img width="110" height="70" src="' + progress_check_list[0]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[1]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[2]['photo'] + '"/></p>';
                }
                str += '</div>';
            }
            $("#lc_go5").html(str);
        }else if(process_sum==6){
            $("#lc_cs1").hide();                 //隐藏第一个的背景
            $("#lc_cs2").hide();                 //隐藏第二个的背景
            $("#lc_cs3").hide();                 //隐藏第三个的背景
            $("#lc_cs4").hide();                 //隐藏第四个的背景
            $("#lc_cs5").hide();                 //隐藏第五个的背景
            $("#lc_cs6").hide();                 //隐藏第六个的背景
            $("#lc_cs7").hide();                 //隐藏第七个的背景
            var progress_check_list = <?php echo $progress_check_list;?>;
            var str = "";
            var str1 = "";
            for (i in process) {
                var start_time = process[i]["start_time"];
                var end_time = process[i]["end_time"];
                str += '<div style="margin-top:36px;" id="lc_id' + [i] + '">';
                str += '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                str += '<h2>' + process[i]["progress_name"] + '</h2>';
                str += '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                if(end_time==null){
                    str+= '<p><span>结束</span></p>';
                    str+= '<h1></h1>';
                    str+= '<h4></h4>';
                }else{
                    str+= '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                    str+= '<h1>' + process[i]["time_consuming"] + '</h1>';
                    str+= '<h4>' + process[i]["staff_name"] + '</h4>';
                    $("#btnshow7").show();               //显示第七个的开始按钮
                }
                if (i == 2 || i == 3) {
                    str += '';
                } else {
                    str += '<a id="lr_gai' + [i] + '">修改</a>';
                }
                if (i == 3) {
                    str += '<p><img width="110" height="70" src="' + progress_check_list[0]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[1]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[2]['photo'] + '"/></p>';
                }
                str += '</div>';
            }
            $("#lc_go6").html(str);
        }else if(process_sum==8){
            $("#lc_cs1").hide();                 //隐藏第一个的背景
            $("#lc_cs2").hide();                 //隐藏第二个的背景
            $("#lc_cs3").hide();                 //隐藏第三个的背景
            $("#lc_cs4").hide();                 //隐藏第四个的背景
            $("#lc_cs5").hide();                 //隐藏第五个的背景
            $("#lc_cs6").hide();                 //隐藏第六个的背景
            $("#lc_cs7").hide();                 //隐藏第七个的背景
            $("#lc_cs8").hide();                 //隐藏第八个的背景
            var progress_check_list = <?php echo $progress_check_list;?>;
            var str = "";
            var str1 = "";
            for (i in process) {
                var start_time = process[i]["start_time"];
                var end_time = process[i]["end_time"];
                str += '<div style="margin-top:36px;" id="lc_id' + [i] + '">';
                str += '<h3><b>' + process[i]["progress_id"] + '</b></h3>';
                str += '<h2>' + process[i]["progress_name"] + '</h2>';
                str += '<p><span>开始</span>' + start_time.substr(5, 11) + '</p>';
                str += '<p><span>结束</span>' + end_time.substr(5, 11) + '</p>';
                str += '<h1>' + process[i]["time_consuming"] + '</h1>';
                str += '<h4>' + process[i]["staff_name"] + '</h4>';
                str += '';
                if (i == 3) {
                    str += '<p><img width="110" height="70" src="' + progress_check_list[0]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[1]['photo'] + '"/></p>';
                    str += '<p><img width="110" height="70" src="' + progress_check_list[2]['photo'] + '"/></p>';
                }
                str += '</div>';
            }
            $(".liucheng").html(str);
        }
    })
</script>