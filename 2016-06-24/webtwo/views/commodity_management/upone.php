
<h3>基本信息</h3>
<ul>
    <li><span>药材名称</span><input type="text"></li>

    <li><span>生产日期</span><input type="text" id="J-x3"></li>
    <li><span>药材别称</span><input type="text"></li>
    <li><span>生产批号</span><input type="text"></li>
    <li><span>大分类</span>
        <select class="upmaxtype">
            <option selected="selected">请选择</option>
            <?php foreach($brr as $k=>$v){?>
                <option value="<?php echo $v['category']?>"><?php echo $v['category_name']?></option>
            <?php }?>
        </select>
    </li>
    <li><span>进货日期</span><input type="text" id="J-x4"></li>

    <li><span>小分类</span>
        <select class="upmintype">
            <option value="">请选择</option>
        </select>
    </li>

    <li><span>质量等级</span><select name="" id="">
            <option value="合格">合格</option>
            <option value="优">优</option>
            <option value="良">良</option>
        </select></li>
    <li><span>国标顺序号</span><input type="text"></li>
    <li><span>药材id</span><input type="text"></li>
    <li><span>支号码</span><input type="text"/></li>
    <li><span>国标码</span><input type="text"/></li>
    <li><span>用量下限</span><input type="text"/></li>
    <li><span>用量上限</span><input type="text"/></li>
    <li><span>药箱位置</span><input type="text"/></li>
    <li><span>注释</span><input type="text"/></li>
    <li><span>产地</span><input type="text"/></li>
</ul>
<div class="footer">
    <input type="button" value="保存" id="baocun">
</div>
</div>
!--日历插件-->
<script type="text/javascript" src="js/laydate.dev.js"></script>
<script type="text/javascript">
    laydate({
        elem: '#J-x3'

    });
    laydate({
        elem: '#J-x4'

    });

</script>


