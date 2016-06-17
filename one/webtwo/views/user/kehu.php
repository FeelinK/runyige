
    <div class="khxx">
        <header>客户管理<span id="btnclose" ><img src="img/订单详细-2_03.gif" alt="" onclick="hidediv()"></span></header>
        <div class="zhuti">
            <div class="left">
                <h3>基本信息</h3>
                <?php if(!empty($arr)){?>
                <p><span>客户名称</span><b><?php echo $arr['hospital_name']?></b></p>
                <p><span>客户地址</span><b><?php echo $arr['address']?></b></p>
                <p><span>主账号</span><b><?php echo $arr['doctor_phone']?></b></p>
                <p><span>联系人</span><b><?php echo $arr['doctor_name']?></b></p>
                <p><span>联系电话</span><b><?php echo $arr['doctor_phone']?></b></p>
                <p><span>服务开始日期</span><b><?php echo substr($arr['created_at'],0,10)?></b></p>
            </div>
            <div class="zhong">
                <h3>医师信息</h3>
                <ul style="height:auto;">
                    <li>医师姓名</li>
                    <li>加入时间</li>
                    <li>账号</li>
                    <li>最后使用</li>
                </ul>
                <div class="scroll" style="width:500px;overflow-y:scroll;">
                    <table>
                        <?php foreach($arr['brr'] as $k=>$v){?>
                        <tr>

                            <td><?php echo $v['doctor_name']?></td>
                            <td><?php echo substr($v['created_at'],0,10)?></td>
                            <td><?php echo $v['doctor_phone']?></td>
                            <td><?php echo substr($v['updated_at'],0,10)?></td>

                        </tr>
                        <?php }?>
                    </table>

                </div>
            </div>
            <div class="right">
                <h3>管理设置</h3>
                <ul>
                    <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
                    <li style="line-height:35px;font-size:17px;list-style-image:url(img/客户管理_03.gif)">分成<span>医馆分成比例</span><b><?php echo $arr['profit_margine']?>%</b></li>
                    <li style="margin-left: 125px;color:#ccc;">结算日<span><?php echo $arr['clearing_date']?></span></li>


                </ul>
                <?php }else{?>
                暂无数据
                <?php }?>
            </div>