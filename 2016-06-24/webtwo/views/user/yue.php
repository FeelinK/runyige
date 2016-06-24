<div class="ll">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>客户页</title>
    <link rel="stylesheet" href="css/user-ribie.css">
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
            <li><a href="#">订单</a></li>
            <li><a href="user-yuebie.html">客户</a></li>
            <li><a href="#"></a>设置</li>
        </ul>
    </header>
    <!-- 客户 -->
    <div class="user">
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
            <div class="qiehuan">
                <div class="use">
                    <div class="search" >
                        <b><img src="img/订单_06.gif" alt=""></b><input type="text" placeholder="客户名称"  alt="" id="text" class="qq">
                        <input type="button" value="搜索" id="search" class="searchtwo">


                        <a  href="index.php?r=user/index" class="yd" id="pp"> 日别</a>






                    </div>
                    <div class="footer" style="display:none;">
                        <div class="f-top">
                            <a href="index.php?r=user/index" class="all">全部</a>
                            <a href="">A-D</a>
                            <a href="">E-G</a>
                            <a href="">H-K</a>
                            <a href="">L-Q</a>
                            <a href="">R-T</a>
                            <a href="">U-W</a>
                            <a href="">X-Y</a>
                            <a href="">其它</a>
                            <b class="f-top-y">日期</b>
                            <select name="yg" id="yg" value="博亿堂">
                                <option value="">2016/04/17</option>
                                <option value="">2055/11/21</option>
                            </select>
                            <p class="username">客户信息</p>
                            <input type="button" value="下载" id="xiazai">
                            <input type="button" value="打印" id="print">
                        </div>
                        <div class="f-bottom" >
                            <div class="f-left">
                                <h3 style="color:black">博亿堂<span style="background:#779800">9</span></h3>
                                <h3>圣医馆<span>3</span></h3>
                                <h3>益民中医堂<span>12</span></h3>
                                <h3>圣医馆<span>13</span></h3>
                                <h3>圣医馆<span>23</span></h3>
                                <h3>圣医馆<span>23</span></h3>
                            </div>
                            <div class="f-right" style="width:86.5%;">
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
                                        <td>医师</td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="" id="btnshow" onclick="showdiv();">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                </table>
                                <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                            </div>
                            <div class="heji"><h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2></div>
                        </div>
                    </div>
                    <div class="khjs" style="display:none;">
                        <div class="footer">
                            <div class="f-bottom">
                                <div class="f-right">
                                    <div class="f-head">
                                        <p style="display:inline-block;float:left;"><img src="img/订单检索_03.gif" alt=""><span>返回</span></p>
                                        <b class="f-top-y">日期</b>
                                        <select name="yg" id="yg" value="2016/04/17">
                                            <option value="">2016/04/17</option>
                                            <option value="">2055/11/21</option>
                                        </select>
                                        <b class="username" style="display:inline-block;">客户信息</b>
                                        <input type="button" value="下载" id="xiazai">
                                        <input type="button" value="打印" id="print">
                                    </div>
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
                                            <td>医师</td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="" id="btnshow" onclick="showdiv();">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                    </table>
                                    <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                    <div class="khjs-2"   style="margin-top:100px; display:none;">
                        <div class="footer">
                            <div class="f-bottom">
                                <div class="f-right">
                                    <div class="f-head">
                                        <p style="display:inline-block;float:left;"><img src="img/订单检索_03.gif" alt=""><span>返回</span></p>
                                        <b class="f-top-y">日期</b>
                                        <select name="yg" id="yg" value="2016/04/17">
                                            <option value="">2016/04/17</option>
                                            <option value="">2055/11/21</option>
                                        </select>
                                        <b class="username" style="display:inline-block;">客户信息</b>
                                        <input type="button" value="下载" id="xiazai">
                                        <input type="button" value="打印" id="print">
                                    </div>
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>医师</td>
                                            <td>药方编号</td>
                                            <td>付数</td>
                                            <td>味数</td>
                                            <td>金额</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                    </table>
                                    <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                    <div class="footer-2" style="display:none;">
                        <div class="footer">
                            <div class="f-top">
                                <a href="" class="all">全部</a>
                                <a href="">A-D</a>
                                <a href="">E-G</a>
                                <a href="">H-K</a>
                                <a href="">L-Q</a>
                                <a href="">R-T</a>
                                <a href="">U-W</a>
                                <a href="">X-Y</a>
                                <a href="">其它</a>
                                <b class="f-top-y">日期</b>
                                <select name="yg" id="yg" value="博亿堂">
                                    <option value="">2016/04/17</option>
                                    <option value="">2055/11/21</option>
                                </select>
                                <p class="username">客户信息</p>
                                <input type="button" value="下载" id="xiazai">
                                <input type="button" value="打印" id="print">
                            </div>
                            <div class="f-bottom">
                                <div class="f-left">
                                    <h3 style="color:black">博亿堂<span style="background:#779800">9</span></h3>
                                    <h3>圣医馆<span>3</span></h3>
                                    <h3>益民中医堂<span>12</span></h3>
                                    <h3>圣医馆<span>13</span></h3>
                                    <h3>圣医馆<span>23</span></h3>
                                    <h3>圣医馆<span>23</span></h3>
                                </div>
                                <div class="f-right" style="width:86.5%;">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>医师</td>
                                            <td>药方编号</td>
                                            <td>付数</td>
                                            <td>味数</td>
                                            <td>金额</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                    </table>
                                    <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                </div>
                <div class="doctor">
                    <div class="search" style="margin-top:100px; display:none;">
                        <b><img src="img/订单_06.gif" alt=""></b><input type="text" placeholder="客户名称"  alt="" id="text">
                        <input type="button" value="搜索" id="search">
                        <a href="" class="yd">月度别</a>
                    </div>
                    <div class="footer" style="margin-top:100px; display:none;">
                        <div class="f-top">
                            <a href="" class="all">全部</a>
                            <a href="">A-D</a>
                            <a href="">E-G</a>
                            <a href="">H-K</a>
                            <a href="">L-Q</a>
                            <a href="">R-T</a>
                            <a href="">U-W</a>
                            <a href="">X-Y</a>
                            <a href="">其它</a>
                            <b class="f-top-y">日期</b>
                            <select name="yg" id="yg" value="博亿堂">
                                <option value="">2016/04/17</option>
                                <option value="">2055/11/21</option>
                            </select>
                            <p class="username">医师信息</p>
                            <input type="button" value="下载" id="xiazai">
                            <input type="button" value="打印" id="print">
                        </div>
                        <div class="f-bottom">
                            <div class="f-left">
                                <h3 style="color:black">博亿堂<span style="background:#779800">9</span></h3>
                                <h3>圣医馆<span>3</span></h3>
                                <h3>益民中医堂<span>12</span></h3>
                                <h3>圣医馆<span>13</span></h3>
                                <h3>圣医馆<span>23</span></h3>
                                <h3>圣医馆<span>23</span></h3>
                            </div>
                            <div class="f-right" style="width:86.5%;">
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
                                        <td>医师</td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="" id="btnshow" onclick="showdiv();">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                    <tr>
                                        <td>xxxxxxxx_20160417001</td>
                                        <td>王神医</td>
                                        <td>7</td>
                                        <td>5</td>
                                        <td>备注</td>
                                        <td>原药</td>
                                        <td>录入</td>
                                        <td>999.9</td>
                                        <td><a href="">医师数据</a></td>
                                    </tr>
                                </table>
                                <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                            </div>
                        </div>
                        <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                    </div>
                    <div class="khjs" style="display:none;">
                        <div class="footer">
                            <div class="f-bottom">
                                <div class="f-right">
                                    <div class="f-head">
                                        <p style="display:inline-block;float:left;"><img src="img/订单检索_03.gif" alt=""><span>返回</span></p>
                                        <b class="f-top-y">日期</b>
                                        <select name="yg" id="yg" value="2016/04/17">
                                            <option value="">2016/04/17</option>
                                            <option value="">2055/11/21</option>
                                        </select>
                                        <b class="username" style="display:inline-block;">客户信息</b>
                                        <input type="button" value="下载" id="xiazai">
                                        <input type="button" value="打印" id="print">
                                    </div>
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
                                            <td>医师</td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="" id="btnshow" onclick="showdiv();">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                        <tr>
                                            <td>xxxxxxxx_20160417001</td>
                                            <td>王神医</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>备注</td>
                                            <td>原药</td>
                                            <td>录入</td>
                                            <td>999.9</td>
                                            <td><a href="">医师数据</a></td>
                                        </tr>
                                    </table>
                                    <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                    <div class="khjs-2"  style="margin-top:100px; display:none;">
                        <div class="footer">
                            <div class="f-bottom">
                                <div class="f-right">
                                    <div class="f-head">
                                        <p style="display:inline-block;float:left;"><img src="img/订单检索_03.gif" alt=""><span>返回</span></p>
                                        <b class="f-top-y">日期</b>
                                        <select name="yg" id="yg" value="2016/04/17">
                                            <option value="">2016/04/17</option>
                                            <option value="">2055/11/21</option>
                                        </select>
                                        <b class="username" style="display:inline-block;">客户信息</b>
                                        <input type="button" value="下载" id="xiazai">
                                        <input type="button" value="打印" id="print">
                                    </div>
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>医师</td>
                                            <td>药方编号</td>
                                            <td>付数</td>
                                            <td>味数</td>
                                            <td>金额</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>5</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>999.9</td>
                                        </tr>
                                    </table>
                                    <h1><a href=""><</a><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><a href="">></a></h1>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                    <div class="footer-2">
                        <div class="footer">
                            <div class="f-top">
                                <a href="#" value="A-Y" class="firstletter">全部</a>
                                <a href="#" class="firstletter" value="A-D">A-D</a>
                                <a  href="#" class="firstletter" value="E-H">E-H</a>
                                <a href="#" class="firstletter" value="I-L">I-L</a>
                                <a  href="#" class="firstletter" value="M-P">M-P</a>
                                <a  href="#" class="firstletter" value="Q-T">Q-T</a>
                                <a href="#" class="firstletter"  value="U-W">U-W</a>
                                <a href="#"  class="firstletter" value="X-Y">X-Y</a>
                                <b class="f-top-y"><input type="button"  value="日期筛选" class="datevalue"></b>
                                <input type="hidden" value="<?php echo $hospital_name?>" class="five" >
                                <input type="text" id="J-xl"  >
                                <p  class="username" style="display:inline-block;"  id="btnshow" onclick="showdiv();">客户信息</p>
                                <input type="hidden" class="kehu">
                                <a href="index.php?r=user/downyuedu" id="xiazai" style="text-align: center;margin-top:15px;margin-left:100px;">下载</a>
                                <input type="button" value="打印" id="print">
                            </div>
                            <div class="f-bottom">
                                <div class="f-left">
                                    <?php foreach($frr as $k=>$v){?>
                                        <h3 class="hospital_name" value="<?php echo $v['hospital_name']?>"><?php echo $v['hospital_name']?><span><?php echo $v['count(hospital_name)']?></span></h3>
                                    <?php }?>
                                </div>
                                <div class="f-right" style="width:86.5%;">
                                    <div class="list">
                                        <?php if(!empty($drr)){?>
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>药方id</td>
                                                    <td>医师</td>

                                                    <td>付数</td>
                                                    <td>味数</td>


                                                    <td>金额</td>

                                                </tr>
                                                <?php foreach($drr as $k=>$v){?>
                                                    <tr>
                                                        <td><?php echo $v['prescription_id']?></td>
                                                        <td><?php echo $v['doctor_name']?></td>

                                                        <td><?php echo $v['piece']?></td>
                                                        <td><?php echo $v['kinds_per_piece']?></td>



                                                        </td>
                                                        <td><?php echo $v['price']?></td>

                                                    </tr>
                                                <?php }?>
                                            </table>
                                            <h1><
                                                <?php for($i=1;$i<=$quzheng;$i++){?>
                                                    <a href="index.php?r=user/yue&page=<?php echo $i?>&hospital_name=<?php echo $hospital_name?>&patient_name=<?php echo $patient_name?>&datetime=<?php echo $datetime?>&yd=yd&firstletter=<?php echo $firstletter?>"><?php echo $i?></a>

                                                <?php }?>
                                                >
                                            </h1>
                                        <?php }else{?>

                                            <h1>今日暂无数据</h1>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <h2><b>合计：</b><i>13品种</i><i>160斤</i><i>12.652元</i></h2>
                        </div>
                    </div>
                </div>
                <!--客户信息开始-->
                <div id="bg">
                </div>
                <div id="show">
                    <div class="khxx">
                        <header>客户管理<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span></header>
                        <div class="zhuti">
                            <div class="left">
                                <h3>基本信息</h3>
                                <p><span>客户名称</span><b>圣医堂</b></p>
                                <p><span>客户地址</span><b>北京市海淀区北清路13号102</b></p>
                                <p><span>主账号</span><b>13521536284</b></p>
                                <p><span>联系人</span><b>张胜利</b></p>
                                <p><span>联系电话</span><b>12388394028</b></p>
                                <p><span>服务开始日期</span><b>2016/04/14</b></p>
                                <p><span>备注</span><b>名医馆</b></p>
                            </div>
                            <div class="zhong">
                                <h3>医师信息</h3>
                                <ul>
                                    <li>医师姓名</li>
                                    <li>加入时间</li>
                                    <li>账号</li>
                                    <li>最后使用</li>
                                </ul>
                                <div class="scroll" style="width:500px;height:410px;overflow-y:scroll;">
                                    <table>
                                        <tr>
                                            <td>王神医地方</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                        <tr>
                                            <td>王神医</td>
                                            <td>2016/04/07</td>
                                            <td>13141234481</td>
                                            <td>2016/04/17</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="right">
                                <h3>管理设置</h3>
                                <ul>
                                    <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
                                    <li style="line-height:35px;font-size:17px;list-style-image:url(img/客户管理_03.gif)">分成<span>医馆分成比例</span><b>50%</b></li>
                                    <li style="line-height:35px;font-size:17px;list-style-image:url(img/客户管理_03.gif)">合约价<span>加价成比例</span><b>20%</b></li>
                                    <li style="margin-left: 125px;color:#ccc;">结算日<span>当月月底</span></li>
                                    <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">药材等级</li>
                                    <li>药材等级<span>一级</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--客户信息结束-->
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
<!--根据医馆名称匹配出当天的医师的一些信息-->
<script>
    $(document).on("click",".hospital_name",function(){
        hospital_name=$(this).attr("value")
        $(".kehu").html(hospital_name)

        $.ajax({
            url:'index.php?r=user/one',
            type:'get',
            data:'hospital_name='+hospital_name,
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
        date=$("#J-xl").val()
        if(date==""){
            alert("请选择日期")
        }else{
            $.ajax({
                url:'index.php?r=user/one',
                type:'get',
                data:'datetime='+date,
                success:function(data){
                    $(".list").html(data)
                }
            })
        }
    })

</script>
<!--根据客户名称进行搜索-->
<script>
    $(document).on("click",".searchtwo",function(){
        patient_name=$("#text").val()
        $.ajax({
            url:'index.php?r=user/one',
            type:'get',
            data:'patient_name='+patient_name,
            success:function(data){
                $(".list").html(data)
            }
        })

    })
</script>
<!--月度别-->
<script>
    $(document).on("click",".yd",function(){
        $.ajax({
            url:'index.php?r=user/one',
            type:'get',
            data:'yd=yd',
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>
<!--客户信息-->
<script>
    $(document).on("click","#btnshow",function(){
        kehu=$(".kehu").html()
        if(kehu==""){
            kehu="太医馆"
        }
        $.ajax({
            url:'index.php?r=user/kehu',
            type:'get',
            data:'hospital_name='+kehu,
            success:function(data){
                $(".khxx").html(data)
            }
        })
    })
</script>
<!--根据英文字母匹配数据-->
<script>
    $(document).on("click",".firstletter",function(){
        firstletter=$(this).attr("value")
        $.ajax({
            url:'index.php?r=user/yue',
            type:'get',
            data:'firstletter='+firstletter,
            success:function(data){
                $(".ll").html(data)
            }
        })
    })
</script>
