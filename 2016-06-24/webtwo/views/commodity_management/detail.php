<div class="yaopin-r">
<div class="yaopin-r-1">
    <a><span id="delete"><img src="img/rubbsh_07.jpg" class="delmedicine" alt=""></span>基本信息<b ><img src="img/xiugai_07.jpg" alt="" id="jbxx" class="upone"></b></a>
    <p><span>药材名称</span><b><?php echo $arr['medicine_name']?></b></p>
    <p><span>药材别称</span><b><?php echo $arr['medicine_nickname']?></b></p>
    <p><span>大分类</span><b><?php echo $arr['maxtypename']?></b></p>
    <p><span>小分类</span><b><?php echo $arr['mintypename']?></b></p>
    <p><span>产地</span><b><?php echo $arr['production_place']?></b></p>
    <p><span>生产日期</span><b><?php echo $arr['production_date']?></b></p>
    <p><span>生产批号</span><b><?php echo $arr['lot_number']?></b></p>
    <p><span>进货日期</span><b><?php echo $arr['purchase_date']?></b></p>
    <p><span>质量等级</span><b><?php echo $arr['quanlity_grade']?></b></p>
    <p><span>备注</span><b><?php echo $arr['notes']?></b></p>
</div>
<div class="yaopin-r-2" >
    <a>价格设定<b ><img src="img/xiugai_07.jpg" alt="" id="jgsd" class="uptwo"></b></a>
    <p><span>进货价格（元/kg）</span><b><?php echo $arr['purchase_price']?></b></p>
    <p><span>成本价格（元/kg）</span><b><?php echo $arr['cost_price']?></b></p>
    <p><span>推荐销售价格价格（元/kg）</span><b><?php echo $arr['sale_price']?></b></p>
</div>
<div class="yaopin-r-3">
    <a>供应商<b><img src="img/xiugai_07.jpg" alt="" id="gys" class="upthree"></b></a>
    <p><?php echo $arr['supplier_name']?></p>
</div>
</div>
<script>
    /*基本信息编辑显示遮罩层*/
    $("#jbxx").on("click",function(){
        $("#bg1").show();
        $("#show-jbxx").show();
    })
    $("#close-jbxx").on("click",function(){
        $("#bg1").hide();
        $("#show-jbxx").hide();
    })
    /*价格设定编辑显示遮罩层*/
    $("#jgsd").on("click",function(){
        $("#bg1").show();
        $("#show-bj").show();
    })
    $("#close-bj").on("click",function(){
        $("#bg1").hide();
        $("#show-bj").hide();
    })
    /*供应商编辑显示遮罩层*/
    $("#gys").on("click",function(){
        $("#bg1").show();
        $("#show-gys").show();
    })
    $("#close-gys").on("click",function(){
        $("#bg1").hide();
        $("#show-gys").hide();
    })
    $("#all").on("click",function(){
        $("#bg1").show();
        $("#show-sc").show();
    })
    $("#close-sc").on("click",function(){
        $("#bg1").hide();
        $("#show-sc").hide();
    })
    $(".delete").on("click",function(){
        $(this).parent().remove();
    })
</script>






