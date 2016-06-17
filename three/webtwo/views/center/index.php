<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="lc/css/shouye.css">
    <link rel="stylesheet" type="text/css" href="lc/css/jquery.editable-select.min.css" />
</head>
<body>
<div class="container">
    <header class="header">
        <div class="logo">
            <img src="img/订单_02.png" alt="">
        </div>
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;中央药房</p>
        <ul>
            <li><a href="index.php?r=center/index" target="-_blank">订单</a></li>
            <li><a href="index.php?r=user/index" target="-_blank">客户</a></li>
            <li><a href="index.php?r=setup/index" target="-_blank">设置</a></li>
        </ul>
    </header>
    <div class="dingdan">
        <div class="content">
            <div class="s-top">
                <a href="">今日(<?php echo $nowtime?>)</a>
                <?php if(!empty($crr)){?>
                    <a href="">药方数<span><?php echo $crr['prescription_number']?></span>付</a>
                    <a href="">原药<span><?php echo $crr['naked_medicine_number']?></span>付</a>
                    <a href="">代煎<span><?php echo $crr['decocted_medicine_number']?></span>付</a>
                    <a href="">药材种类<span><?php echo $crr['used_medicine_kinds']?></span>付</a>
                    <a href="">使用药材量<span><?php echo $crr['used_medicine_quantity']?></span>公斤</a>
                <?php }else{?>
                    暂无数据
                <?php }?>
            </div>
            <div class="search">
                <b><img src="img/订单_06.gif" alt=""></b><input type="text" placeholder="医馆名称 、医师姓名、患者姓名、药方编号"  alt="" id="text">
                <input type="button" value="搜索" id="search" class="search" style="width: 120px;">
            </div>
            <div class="footer">
                <div class="f-top">
                    <!---- <a href="" class="all">全部</a>-->
                    <a href="index.php?r=center/index&already=">未完成</a>
                    <a href="index.php?r=center/index&already=1">已完成</a>
                    <b class="f-top-y">医馆筛选</b>
                    <select name="yg" id="yg" value="博亿堂" class="hospital_name">

                        <?php foreach($brr as $k=>$v){?>
                            <option value="<?php echo $v['hospital_name']?>"><?php echo $v['hospital_name']?></option>
                        <?php }?>

                    </select>
                </div>
                <div class="f-bottom">
                    <div class="list">
                        <div class="f-left">
                            <!--<h3 style="color:black">全部<span style="background:#779800"><?php echo $zong?></span></h3>-->
                            <?php if(empty($vrr)){?>

                            <?php }else{?>
                                <?php foreach($vrr as $k=>$v){?>
                                    <h3 class="patient_type_name" value="<?php echo $v['patient_type_name']?>"><?php echo $v['patient_type_name']?><span><?php echo $v['count(patient_type_name)']?></span></h3>
                                <?php }}?>
                        </div>
                        <?php if(!empty($models)){?>
                            <div class="f-right">
                                <table cellpadding="0" cellspacing="0">
                                    <tr class="aaa">
                                        <td>药方编号</td>
                                        <td>医馆</td>
                                        <td>医师</td>
                                        <td>付数</td>
                                        <td>味数</td>
                                        <td>备注</td>
                                        <td>原药/代煎</td>
                                        <td>状态</td>
                                        <td>详细</td>
                                        <td>记录</td>
                                    </tr>
                                    <?php foreach($models as $k=>$v){?>
                                        <tr class="jkl">
                                            <td><?php echo $v['prescription_id']?></td>
                                            <td><?php echo $v['hospital_name']?></td>
                                            <td><?php echo $v['doctor_name']?></td>
                                            <td><?php echo $v['piece']?></td>
                                            <td><?php echo $v['kinds_per_piece']?></td>
                                            <td><?php

                                                echo substr($v['notes'],0,24)."..."?>

                                            </td>
                                            <td><?php if($v['production_type']=="1"){?>
                                                    原药
                                                <?php }else if($v['production_type']=="2"){?>

                                                    代煎
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php  if($v['prescription_status']==""){?>
                                                    等待录入
                                                <?php }else if($v['prescription_status']=="5"){?>
                                                    录入中
                                                <?php }else if($v['prescription_status']=="10"){?>
                                                    录入完成
                                                <?php }else if($v['prescription_status']=="15"){?>
                                                    审方中
                                                <?php }else if($v['prescription_status']=="20"){?>
                                                    审方完成
                                                <?php }else if($v['prescription_status']=="25"){?>
                                                    配药中
                                                <?php }else if($v['prescription_status']=="30"){?>
                                                    配药完成
                                                <?php }else if($v['prescription_status']=="35"){?>
                                                    核方中
                                                <?php }else if($v['prescription_status']=="40"){?>
                                                    核方完成
                                                <?php }else if($v['prescription_status']=="45"){?>
                                                    复查中
                                                <?php }else if($v['prescription_status']=="50"){?>
                                                    复查完成
                                                <?php }else if($v['prescription_status']=="55"){?>
                                                    煎制中
                                                <?php }else if($v['prescription_status']=="60"){?>
                                                    煎制完成
                                                <?php }else if($v['prescription_status']=="65"){?>
                                                    配送中
                                                <?php }else if($v['prescription_status']=="80"){?>
                                                    完成
                                                <?php }?>
                                            </td>
                                            <td><a href="javascript:void(0);" id="xxshow" class="prescription_id" onclick="showdiv();" value="<?php echo $v['prescription_id']?>">详细</a></td>
                                            <td><span  id="btnshow" onclick="showdiv();"  value="<?php echo $v['prescription_id']?>" class="status">流程</span></td>
                                        </tr>

                                    <?php }?>

                                </table>
                                <h1>
                                    <
                                    <?php
                                    for($i=1;$i<=$end;$i++){
                                        ?>
                                        <a href="index.php?r=center/index&page=<?php echo $i?>&already=<?php echo $already?>&patient_type_name=<?php echo $patient_type_name?>&hospital_name=<?php echo $hospital_name?>&search=<?php echo $search?>">&nbsp;<?php echo $i?>&nbsp;</a>
                                    <?php }?>
                                    >
                                </h1>    </div>
                            <!--yii框架内置分页-->
                        <?php }else{?>
                            <h1>暂无数据</h1>
                        <?php }?>
                    </div>
                </div>
                <!--<h2><b>合计：</b><i>13付</i><i>160味</i><i>12.652公斤</i></h2>-->
            </div>
        </div>
        <div id="bg">
        </div>
        <div id="show">
            <!-- 订单详情 -->
            <div class="ddxx"></div>
            <!-- 审方 -->
            <div class="shenfang"></div>
            <!-- 核方 -->
            <div class="kf">
                <!-- 头部 -->
                <div class="header">
                    药方进度<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span><b id="print"><img src="img/yfjd_03.jpg" alt="">标签打印</b></p>
                </div>
                <div class="liucheng">
                    <div class="luru">
                        <h3><b style="background-color:#779800;">1</b><span style="background-color:#779800;"></span></h3>
                        <h2>录入</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                    </div>
                    <div class="shengfang">
                        <h3><b style="background-color:#779800;">2</b><span style="background-color:#779800;"></span></h3>
                        <h2>审方</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                    </div>
                    <div class="peiyao">
                        <h3><b style="background-color:#779800;">3</b><span style="background-color:#779800;"></span></h3>
                        <h2>配药</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                    </div>
                    <div class="hefang">
                        <h3><b style="background-color:#779800;">4</b><span style="background-color:#779800;"></span></h3>
                        <h2>核方</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <h1 class="kfblock">
                            <i></i><i></i><i></i><i></i>
                        </h1>
                    </div>
                    <div class="fucha">
                        <h3><b style="background-color:#779800;">5</b><span style="background-color:#779800;"></span></h3>
                        <h2>复查</h2>
                        <button>开始</button>
                    </div>
                    <div class="jianzhi">
                        <h3><b>6</b><span></span></h3>
                        <h2>煎制</h2>
                    </div>
                    <div class="peisong1">
                        <h3><b>7</b></h3>
                        <h2>配送</h2>
                    </div>
                </div>
            </div>
            <!-- 配送 -->
            <div class="ps">
                <!-- 头部 -->
                <div class="header">
                    配送<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table" id="ps">
                </div>
                <div class="pscont">
                    <div class="psleft">
                        <div class="pslefttop"></div>
                        <div class="psleftbot">
                            <div class="psleftbotleft"></div>
                            <div class="psleftbotright"></div>
                        </div>
                    </div>
                    <div class="psright">
                        <h3>收件人姓名<input type="text" id="patient_names"></h3>
                        <h3>电话&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="mobiles"></h3>
                        <h3>地址<input type="text" style="margin-left:55px;height:60px;width:240px;" id="addresss"></h3>
                    </div>
                </div>
                <div class="psfoot"><button id="psover" type="button" value="X">完成</button></div>
            </div>
           <!--  配送2 -->
            <div id="ps2"></div>
            <!-- 录入2 -->
            <div class="lr2"></div>
            <!-- 煎制 -->
            <div class="jz"> </div>
            <!-- 药方进度2 -->
            <div class="yfjd"></div>
            <!-- 录入 -->
            <div class="lr"></div>
            <!-- 复查 -->
            <div class="fc"> </div>
            <!-- 标签 -->
            <div class="bq">
                <!-- 头部 -->
                <div class="header">
                    标签打印
							<span id="btnclose" >
								<img src="img/订单详细-2_03.gif" alt=""  onclick="hidediv();">
							</span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="bqcont">
                    <div class="bqleft">
                        <h4>配药标签<span>7枚</span></h4>
                        <div class="pybq" style="width:200px;height:175px;border:1px solid #e3e4e4;margin:0 auto;">
                            <div id="printContainer">
                                <h3 class="name" style="font-size:11px;color:#666666;height: 35px;line-height:35px;border-bottom:1px solid #e3e4e4;display: inline-block;width:200px;">
                                    王胜利
                                </h3>
                                <h2 class="time" style="font-size: 10px;color:#666666;font-weight: normal;height:30px;line-height: 30px;padding-left: 3px;">
                                    一日两次
                                    <span style="font-weight:normal;font-size: 12px;display: inline-block;margin-left:75px;">7付</span>
                                    <span  style="font-weight:normal;font-size: 12px;display: inline-block;margin-left:15px;">14包</span>
                                </h2>
                                <div class="psxx" style="margin-top:2px;display: inline-block;color:#bcbcbc;">
                                    <span style="display: inline-block;line-height:20px;height:20px;margin-left:5px;font-size:10px;">大宇中医堂：王神医</span><br>
                                    <span style="display: inline-block;line-height: 20px;height:20px;margin-left:5px;font-size:10px;">2016/04/07   14:23</span>
                                    <div class="txm" style="margin-left: 21px;display: inline-block;margin-top:-30px;margin-left:10px;width:70px;"">
                                    <img src="img/标签打印_03.gif" alt="" style="float:right;width:70px;height:40px;">
                                    <p style="color:black;font-size:4px;padding-left:1px;padding-right:1px;letter-spacing:-1px;">123445566633</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <center><input type="button" onclick="print()" value="打印" id="zuo"/></center>
                </div>
                <div class="bqright">
                    <h4>包装标签<span>2枚</span></h4>
                    <div class="bzbq" style="	width:200px;height:175px;border:1px solid #e3e4e4;margin:0 auto;">
                        <div  class="printContainer2">
                            <h3 style="font-size:11px;color:#666666;height: 25px;line-height:25px;border-bottom:1px solid #e3e4e4;display: inline-block;width:200px;">
                                王胜利<img src="img/标签打印(aaaaa)_03.gif" alt="" style="float:right;padding-right: 4px;width:65px;height:25px;margin-left:-10px;">
                            </h3>
                            <h2 class="time" style="	font-size: 11px;color:#666666;font-weight: normal;height:25px;line-height: 25px;padding-left: 4px;">
                                一日两次
                                <span style="font-weight:normal;font-size: 12px;display: inline-block;margin-left:75px;">7付</span>
                                <span style="font-weight:normal;font-size: 12px;display: inline-block;margin-left:20px;">14包</span>
                            </h2>
                            <h5 style="font-size: 6px;color:#d4d4d4;">大宇中医堂：王神医<span style="margin-left:10px;letter-spacing:-1px;">2016/4/17 <b style="margin-left: 7px;letter-spacing:-1px;font-weight:normal;">14:35</b></span></h5>
                            <div class="erweima" style="display: inline-block;width:200px;height:53px;margin-top:4px;"><p style="width:100px;font-size:2px;color:#e3e4e4;float:left;">扫描二维码查阅本方配制和煎制</p><img src="img/标签打印_06.gif" alt="" style="width:75px;height:75px;margin-left:125px;margin-top:-34px;"></div>
                            <div class="txm" style="margin-top:0px;">

                                <p style="color:black;font-size:4px;padding-left:1px;padding-right:1px;letter-spacing:1px;">123456789123</p>
                            </div>
                        </div>
                    </div>
                    <h4>药袋标签<span>2枚</span></h4>
                    <div class="ydbq" style="width:200px;height:175px;border:1px solid #e3e4e4;margin:0 auto;margin-top:70px;">
                        <div class="printContainer3">

                            <h3 style="font-size:11px;color:#666666;height: 30px;line-height:30px;border-bottom:1px solid #e3e4e4;display: inline-block;width:200px;">
                                王胜利
                            </h3>
                            <h2 class="time" style="font-size: 11px;color:#666666;font-weight: normal;height:30px;line-height: 30px;padding-left: 4px;">
                                一日两次
                                <span style="font-weight:normal;font-size: 11px;display: inline-block;margin-left:75px;">7付</span>
                                <span style="font-weight:normal;font-size: 11px;display: inline-block;margin-left:15px;">14包</span>
                            </h2>
                            <h5 style="font-size: 10px;color:#d4d4d4;margin-top:45px;">大宇中医堂：王神医<span style="margin-left:10px;letter-spacing:-2px;">2016/4/17 <b style="margin-left: 5px;letter-spacing:-2px;font-weight:normal;">14:35</b></span></h5>
                        </div>
                    </div>
                    <center><input type="button" onclick="print2()" value="打印" id="you"/></center>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<input type="hidden"  class="one" value="<?php echo $already?>">
<input type="hidden"  class="two" value="<?php echo $patient_type_name?>">
<input type="hidden"  class="three" value="<?php echo  $hospital_name?>">
<input type="hidden"  class="four" value="<?php echo  $search?>">

<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.9.0/jquery.min.js"></script>
<script src="lc/js/shouye.js"></script>
<script language="javascript" src="js/jquery1-8-0.js"></script>
<script src='http://cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script src='js/pass.js'></script>

<script type="text/javascript" src="jQuery-Autocomplete-master/scripts/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="jQuery-Autocomplete-master/src/jquery.autocomplete.js"></script>
<script type="text/javascript" src="jQuery-Autocomplete-master/scripts/countries.js"></script>
<script type="text/javascript" src="jQuery-Autocomplete-master/scripts/medicineinput.js"></script>
<!--搜索-->
<script>
    $(document).on("click",".search",function(){
        search=$("#text").val()
        already=$(".one").attr("value")
        patient_type_name=$(".two").attr("value")
        hospital_name=$(".three").attr("value")
        $.ajax({
            url:'index.php?r=center/typefour',
            type:'get',
            data:'patient_type_name='+patient_type_name+'&already='+already+'&hospital_name='+hospital_name+'&search='+search,
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>
<!--根据医院搜索-->
<script>
    $(document).on("change",".hospital_name",function(){
        hospital_name=$(this).attr("value")
        $.ajax({
            url:'index.php?r=center/typetwo',
            type:'get',
            data:'hospital_name='+hospital_name,
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>
<!--详情-->
<script>
    $(document).on("click",".prescription_id",function(){
        prescription_id=$(this).attr("value")
        $.ajax({
            url:'index.php?r=center/detail',
            type:'get',
            data:'prescription_id='+prescription_id,
            success:function(data){
                $(".ddxx").html(data)
                $("#show").children(".ddxx").show().siblings().hide();
            }
        })
    })
</script>
<script>
    $(document).on("click",".patient_type_name",function(){
        patient_type_name=$(this).attr("value")
        $.ajax({
            url:'index.php?r=center/typetwo',
            type:'get',
            data:'patient_type_name='+patient_type_name,
            success:function(data){
                $(".list").html(data)
            }
        })

    })
</script>
<script>
    // 连接服务端
    var socket = io('http://workerman.net:2120');
    uid =5768999;
    // socket连接后以uid登录
    socket.on('connect', function(){
        socket.emit('login', uid);
    });
    // 后端推送来消息时
    socket.on('new_msg', function(msg){
        var toreplace=msg.replace(/&quot;/g,"");
        toreplace=toreplace.replace(/:/g,":'");
        toreplace=toreplace.replace(/,/g,"',");
        toreplace=toreplace.replace(/}/g,"'}");
            var str="";
            var data2=eval('('+toreplace+')');
        if(data2['type']=='ryg'){
            str+='<tr class="jkl">';
            str+="<td>"+data2['prescription_id']+"</td>";
            str+=" <td>"+data2['hospital_name']+"</td>";
            str+="<td>"+data2['doctor_name']+"</td>";
            str+="<td>"+data2['piece']+"</td>"
            str+="<td>"+data2['kinds_per_piece']+"</td>"
            str+="<td>"+data2['notes'].substr(0,5)+"...</td>";
            if(data2['production_type']=='1'){
                str+="<td>原药</td>";
            }else{
                str+="<td>代煎</td>";
            }
            if(data2['prescription_status']=="1"){
                str+="<td>录入</td>";
            }else if(data2['prescription_status']=="2"){
                str+="<td>审方</td>";
            }else if(data2['prescription_status']=="3"){
                str+="<td> 配药</td>";
            }else if(data2['prescription_status']=="4"){
                str+="<td> 核方</td>";
            }else if(data2['prescription_status']=="5"){
                str+="<td> 复查</td>";
            }else if(data2['prescription_status']=="6"){
                str+="<td> 煎制</td>";
            }else if(data2['prescription_status']=="7"){
                str+="<td> 配送</td>";
            }
            str+='<td><a href="javascript:void(0);" id="xxshow" class="prescription_id" value="'+ data2["prescription_id"]+'">详细</a></td>';
            str+='<td><span class="status" onclick="showdiv();"  value="'+data2['prescription_id']+'">流程</span></td>';

            str+='<tr>';
            $(".jkl").first().before(str);
        }

    });
    // 后端推送来在线数据时
    socket.on('update_online_count', function(online_stat){
        console.log(online_stat);
    });
<!--流程-->
    $(document).on("click",".status",function(){
        $(".yfjd").show().siblings().hide();
        var prescription_id = $(this).attr("value");
        $.get("?r=center/technological",{prescription_id : prescription_id},function(data){
         $(".yfjd").html(data)
        });

    })
//录入开始
    $(document).on("click","#btnshow1",function(data){
          $(".yfjd").hide();
          var prescription_id = $("#prescription_id").html();
          $.get("?r=center/prescription_add",{prescription_id : prescription_id},function(data) {
              $(".lr").show();
              $(".lr").html(data);
          })
    })
 //录入药方图片切换
    $(document).on("click",".lrleftbotleft",function(data){
          var photo_id = $(this).attr("value");
          $.get("?r=center/prescription_photo",{photo_id : photo_id},function(data) {
              var str="";
              var arr=eval('('+data+')');
                  str+='<img src="'+arr["photo_img"]+'" width="650" height="350">';
                  $(".lrlefttop").html(str);
          })
    })
  //关闭录入
    $(document).on("click",".lr_over",function(){
        $(".lr").hide();
        $("#bg").hide();
    })
    //录入完成
    $(document).on("click","#psdover",function(){
             var prescription_id = $("#prescriptions_id").attr("value");
             var patient_name = $("#patient_name").val();
             var gender = $(".gender:checked").val();
             var age = $("#age").val();
             var piece=$("#piece").val();
             var kinds_per_pieces=$("#kinds_per_pieces").val();
             var use_frequence =  $("#use_frequence").val();
             var usage_id = $("#yongfa").val();
             var medicine_id = $(".sel");
             var medicines_id='';
             medicine_id.each(function(i,v){
                 medicines_id+=','+v['alt'];
             });
             var weight =$(".weight");
             var weights ="";
             weight.each(function(i,v){
                 weights+=','+v['value'];
            });
            var produce_frequence = $(".produce_frequence");
            var produce_frequences ="";
            produce_frequence.each(function(i,v){
                produce_frequences+=','+v['value'];
            });
            var password_hash = $("#password_hash").val();
        $.post("?r=center/prescriptionadds", {
            password_hash : password_hash,
            patient_name : patient_name ,
            gender: gender,
            age : age,
            piece : piece,
            kinds_per_pieces : kinds_per_pieces,
            use_frequence : use_frequence,
            usage_id : usage_id,
            medicine_id : medicines_id,
            weight : weights,
            produce_frequence : produce_frequences,
            prescription_id : prescription_id
        },function(data){
                $(".ps").show();
                $(".lr").hide();
            var str_photo = "";
            var arr=eval('('+data+')');
                str_photo += '<div class="pslefttop"><img width="650" height="350" src="' + arr["prescription_photo_list"]["photo_img"] + '" alt=""/></div>';
                str_photo += '<div class="psleftbot">';
                str_photo += '<div class="psleftbotleft"><img width="170" height="110" src="' + arr["prescription_photo_list"]["photo_img"] + '" alt=""/></div>';
                str_photo += '</div>';
                $(".psleft").html(str_photo);
            if(arr["patient_list"]!=""){
                var str_patient = "";
                str_patient+= '<h3>收件人姓名<input type="text" name="name" id="patient_names" value="'+arr["patient_list"]["addressee_name"]+'"></h3>';
                str_patient+='<p class="meg" style="dispaly:none;"><i class="ati"></i>请输入收件人的姓名</p>';
                str_patient+= '<h3>电话&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="tel" id="mobiles" value="'+arr["patient_list"]["mobile"]+'"></h3>';
                str_patient+= '<p class="meg" style="dispaly:none;"><i class="ati"></i>请输入收件人的手机号</p>';
                str_patient+= '<h3>地址<input type="text" style="margin-left:55px;height:60px;width:240px;" name="address" id="addresss" value="'+arr["patient_list"]["address"]+'"></h3>';
                str_patient+= '<p class="meg" style="dispaly:none;"><i class="ati"></i>请输入收件人的地址</p>';
                $(".psright").html(str_patient);
            }
            var str_prescription = "";
                str_prescription+= '<p>';
                str_prescription+= '药方编号<span>'+arr["prescription_list"]["prescription_id"]+'</span>';
                str_prescription+= '医馆<span>'+arr["prescription_list"]["hospital_name"]+'</span>';
                str_prescription+= '医师<span>'+arr["prescription_list"]["doctor_name"]+'</span>';
                str_prescription+= '付数<span>'+arr["prescription_list"]["piece"]+'</span>';
                str_prescription+= '味数<span>'+arr["prescription_list"]["kinds_per_piece"]+'</span>';
                if(arr["prescription_list"]["production_type"]==1){
                    str_prescription+= '原药/代煎<span>原药</span>';
                }else{
                    str_prescription+= '原药/代煎<span>代煎</span>';
                }
                str_prescription+= '</p>';
            $("#ps").html(str_prescription);
           });
        })
    //点击加号添加一行
    $(document).on("click","#jia",function(){
        $("#tabs").append("<tr class='tr-trs'><td class='td-1' ><div class='container'><input type='text' placeholder='药名' name='country1' id='autocomplete-ajax1' class='sel' style='position: absolute1; z-index: 2; background: transparent;'/></div></td><td class='td-2'><input type='text' class='weight'  placeholder='重量'  style='width:82px;color:#e3e4e4;'>克</td><td><select name='' class='produce_frequence'><option value='1'>先煎</option><option value='2'>后下</option><option value='3'>包煎</option><option value='4'>烊化</option><option value='5'>冲服</option><option value='6'>普通</option></select></td><td class='del'><img src='img/订单详细-2_03.gif' alt='' ></td></tr>");
    })
    $(document).on("focus",".medicine_name",function(){
        $(this).next(".aa").show();
    })
    $(document).on("blur",".medicine_name",function(){
        $(this).next(".aa").hide();
    })
    //配送地址添加
    $(document).on("click","#psover",function(){
         var patient_name = $("#patient_names").val();
         var mobile = $("#mobiles").val();
         var address = $("#addresss").val();
        var prescription_id = $("#prescriptions_id").attr("value");
         $.post("?r=center/distribution_add", {
             patient_name:patient_name,
             mobile:mobile,
             address:address,
             prescription_id:prescription_id
         },function(data){
             $(".yfjd").html(data)
             $(".ps").hide();
             $(".yfjd").show();
         })
    })
    //录入修改
    $(document).on("click","#lr_gai0",function(){
        $(".yfjd").hide();
        $(".lr").show();
        var prescription_id = $("#prescription_id").html();
        $.get("?r=center/prescription_upd",{prescription_id : prescription_id},function(data) {
            $(".lr").html(data);
        })
    })
   //药材名称搜索
    $(document).on("click",".sel",function(){
        $(function () {
            'use strict';
            var countries = <?php echo $medicines_list;?>;
            var countriesArray = $.map(countries, function (value, key) {
                return {value: value, data: key};
            });
            $('.sel').autocomplete({
                lookup: countriesArray,
                showNoSuggestionNotice: false,
                noSuggestionNotice: '没有可匹配药材',
                lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function (suggestion) {
                    var words = suggestion.value.split(' ');
                    $(this).attr("value", words[1]);
                    //$(this).attr("value", suggestion.value);
                    $(this).attr("alt", suggestion.data);
                },

                onHint: function (hint) {
                    $(this).val(hint);
                },

                onInvalidateSelection: function () {
                    $(this).html('未选择');
                    //$(this).html('You selected: none');
                }
            });
        })
    })
    //审方开始
    $(document).on("click","#btnshow2",function(){
        $(".yfjd").hide();
        $(".lr").show();
        var prescription_id = $("#prescription_id").html();
        $.get("?r=center/prescription_sf",{prescription_id : prescription_id},function(data) {
            $(".lr").html(data);
        })
    })
    //审方确定
   $(document).on("click","#shenfangover",function() {
       $("#psdbg-sf").show();
       $("#psdshow-sf").show();
   })
    $(document).on("click","#psdover-sf",function(){
        var password_hash = $("#password_hash_sf").val();
       var prescription_id = $("#prescription_id_sf").html();
       var patient_name = $("#patient_name").val();
       var gender = $(".gender:checked").val();
       var age = $("#age").val();
       var piece=$("#piece").val();
       var kinds_per_pieces=$("#kinds_per_pieces").val();
       var use_frequence =  $("#use_frequence").val();
       var usage_id = $("#yongfa").val();
       var medicine_id = $(".sel");
       var medicines_id='';
       medicine_id.each(function(i,v){
           medicines_id+=','+v['alt'];
       });
       var weight =$(".weight");
       var weights ="";
       weight.each(function(i,v){
           weights+=','+v['value'];
       });
       var produce_frequence = $(".produce_frequence");
       var produce_frequences ="";
       produce_frequence.each(function(i,v){
           produce_frequences+=','+v['value'];
       });
       $.post("?r=center/prescription_sf_ok", {
           patient_name : patient_name ,
           gender: gender,
           age : age,
           piece : piece,
           kinds_per_pieces : kinds_per_pieces,
           use_frequence : use_frequence,
           usage_id : usage_id,
           medicine_id : medicines_id,
           weight : weights,
           produce_frequence : produce_frequences,
           prescription_id : prescription_id,
           password_hash:password_hash
       },function(data){
           $(".lr").hide();
           $(".yfjd").html(data);
           $(".yfjd").show();
       })
   })
    //复查开始
    $(document).on("click","#btnshow5",function(){
        var prescription_id = $("#prescription_id").html();
        $.get("?r=center/prescription_fc",{prescription_id : prescription_id},function(data) {
            $(".fc").html(data);
            $(".yfjd").hide();
            $(".fc").show();
        })
    })
    //复查药方图片切换
    $(document).on("click",".fcleftbotleft",function(data){
        var taken_type = $(this).attr("value");
        var prescription_id = $("#prescription_id").html();
        $.get("?r=center/prescription_fc_photo",{taken_type : taken_type,prescription_id:prescription_id},function(data) {
            var str="";
            var arr=eval('('+data+')');
            str+='<img src="'+arr["photo"]+'" width="650" height="350">';
            $(".fclefttop").html(str);
        })
    })
    //发现差错重新配药
    $(document).on("click","#again",function() {
        $("#psdbg-again").show();
        $("#psdover-again").show();
    })
    $(document).on("click","#re_dispensing",function(){
        var prescription_id = $("#prescription_id").html();
        var password_hash = $("#password_hash_again").val();
        $.get("?r=center/prescription_del",{prescription_id : prescription_id,password_hash:password_hash},function(data) {
            $(".fc").hide();
            $(".yfjd").html(data);
            $(".yfjd").show();
        })
    })
   //复查完成
    $(document).on("click","#fcover",function() {
        $("#psdbg-fc").show();
        $("#psdshow-fc").show();
    })
    $(document).on("click","#psdover-fc",function(){
        var prescription_id = $("#prescription_id").html();
        var password_hash = $("#password_hash_fc").val();
        $.post("?r=center/prescription_ok",{password_hash : password_hash,prescription_id : prescription_id},function(data) {
            $(".fc").hide();
            $(".yfjd").html(data);
            $(".yfjd").show();
        })
    })
    //煎制开始
    $(document).on("click","#btnshow6",function(){
        var prescription_id = $("#prescription_id").html();
        $.post("?r=center/prescription_jz",{prescription_id : prescription_id},function(data) {
            $(".jz").html(data);
            $(".yfjd").hide();
            $(".jz").show();
        })
    })
    //煎制完成
    $(document).on("click","#jzover",function(){
        $("#psdbg-jz").show();
        $("#psdshow-jz").show();
    })
    $(document).on("click","#psdover-jz",function(){
        var a_prescription_id_check = $("#a_prescription_id_check:checked").val();     //煎制后编号确认
        var p_prescription_id_check = $("#p_prescription_id_check:checked").val();   //药方编号确认
        var p_soaking_time = $("#p_soaking_time").val();                                //泡制时间
        var b_prescription_id_check = $("#b_prescription_id_check:checked").val();   //煎制前编号确认
        var b_piece_check = $("#b_piece_check:checked").val();                         //副数确认
        var b_kinds_check = $("#b_kinds_check:checked").val();                         //味数确认
        var b_appearance_check = $("#b_appearance_check:checked").val();              //外观确认
        var b_water_yield = $("#b_water_yield").val();                                  //用水量
        var b_pressure = $("#b_pressure").val();                                         //压力
        var b_boiling_time = $("#b_boiling_time").val();                                 //煎制时间
        var decocting_machine = $("#decocting_machine").val();                           //煎药机
        var b_pre_boiling = $("#b_pre_boiling:checked").val();                           //先煎
        var b_post_boiling = $("#b_post_boiling:checked").val();                        //后下
        var b_boiling_start_time = $("#b_boiling_start_time").val();                     //下药时间
        var a_soup_appearance_check = $("#a_soup_appearance_check:checked").val();     //汤外观确认
        var a_quantity_check = $("#a_quantity_check").val();                              //量确认
        var a_boiling_end_time = $("#a_boiling_end_time").val();                          //出药时间
        var prescription_id = $("#prescription_id").html();                               //药方编号
        var password_hash = $("#password_hash").val();                                    //操作人密码
        $.post("?r=center/prescription_jz_add",{
            prescription_id : prescription_id,                   //药方编号
            password_hash :password_hash,                        //操作人密码
            a_boiling_end_time:a_boiling_end_time,               //出药时间
            a_quantity_check:a_quantity_check,                  //量确认
            a_soup_appearance_check:a_soup_appearance_check,    //汤外观确认
            a_prescription_id_check:a_prescription_id_check,       //煎制后编号确认
            b_boiling_start_time:b_boiling_start_time,           //下药时间
            b_post_boiling : b_post_boiling,                        //后下
            b_pre_boiling:b_pre_boiling,                          //先煎
            decocting_machine:decocting_machine,                 //煎药机
            b_boiling_time:b_boiling_time,                        //煎制时间
            b_pressure:b_pressure,                                 //压力
            b_water_yield:b_water_yield,                           //用水量
            b_appearance_check:b_appearance_check,                //外观确认
            b_kinds_check:b_kinds_check,                           //味数确认
            b_piece_check:b_piece_check,                           //副数确认
            b_prescription_id_check:b_prescription_id_check,      //煎制前编号确认
            p_soaking_time:p_soaking_time,                          //泡制时间
            p_prescription_id_check:p_prescription_id_check        //药方编号确认
        },function(data){
            $(".jz").hide();
            $(".yfjd").html(data);
            $(".yfjd").show();
        })
    })
   //审方里的超量禁忌医师再度确认
   $(document).on("click","#physician_confirmation",function(){
       var doctor_id = $("#doctor_id").val();
       $("#physician_confirmation").hide();
       $.post("?r=center/physician_confirmation",{doctor_id : doctor_id},function(data){
           alert(data);
       });
   })
   //配送开始
    $(document).on("click","#btnshow7",function(){
        $(".yfjd").hide();
        $(".ps").show();
        var prescription_id = $("#prescription_id").html();
        $.post("?r=center/prescription_ps",{prescription_id : prescription_id},function(data) {
           $(".ps").html(data);
        })
    })
   //配送完成
    $(document).on("click","#psover2",function(){
        $("#psdbg-ps2").show();
        $("#psdshow-ps2").show();
    })
    $(document).on("click","#psdover-ps2",function(){
         var odd_numbers = $("#odd_numbers").val();
        var prescription_id = $("#prescription_id").html();
        var password_hash = $("#password_hash_qi").val();
        $.post("?r=center/prescription_ps_add",{odd_numbers:odd_numbers,prescription_id : prescription_id,password_hash:password_hash},function(data) {
            $(".ps").hide();
            $(".yfjd").html(data);
            $(".yfjd").show();
        })
    })
    //通知医师确认超量的药方
    $(document).on("click","#physician_confirmations",function(){
        var prescription_id = $("#prescription_id").html();
        var doctor_id = $("#doctor_id").val();
        $.post("?r=center/physician_confirmation",{prescription_id : prescription_id,doctor_id:doctor_id},function(data){
            alert("已通知医师");
            $("#physician_confirmations").hide();
        });
    })
</script>




