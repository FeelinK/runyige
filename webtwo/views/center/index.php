<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/shouye.css">
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
                <input type="button" value="搜索" id="search" class="search">
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
                                    <h3  class="patient_type_name" value="<?php echo $v['patient_type_name']?>"><?php echo $v['patient_type_name']?><span><?php echo $v['count(patient_type_name)']?></span></h3>
                                <?php }}?>
                        </div>
                        <?php if(!empty($models)){?>
                            <div class="f-right">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
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
                                                <?php  if($v['prescription_status']=="1"){?>
                                                    录入
                                                <?php }else if($v['prescription_status']=="2"){?>
                                                    审方

                                                <?php }else if($v['prescription_status']=="3"){?>
                                                    配药
                                                <?php }else if($v['prescription_status']=="4"){?>
                                                    核方

                                                <?php }else if($v['prescription_status']=="5"){?>
                                                    复查
                                                <?php }else if($v['prescription_status']=="6"){?>
                                                    煎制

                                                <?php }else if($v['prescription_status']=="7"){?>
                                                    配送
                                                <?php }?>
                                            </td>
                                            <td><a href="javascript:void(0);" id="xxshow" onclick="showdiv();" class="prescription_id" value="<?php echo $v['prescription_id']?>">详细</a></td>
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
            <div class="ddxx">
                <!-- 头部 -->
                <div class="header">
                    订单详细<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="foot">
                    <div class="foot-l">
                        <ul>
                            <li>
                                <img src="img/u=3598461135,406107685&fm=21&gp=0.jpg" alt="">
                                <p id="zhongl">6g</p>
                                <p id="yaoming">人参</p>
                            </li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                            <li><img src="img/订单详细-2_04.gif"></li>
                        </ul>
                    </div>
                    <div class="foot-r">
                        <div class="foot-r-t">
                            <h1>备注</h1>
                            <p>如果你无法简洁的表达你的想法，那只能说明你还不够了解他。
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--阿尔伯特.爱因斯坦

                            </p>
                        </div>
                        <div class="foot-r-z">
                            <h2>药方照片</h2>
                            <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="foot-r-f">
                            <h1>配送信息</h1>
                            <p><img src="img/ddxx-1_03.gif" alt=""><span>王胜利</span></p>
                            <p><img src="img/ddxx-2_03.gif" alt=""><span>13141234481</span></p>
                            <p><img src="img/ddxx-3_03.gif" alt=""><span>北京市海淀区西二旗北大街之学10-1-102</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 审方 -->
            <div class="shenfang">
                <!-- 头部 -->
                <div class="header">
                    审方<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="sfcont">
                    <div class="sfleft">
                        <div class="sflefttop"></div>
                        <div class="sfleftbot">
                            <div class="sfleftbotleft"></div>
                            <div class="sfleftbotright"></div>
                        </div>
                    </div>
                    <div class="sfright">
                        <table>
                            <tr>
                                <td style="width:100px;text-align:center;">人电放费参</td>
                                <td><input type="text" >克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td style="width:100px;text-align:center;"><input type="text" placeholder="药名" style="width:80px;color:#e3e4e4;"></td>
                                <td><input type="text" placeholder="重量"  style="width:100px;color:#e3e4e4;">克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="sffoot"><button id="shenfangover" onclick="psdhidediv();">完成</button></div>
            </div>
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
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
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
                        <h3>收件人姓名<input type="text"></h3>
                        <h3>电话&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"></h3>
                        <h3>地址<input type="text" style="margin-left:55px;height:60px;width:240px;"></h3>
                    </div>
                </div>
                <div class="psfoot"><button id="psover" type="button" value="X">完成</button></div>
            </div>
            <!-- 自动检查 -->
            <div class="zdjc">
                <!-- 头部 -->
                <div class="header">
                    自动检查<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="zdjccont">
                    <div class="zdjcleft">
                        <div class="zdjctop">
                            <div class="zdjclefttop"></div>
                            <div class="zdjcleftbot">
                                <div class="zdjcleftbotleft"></div>
                                <div class="zdjcleftbotright"></div>
                            </div>
                        </div>
                        <div class="zdjcleftbottom">
                            <span>姓名<input type="text"></span><span>性别<input type="radio" name="sex" value="1" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">男<input type="radio" name="sex" value="2" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">女</span><br>
                            <span>年龄<input type="text"></span><span>付数<input type="text"></span><br>
                            <span>味数<input type="text"></span><span>频次<select name="pinci" id="pinci">
                                    <option value="1">一日一次</option>
                                    <option value="2">一日二次</option>
                                    <option value="3">一日三次</option>
                                </select></span>
                            <br>
									<span>
										用法<select name="yongfa" id="yongfa">
                                            <option value="jf">煎服</option>
                                            <option value="wf">外敷</option>
                                            <option value="nsfy">碾碎服用</option>
                                            <option value="nsfy2">碾碎分两次服用</option>
                                            <option value="sj">水煎分两次服用</option>
                                            <option value="sc">生吃</option>
                                            <option value="ps">泡水</option>
                                            <option value="wszf">温水助服</option>
                                            <option value="zjfy">直接服用</option>
                                            <option value="ksjf">开水煎服</option>
                                            <option value="pjfy">泡酒服用</option>
                                        </select>
									</span><br>
									<span>
			                         备注<textarea style="width:338px;height:83px;border-radius:5px;border: 1px solid #e3e4e4;margin-left:15px;"></textarea>
									</span>
                        </div>
                    </div>
                    <div class="zdjcright">
                        <table>
                            <tr>
                                <td><span><img src="img/自动检查(2)_03.gif" alt=""></span><span><img src="img/自动检查(2)_05.gif" alt=""></span><span><img src="img/自动检查(2)_07.gif" alt=""></span></td>
                                <td id="yname">人电放费参</td>
                                <td><input type="text" >克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td><span><img src="img/自动检查(2)_03.gif" alt=""></span><span><img src="img/自动检查(2)_05.gif" alt=""></span><span><img src="img/自动检查(2)_07.gif" alt=""></span></td>
                                <td id="yname">人电放费参</td>
                                <td><input type="text" >克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td><span><img src="img/自动检查(2)_03.gif" alt=""></span><span><img src="img/自动检查(2)_05.gif" alt=""></span><span><img src="img/自动检查(2)_07.gif" alt=""></span></td>
                                <td><input type="text" placeholder="药名" style="width:80px;color:#e3e4e4;"></td>
                                <td><input type="text" placeholder="重量"  style="width:80px;color:#e3e4e4;">克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>

                        </table>
                        <input type="button" value="通知医师再度确认禁忌超量" style="width:244px;text-align:center;height:40px;background:#f4ad59;font-size:18px;color:white;border:none;border-radius: 5px; margin-left:45px;margin-bottom:20px;">
                    </div>
                </div>
                <div class="zdjcfoot" style="display:inline;">
                    <div class="zdjcfootl" style="margin-top:600px; margin-left:300px;">
                        <input type="checkbox" style="">药方中上述警示内容已与医师确认<button id="zdjcover" onclick="showdiv();">完成</button>
                    </div>
                </div>
            </div>
            <!-- 录入2 -->
            <div class="lr2">
                <!-- 头部 -->
                <div class="header">
                    录入<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="lr2cont">
                    <div class="lr2left">
                        <div class="lr2lefttop"></div>
                        <div class="lr2leftbot">
                            <div class="lr2leftbotleft"></div>
                            <div class="lr2leftbotright"></div>
                        </div>
                    </div>
                    <div class="lr2right">
                        <h3>收件人姓名<input type="text"></h3>
                        <h3>电话&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"></h3>
                        <h3>地址<input type="text" style="margin-left:55px;height:60px;width:240px;"></h3>
                    </div>
                </div>
                <div class="lr2foot"><button id="lr2over" >完成</button></div>
            </div>
            <!-- 煎制 -->
            <div class="jz">
                <!-- 头部 -->
                <div class="header">
                    煎制<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="jzcont">
                    <div class="jznum1">
                        <h1>泡制</h1>
                        <h2>药房编号确认<span>xxxxxxxx_20160417001</span><input type="checkbox" style="float:right;margin-right:15px;"></h2>
                        <h3>泡制时间<input type="text"  style="margin-left:99px;">分钟</h3>
                    </div>
                    <div class="jznum2">
                        <h1>煎制前</h1>
                        <h2>药房编号确认<span>xxxxxxxx_20160417001</span><input type="checkbox" style="float:right; margin-right:15px;"></h2>
                        <h3>付数确认<b>14</b><input type="checkbox" style="float:right;margin-right:15px;"></h3>
                        <h3>味数确认<b>23</b><input type="checkbox" style="float:right;margin-right:15px;"></h3>
                        <h4>药物外观确认<input type="checkbox" style="float:right;margin-right:15px;"></h4>
                        <h5>用水确认<input type="text">升</h5>
                        <h5>压力确认<input type="text">帕</h5>
                        <h5>煎制时间确认<input type="text" style="margin-left:93px;">分钟</h5>
                        <h5>煎药机&nbsp;&nbsp;&nbsp;<input type="text">号</h5>
                        <h6>先煎<input type="checkbox"><i>后下</i><input type="checkbox"></h6>
                        <h5>下药时间<input type="text"></h5>
                    </div>
                    <div class="jznum3">
                        <h1>煎制后</h1>
                        <h2>药房编号确认<span>xxxxxxxx_20160417001</span><input type="checkbox" style="float:right;margin-right:15px;"></h2>
                        <h2>汤剂外观确认<input type="checkbox" style="float:right;margin-right:15px;"></h2>
                        <h3>量确认<input type="text">升/毫升</h3>
                        <h5>出药时间<input type="text"></h5>
                    </div>
                </div>
                <div class="jzfoot"><button id="jzover" type="button" value="X" >开始</button></div>
            </div>
            <!-- 药方进度2 -->
            <div class="yfjd">
                <!-- 头部 -->
                <div class="header">
                    药方进度<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
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
                        <button id="btnshow1" type="button" value="开始" onclick="showdiv();">开始</button>
                    </div>
                    <div class="shengfang">
                        <h3><b>2</b><span></span></h3>
                        <h2>审方</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                        <button id="btnshow2" type="button" value="开始" onclick="showdiv();">开始</button>
                    </div>
                    <div class="peiyao">
                        <h3><b>3</b><span></span></h3>
                        <h2>配药</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                    </div>
                    <div class="hefang">
                        <h3><b>4</b><span></span></h3>
                        <h2>核方</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>

                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                    </div>
                    <div class="fucha">
                        <h3><b>5</b><span></span></h3>
                        <h2>复查</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                        <button id="btnshow5" type="button" value="开始" onclick="showdiv();">开始</button>
                    </div>
                    <div class="jianzhi">
                        <h3><b>6</b><span></span></h3>
                        <h2>煎制</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                        <button id="btnshow6" type="button" value="开始" onclick="showdiv();">开始</button>
                    </div>
                    <div class="peisong1">
                        <h3><b>7</b></h3>
                        <h2>配送</h2>
                        <p><span>开始</span>4/17 15:34</p>
                        <p><span>结束</span>4/17 15:34</p>
                        <h1>23分</h1>
                        <h4>张彩凤</h4>
                        <a>修改</a>
                        <button id="btnshow7" type="button" value="开始" onclick="showdiv();">开始</button>
                    </div>
                </div>
            </div>
            <!-- 录入 -->
            <div class="lr">
                <!-- 头部 -->
                <div class="header">
                    录入<span><img src="img/订单详细-2_03.gif"  id="btnclose" type="button" value="X"></span>
                </div>
                <!-- 表格 -->
                <div class="table">
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="lrcont">
                    <div class="lrleft">
                        <div class="lrtop">
                            <div class="lrlefttop"></div>
                            <div class="lrleftbot">
                                <div class="lrleftbotleft"></div>
                                <div class="lrleftbotright"></div>
                            </div>
                        </div>
                        <div class="lrleftbottom">
                            <span>姓名<input type="text"></span><span>性别<input type="radio" name="sex" value="1" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">男<input type="radio" name="sex" value="2" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">女</span><br>
                            <span>年龄<input type="text"></span><span>付数<input type="text"></span><br>
                            <span>味数<input type="text"></span><span>频次<select name="pinci" id="pinci">
                                    <option value="1">一日一次</option>
                                    <option value="2">一日二次</option>
                                    <option value="3">一日三次</option>
                                </select></span>
                            <br>
									<span>
										用法<select name="yongfa" id="yongfa">
                                            <option value="jf">煎服</option>
                                            <option value="wf">外敷</option>
                                            <option value="nsfy">碾碎服用</option>
                                            <option value="nsfy2">碾碎分两次服用</option>
                                            <option value="sj">水煎分两次服用</option>
                                            <option value="sc">生吃</option>
                                            <option value="ps">泡水</option>
                                            <option value="wszf">温水助服</option>
                                            <option value="zjfy">直接服用</option>
                                            <option value="ksjf">开水煎服</option>
                                            <option value="pjfy">泡酒服用</option>
                                        </select>
									</span><br>
									<span>
			                         备注<textarea style="width:338px;height:83px;border-radius:5px;border: 1px solid #e3e4e4;margin-left:15px;"></textarea>
									</span>
                        </div>
                    </div>
                    <div class="lrright">
                        <table>
                            <tr>
                                <td id="yname">人电放费参</td>
                                <td><input type="text" >克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td id="yname">人电放费参</td>
                                <td><input type="text" >克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td><input type="text" placeholder="药名" style="width:80px;color:#e3e4e4;"></td>
                                <td><input type="text" placeholder="重量"  style="width:80px;color:#e3e4e4;">克</td>
                                <td>
                                    <select name="" id="">
                                        <option value="">先煎</option>
                                        <option value="">后下</option>
                                        <option value="">包煎</option>
                                        <option value="">烊化</option>
                                        <option value="">冲服</option>
                                    </select>
                                </td>
                                <td><img src="img/订单详细-2_03.gif" alt=""></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="lrfoot" style="display:inline;">
                    <div class="lrfootl" style="margin-top:600px; margin-left:300px;">
                        <input id="lrover" type="button" value="完成" onclick="psdshowdiv();" />
                    </div>
                </div>
                <div id="psdbg">
                </div>
                <div id="psdshow">
                    <div class="psd">
                        <p>个人密码<input type="password"></p>
                        <input id="psdover" type="button" value="完成" onclick="psdhidediv();" />
                    </div>
                </div>
            </div>
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
                    <p>药方编号<span>xxxxxxxx_20160417001</span>医馆<span>真一堂</span>医师<span>王神医</span>付数<span>13</span>味数<span>24</span>原药/代煎<span>代煎</span></p>
                </div>
                <div class="fccont">
                    <div class="fcleft">
                        <div class="fclefttop"></div>
                        <div class="fcleftbot">
                            <div class="fcleftbotleft"></div>
                            <div class="fcleftbotright"></div>
                        </div>
                    </div>
                    <div class="fcright" style="overflow:auto;">
                        <table>
                            <tr>
                                <td id="yname">人电放费参</td>
                                <td>9克</td>
                                <td>
                                    <input type="checkbox">
                                </td>
                            </tr>
                            <tr>
                                <td id="yname">人电放费参</td>
                                <td>9克</td>
                                <td>
                                    <input type="checkbox">
                                </td>
                            </tr>
                            <tr>
                                <td id="yname">人电放费参</td>
                                <td>9克</td>
                                <td>
                                    <input type="checkbox">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <input type="button" value="发现差错 重新配药" id="again">
                <input type="checkbox" name="">已经与抓药师确认重新配药
                <input type="button" value="完成" id="fcover">
            </div>
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

<script src="js/jquery1.8.js"></script>
<script src="js/shouye.js"></script>
<script language="javascript" src="js/jquery-1.6.2.js"></script>
<script language="javascript" src="js/jquery.jqprint-0.3.js"></script>
<script language="javascript" src="js/jquery1-8-0.js"></script>
<div id="aaa"></div>
<script src='http://cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>

<script>
    // 连接服务端
    var socket = io('http://workerman.net:2120');
    // uid可以是自己网站的用户id，以便针对uid推送以及统计在线人数
    uid =5768999;
    // socket连接后以uid登录
    socket.on('connect', function(){
        socket.emit('login', uid);
    });
    // 后端推送来消息时
    socket.on('new_msg', function(msg){
        alert(msg)


    });
    // 后端推送来在线数据时
    socket.on('update_online_count', function(online_stat){
        console.log(online_stat);
    });
</script>
<!--流程-->
<script>
    $(document).on("click",".status",function(){
        status=$(this).attr("value")
        alert(status)
    })
</script>
<!--搜索匹配数据-->
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





