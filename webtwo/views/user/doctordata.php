<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>医师日别页</title>
    <link rel="stylesheet" href="css/doctor-yuebie.css">
    <!--引入日历插件的css样式-->
    <link rel="stylesheet" href="date/need/laydate.css">
    <link rel="stylesheet" href="date/skins/default/laydate.css">
</head>
<body>
<div class="container">
    <header class="header">
        <div class="logo">
            <img src="img/订单_02.png" alt="">
        </div>
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;中央药房</p>
        <ul>
            <li><a href="index.php?r=center/index">订单</a></li>
            <li><a href="index.php?r=user/index">客户</a></li>
            <li><a href="index.php?r=setup/index"></a>设置</li>
        </ul>
    </header>
    <!--医师 -->
    <div class="doctor">
        <div class="content">
            <div class="s-top">
                <ul>
                    <li>今日(<?php echo $date?>)</li>
                    <?php if(!empty($crr['brr'])&&!empty($crr['arr'])){?>
                        <li>客户数<span><?php echo $crr['arr']?></span>家</li>
                        <li>医师数<span><?php echo $crr['brr']?></span>位</li>
                    <?php }else{?>
                        暂无数据
                    <?php }?>
                </ul>
            </div>
            <div class="search" >
                <b><img src="img/订单_06.gif" alt=""></b><input type="text" placeholder="医生名称"  alt="" id="text">
                <input type="button" value="搜索" id="search">
                <a  class="yd">月度别</a>
            </div>
            <div class="footer">
                <input type="hidden" value="<?php echo $hospital_name?>" class="hospital_name">
                <input type="hidden" " class="doctor_nametwo">
                <div class="f-top">
                    <a  href="#" value="A-Y" class="firstletter">全部</a>
                    <a href="#" class="firstletter" value="A-D">A-D</a>
                    <a  href="#" class="firstletter" value="E-H">E-H</a>
                    <a href="#" class="firstletter" value="I-L">I-L</a>
                    <a  href="#" class="firstletter" value="M-P">M-P</a>
                    <a  href="#" class="firstletter" value="Q-T">Q-T</a>
                    <a href="#" class="firstletter"  value="U-W">U-W</a>
                    <a href="#" class="firstletter" value="X-Y">X-Y</a>
                    <b class="f-top-y"><input type="button"  value="日期筛选" class="datevalue"></b>
                    <input type="text" id="J-xl"  >
                    <p  class="doctorinfo" style="display:inline-block;"  id="btnshow" onclick="showdiv();" >医师信息</p>
                    <input type="button" value="下载" id="xiazai">
                    <input type="button" value="打印" id="print">
                </div>
                <div class="f-bottom" >
                    <div class="f-left">
                        <?php foreach($qq as $k=>$v){?>
                        <h3><span class="doctor_name"><?php echo $v['doctor_name']?></span></h3>
                        <?php }?>
                    </div>
                    <div class="f-right" style="width:86.5%;">
                        <div class="list">
                            <?php if(!empty($ww)){ ?>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>药方编号</td>
                                <td>医师</td>
                                <td>付数</td>
                                <td>味数</td>
                                <td>备注</td>
                                <td>原药/代煎</td>
                                <td>状态</td>
                                <td>金额</td>
                            </tr>
                            <?php foreach($ww as $k=>$v){?>
                            <tr>
                                <td><?php echo $v['prescription_id']?></td>
                                <td><?php echo $v['doctor_name']?></td>
                                <td><?php echo $v['piece']?></td>
                                <td><?php echo $v['kinds_per_piece']?></td>
                                <td><?php echo $v['notes']?></td>
                                <td>
                                    <?php if($v['production_type']==1){?>
                                    原药
                                    <?php }else if($v['production_type']==2){?>
                                    代煎
                                    <?php }?>
                                </td>
                                <td>
                                    <?php if($v['prescription_status']==1){?>
                                        录入
                                    <?php }elseif($v['prescription_status']==2){?>
                                        审方
                                    <?php }elseif($v['prescription_status']==3){?>
                                        配药
                                    <?php }elseif($v['prescription_status']==4){?>
                                        核方
                                    <?php }elseif($v['prescription_status']==5){?>
                                        复查
                                    <?php }elseif($v['prescription_status']==6){?>
                                        煎制
                                    <?php }elseif($v['prescription_status']==7){?>
                                        配送
                                    <?php }?>
                                </td>
                                <td><?php echo $v['price']?></td>
                            </tr>
                            <?php }?>



                        </table>
                        <h1><
                            <?php for($i=1;$i<=$quzheng;$i++){?>
                                <a href="index.php?r=user/doctordata&page=<?php echo $i?>&hospital_name=<?php echo $hospital_name?>&doctor_name=<?php echo $doctor_name?>&datetime=<?php echo $datetime?>&firstletter=<?php echo $firstletter?>"><?php echo $i?></a>

                            <?php }?>
                            >
                        </h1>
                            <?php }else{?>
                            <h1><center>暂无数据</center></h1>
                            <?php }?>
                            </div>

                </div>
               <!-- <div class="heji"><h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2></div>-->
            </div>
                </div>
            <div id="bg">
            </div>
            <div id="show">
                <div class="ysxx">
                    <header>客户管理<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()" style="float:right;"></span></header>
                    <div class="zhuti">
                        <h3>基本信息</h3>
                        <div id="photo"><img src="img/u=3598461135,406107685&fm=21&gp=0.jpg"></div>
                        <ul>
                            <li><span>医师姓名</span><b>刘正</b></li>
                            <li><span>账号</span><b>13141234481</b></li>
                            <li><span>医馆名称</span><b>同仁堂</b></li>
                            <li><span>客户地址</span><b>北京市清华路13号102</b></li>
                            <li><span>加入日期</span><b>2016/04/12</b></li>
                            <li><span>最后使用日期</span><b>2016/04/12</b></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery1.8.js"></script>
<script src="js/shouye.js"></script>
<script language="javascript" src="js/jquery-1.6.2.js"></script>
<script language="javascript" src="js/jquery.jqprint-0.3.js"></script>
<script language="javascript" src="js/jquery1-8-0.js"></script>
</body>
</html>
<!--通过医生名称筛选出他对应的一些信息-->
<script>
    $(document).on("click",".doctor_name",function(){
      doctor_name=$(this).html()
        $(".doctor_nametwo").html(doctor_name)
        hospital_name=$(".hospital_name").attr("value")

        $.ajax({
            url:'index.php?r=user/doctordatatwo',
            type:'get',
            data:'doctor_name='+doctor_name+'&hospital_name='+hospital_name,
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>
<!--医师信息-->
<script>
    $(document).on("click",".doctorinfo",function(){
        hospital_name=$(".hospital_name").attr("value")
    doctor_name=$(".doctor_nametwo").html()
        if(doctor_name==""){
            doctor_name="润衣阁"
        }
        $.ajax({
            url:'index.php?r=user/doctorinfo',
            type:'get',
            data:'doctor_name='+doctor_name+'&hospital_name='+hospital_name,
            success:function(data){
                $(".ysxx").html(data)
            }
        })

    })
</script>
<!--根据医师名称搜索-->
<script>
    $(document).on("click","#search",function(){
        hospital_name=$(".hospital_name").attr("value")
        doctor_name=$("#text").val()
        $.ajax({
            url:'index.php?r=user/doctordatatwo',
            type:'get',
            data:'doctor_name='+doctor_name+'&hospital_name='+hospital_name,
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>
<!--日历插件-->
<script type="text/javascript" src="js/laydate.dev.js"></script>
<script type="text/javascript">
    laydate({
        elem: '#J-xl'

    });
</script>
<!--通过时间筛选信息-->
<script>
    $(document).on("click",".datevalue",function(){
        hospital_name=$(".hospital_name").attr("value")
        date=$("#J-xl").val()
        if(date==""){
            alert("请选择日期")
        }else{
            $.ajax({
                url:'index.php?r=user/doctordatatwo',
                type:'get',
                data:'datetime='+date+'&hospital_name='+hospital_name,
                success:function(data){
                    $(".list").html(data)
                }
            })
        }
    })

</script>
<!--下载-->
<script>
    $(document).on("click","#xiazai",function(){
        hospital_name=$(".hospital_name").attr("value")
        location.href='index.php?r=user/downthree&hospital_name='+hospital_name
    })
</script>
<!--月度别-->
<script>
    $(document).on("click",".yd",function(){
        hospital_name=$(".hospital_name").attr("value")
        location.href='index.php?r=user/doctordatayue&hospital_name='+hospital_name

    })
</script>
<!--根据英文字母匹配数据-->
<script>
    $(document).on("click",".firstletter",function(){
        firstletter=$(this).attr("value")
        hospital_name=$(".hospital_name").attr("value")
        $.ajax({
            url:'index.php?r=user/doctordatatwo',
            type:'get',
            data:'firstletter='+firstletter+'&hospital_name='+hospital_name,
            success:function(data){
                $(".list").html(data)
            }
        })

    })
</script>