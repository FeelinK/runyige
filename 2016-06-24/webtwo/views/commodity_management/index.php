<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>药品管理</title>
    <link rel="stylesheet" href="css/yaopin.css">
    <!--引入日历插件的css样式-->
    <link rel="stylesheet" href="date/need/laydate.css">
    <link rel="stylesheet" href="date/skins/default/laydate.css">
</head>
<body>
<div class="yaopin">

    <header class="header">
        <div class="logo">
            <img src="img/订单_02.png" alt="">
        </div>
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;中央药房</p>
        <ul>
            <a href="index.php?r=center/index"><li>订单</li></a>
            <a href="index.php?r=user/index"><li>客户</li></a>
            <a href="index.php?r=setup/index"><li>设置</li></a>
        </ul>
    </header>

    <div class="container">
        <h1><a href="shezhi.html"><b><img src="img/back_03.jpg" alt=""></b>设置 > 药材管理</a><i><img src="img/add_07.jpg" alt="" id="all" ></i></h1>
        <div class="search">
            <b><img src="img/订单_06.jpg" alt=""></b><input type="text" class="medicine_name" placeholder="药材名称"  alt="">
            <input type="button" value="搜索" class="searchmedicine_name">
        </div>
        <input type="hidden" class="medicine_idone">
        <!--一级-->
        <div class="yaopincont">
            <div class="lanren">
                <ul class="nav1">
                    <?php foreach($arr as $k=>$v){?>
                    <li class="li1" value="<?php echo $v['category']?>"><a href="#"><?php echo $v['category_name']?></a>
                        <?php }?>

                    </li>
                </ul>
            </div>


<!--二级-->
            <div class="yaopincont" style="padding-left: 100px;">
                <div class="lanren">
                    <ul class="nav1" style="display: none" id="two">

                        <li class="li2" value=""><a href="#">二级</a></li>



                    </ul>
                </div>


<!--三级-->
                <div class="yaopincont" style="padding-left: 100px;" ">
                    <div class="lanren">
                        <ul class="nav1" style="display: none" id="three">
                            <li class="li3" value=""><a href="#">三级</a>


                            </li>
                        </ul>
                    </div>


            <div class="list">
            <div class="yaopin-r">
                <div class="yaopin-r-1">
                    <a><span id="delete"><img src="img/rubbsh_07.jpg" alt=""></span>基本信息<b ><img src="img/xiugai_07.jpg" alt="" id="jbxx" class="upone"></b></a>
                    <p><span>药材名称</span><b>地方地方</b></p>
                    <p><span>药材别称</span><b>地方地方</b></p>
                    <p><span>大分类</span><b>发个是</b></p>
                    <p><span>小分类</span><b>地方是</b></p>
                    <p><span>产地</span><b>我个付</b></p>
                    <p><span>生产日期</span><b>从v是的</b></p>
                    <p><span>生产批号</span><b>地方的</b></p>
                    <p><span>进货日期</span><b>额地方</b></p>
                    <p><span>质量等级</span><b>的方式</b></p>
                    <p><span>备注</span><b>水电费</b></p>
                </div>
                <div class="yaopin-r-2">
                    <a>价格设定<b ><img src="img/xiugai_07.jpg" alt="" id="jgsd" class="uptwo"></b></a>
                    <p><span>进货价格（元/kg）</span><b>290</b></p>
                    <p><span>成本价格（元/kg）</span><b>310<br>+6.9%</b></p>
                    <p><span>推荐销售价格价格（元/kg）</span><b>372<br>+20%</b></p>
                </div>
                <div class="yaopin-r-3">
                    <a>供应商<b><img src="img/xiugai_07.jpg" alt="" id="gys" class="upthree"></b></a>
                    <p>北京中药佳商贸有限公司</p>
                </div>
            </div>
                </div>
        </div>
    </div>
    <div id="bg1"></div>
    <div id="show-sc">
        <div class="ycgl-sc">
            <div class="header">药材管理--生成<span><img src="img/订单详细-2_03.gif" alt="" style="float:right;" id="close-sc"></span>
            </div>
            <div class="ycgl-sc-content">
                <div class="sc-l">
                    <h3>基本信息</h3>

                    <p>
                        <input type="hidden" class="addimg">
                    <form enctype="multipart/form-data" method='post' >

                        <input name='a' type='file' id='ajax'>
                    </form>
                    </p>
                    <p class="aa" ></p>

                    <p><span>药材名称</span><b><input type="text"  class="medicine_name"></b></p>
                    <p><span>药材别称</span><b><input type="text"  class="medicine_nickname"></b></p>
                    <p>
                        <span>大分类</span>
                        <b>
                            <select class="maxtype">
                                <option selected="selected">请选择</option>
                                <?php foreach($arr as $k=>$v){?>
                                <option value="<?php echo $v['category']?>"><?php echo $v['category_name']?></option>
                              <?php }?>
                            </select>
                        </b>
                    </p>
                    <p>
                        <span>小分类</span>
                        <b>
                            <select class="mintype">
                                <option value="">请选择</option>
                            </select>
                        </b>
                    </p>
                    <p><span>产地</span><b><input type="text" class="production_place"></b></p>
                    <p><span>生产日期</span><b><input type="text"  class="production_date" id="J-xl"></b></p>
                    <p><span>生产批号</span><b><input type="text"  class="lot_number" ></b></p>
                    <p><span>进货日期</span><b><input type="text"  class="purchase_date" id="J-x2"></b></p>
                    <p>
                        <span>质量等级</span>
                        <b>
                            <select class="quanlity_grade">
                                <option value="">请选择</option>
                                <option value="合格">合格</option>
                                <option value="优">优</option>
                                <option value="良">良</option>
                            </select>
                        </b>
                    </p>
                    <p><span>备注</span><b><input type="text" placeholder="备注" class="notes"></b></p>
                </div>
                <div class="sc-z" >
                    <h3>价格设定</h3>

                    <p><span>进货价格（元/kg）</span><input type="text" class="purchase_price"></p>
                    <p><span>成本价格（元/kg）</span><input type="text" class="cost_price">310.00</p>
                    <p><span>推荐销售价格（元/kg）</span><input type="text" class="sale_price">372.00</p>

                    <p><span>国标顺序号</span><b><input type="text"  class="frequence_code"></b></p>
                    <p><span>药材id</span><b><input type="text"  class="medicine_id"></b></p>
                    <p><span>支号码</span><b><input type="text"  class="sub_code"></b></p>
                    <p><span>国际码</span><b><input type="text"  class="gb_code"></b></p>
                    <p><span>用量上限</span><b><input type="text"  class="max"></b></p>
                    <p><span>用量下限</span><b><input type="text"  class="min"></b></p>
                    <p><span>成本率</span><b><input type="text"  class="cost_rate"></b></p>
                    <p><span>利润率</span><b><input type="text"  class="profit_rate"></b></p>
                    <p><span>药箱位置</span><b><input type="text"  class="drawer_location"></b></p>

                </div>
                <div class="sc-r">
                    <h3>供应商</h3>
                    <?php foreach($supplier as $k=>$v){?>
                    <p><?php echo $v['supplier_name']?><input type="radio" name="aa" value="<?php echo $v['supplier_id']?>"   class="supplier_id"></p>
                  <?php }?>
                </div>
            </div>
            <button class="addmedicine">完成</button>
        </div>
    </div>
    <div id="show-gys">
        <div class="ycgl-gys">
            <div class="header">药材管理--编辑<span><img src="img/订单详细-2_03.gif" alt="" style="float:right;margin-left:60px;" id="close-gys"></span></div>
            <div class="content">
                <h3>供应商</h3>
                <p><span>北京中药佳商贸有限公司</span><input type="checkbox"></p>
                <p><span>百草堂药材公司</span><input type="checkbox"></p>
                <p><span>北京中药佳商贸有限公司</span><input type="checkbox"></p>
                <p><span>百草堂药材公司</span><input type="checkbox"></p>
            </div>
        </div>
    </div>
    <div id="show-jbxx">
        <div class="ycgl-jbxx">
            <div class="header">药材管理--编辑<span><img src="img/订单详细-2_03.gif" alt="" style="float:right;margin-left:60px;" id="close-jbxx"></span></div>
            <div class="content">
                <div class="listtwo">
                <h3>基本信息</h3>
                <ul>
                    <li><span>药材名称</span><input type="text"></li>
                    <li><span>生产日期</span><input type="text"></li>
                    <li><span>药材别称</span><input type="text"></li>
                    <li><span>生产批号</span><input type="text"></li>
                    <li><span>大分类</span><select name="" id="">
                            <option value="">清热药</option>
                            <option value="">去表药</option>
                            <option value="">下火药</option>
                        </select></li>
                    <li><span>进货日期</span><input type="text"></li>
                    <li><span>小分类</span><select name="" id="">
                            <option value="">清热药</option>
                            <option value="">去表药</option>
                            <option value="">下火药</option>
                        </select></li>
                    <li><span>质量等级</span><select name="" id="">
                            <option value="">一级</option>
                            <option value="">二级</option>
                            <option value="">三级</option>
                        </select></li>
                    <li><span>产地</span><input type="text"></li>
                    <li><span>备注</span><input type="text"></li>
                </ul>
                <div class="footer">
                    <input type="button" value="保存" id="baocun">
                </div>
                    </div>
            </div>
        </div>
    </div>
    <div id="show-bj">
        <div class="ycgl-bj">
            <h3>药材管理--编辑<b ><img src="img/close.jpg" alt="" id="close-bj" style="margin-left:60px;"></b></h3>
            <div class="ycgl-bj-cont">
                <h2>价格</h2>
                <h4>
                    <b>供应商名称</b>
                    <label>
                        <select name="" id="">
                            <option value="">什么名字</option>
                            <option value="">什么名字</option>
                            <option value="">什么名字</option>
                        </select>
                    </label>
                </h4>
                <h4><b>供应商地址</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
                <h4><b>供应商联系人</b><label><input type="text" placeholder="北京大致医药公司"></label>304</h4>
                <h4><b>联系电话</b><label><input type="text" placeholder="北京大致医药公司"></label>232</h4>
                <button id="baocun">保存</button>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery1.8.js"></script>
<script src="js/index.js"></script>
<script src="js/shouye.js"></script>
</body>
</html>
<!--鼠标放上去触发-->
<script>
    $(document).on("click",".li1",function(){
        $(this).css("background","#779800").siblings().css("background","white");

        category=$(this).attr("value")
        $.ajax({
            url:'index.php?r=commodity_management/litwo',
            type:'get',
            dataType:'json',
            data:'category='+category,
            success:function(data){
                str='';
                for(i in data){

                    str+="<li class='li2' value='"+data[i]['category']+"'><a href='#'>"+data[i]['category_name']+"</a></li>";
                }

               $("#two").html(str)
                $("#two").show()

            }
        })
    })
</script>

<!---三级分类-->
<script>
    $(document).on("click",".li2",function(){
        $(this).css("background","#779800").siblings().css("background","white");
        category=$(this).attr("value")
        $.ajax({
            url:'index.php?r=commodity_management/lithree',
            type:'get',
            data:'category='+category,
            dataType:'json',
            success:function(data){
                str='';
                for(i in data){

                    str+="<li class='li3' value='"+data[i]['medicine_id']+"'><a href='#'>"+data[i]['medicine_name']+"</a></li>";
                }
                $("#three").html(str)
                $("#two").show()
                $("#three").show()

            }
        })
    })
</script>
<!--点击药材出详情-->
<script>
    $(document).on("click",".li3",function(){
        $(this).css("background","#779800").siblings().css("background","white");
        category=$(this).attr("value")
        $(".medicine_idone").html(category)
        $.ajax({
            url:'index.php?r=commodity_management/detail',
            type:'get',
            data:'medicine_id='+category,
            success:function(data){
                $(".list").html(data)
            }
        })
    })
</script>

<!---添加药材-->
<script>
    $(document).on("change",".maxtype",function(){
        category=$(this).attr("value")
        $.ajax({
            url:'index.php?r=commodity_management/litwo',
            type:'get',
            dataType:'json',
            data:'category='+category,
            success:function(data){
                str="";
                str+="<select class='mintype'>";
                for(i in data){
                    str+="<option value='"+data[i]['category']+"'>"+data[i]['category_name']+"</option>";
                }
                str+="</select>";
                $(".mintype").html(str)
            }
        })
    })
</script>
<!--ajax显示图片-->
<script>
    $('#ajax').change(function(){
        var formData = new FormData($( "form" )[0]);
        $.ajax({
            url:'index.php?r=staff_management/uploadtwo',
            type:'post',
            data:formData,
            //data:$('form').serialize(),
            //contentType:'multipart/form-data',
            contentType: false,
            processData: false,
            success:function(res){
                //alert(res)
                if(res==1){

                    alert("该文件太大,请选择正确的文件")
                }
                else{
                    var we='60px'
                    var he='60px'
                    $(".addimg").val(res)
                    $(".aa").html('<img src="http://o7eryb4fl.bkt.clouddn.com/'+res+'" weight="'+we+'" height="'+he+'">')
                }
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
    laydate({
        elem: '#J-x2'

    });

    </script>
<!--添加药材-->
<script>
    $(document).on("click",".addmedicine",function(){
        medicine_name=$(".medicine_name").val()
        medicine_nickname=$(".medicine_nickname").val()
        photo=$(".addimg").attr("value")
        category1=$(".maxtype").attr("value")
        category2=$(".mintype").attr("value")
        production_place=$(".production_place").val()
        production_date=$(".production_date").val()
        lot_number=$(".lot_number").val()
        purchase_date=$(".purchase_date").val()
        quanlity_grade=$(".quanlity_grade").attr("value")
        notes=$(".notes").val()
        purchase_price=$(".purchase_price").val()
        cost_price=$(".cost_price").val()
        sale_price=$(".sale_price").val()
        supplier_id=$(".supplier_id:checked").attr("value")

        frequence_code=$(".frequence_code").val()
        medicine_id=$(".medicine_id").val()
        sub_code=$(".sub_code").val()
        gb_code=$(".gb_code").val()
        min=$(".min").val()
        max=$(".max").val()
        cost_rate=$(".cost_rate").val()
        profit_rate=$(".profit_rate").val()
        drawer_location=$(".drawer_location").val()

        if(medicine_name==""){
            alert("请填写你的药材名称")
            return false
        }
        if(medicine_nickname==""){
            alert("请填写你的药材别名")
            return false
        }
        if(photo==""){
            alert("请上传你的药材图片")
            return false
        }
        if(category1==""){
            alert("请选择你的大分类")
            return false
        }
        if(category2==""){
            alert("请选择你的小分类")
            return false
        }
        if(production_place==""){
            alert("请填写你的药材产地")
            return false
        }
        if(production_date==""){
            alert("请填写你的药材的生产日期")
            return false
        }
        if(lot_number==""){
            alert("请填写你的生产批号")
        }
        if(purchase_date==""){
            alert("请填写你的进货日期")
            return false
        }
        if(quanlity_grade==""){
            alert("请选择质量等级")
            return false
        }
        if(notes==""){
            alert("请填写你的备注")
            return false
        }
        if(purchase_price==""){
            alert("请填写你的采购价格")
            return false
        }
        if(cost_price==""){
            alert("请填写你的成本价")
            return false
        }
        if(sale_price==""){
            alert("请填写你的建议销售价")
            return false
        }
        if(supplier_id==""||supplier_id==undefined){
            alert("请选择你的供货商")
            return false
        }
        if(frequence_code==""){
            alert("请填写国标顺序号")
            return false
        }

        if(sub_code==""){
            alert("请填写支号码")
            return false
        }
        if(gb_code==""){
            alert("请输入国标码")
            return false
        }
        if(min==""){
            alert("请输入用量下限")
            return false
        }
        if(max==""){
            alert("请输入用量上限")
            return false
        }
        if(cost_rate==""){
            alert("请填写成本率")
            return false
        }
        if(profit_rate==""){
            alert("请填写利润率")
            return false
        }
        if(drawer_location==""){
            alert("请填写药箱位置")
            return false
        }
        if(medicine_id==""){
            alert("请填写药材id")
            return false
        }else {
            $.ajax({
                url: 'index.php?r=commodity_management/medicineidonly',
                type: 'get',
                data: 'medicine_id=' + medicine_id,
                success: function (data) {
                    if (data == 1) {
                        alert("该药方id已存在,请重新填写")
                        return false
                    }else{
                        $.ajax({
                            url:'index.php?r=commodity_management/addmedicinethree',
                            type:'get',
                            data:'medicine_name='
                            +medicine_name+'' +
                            '&medicine_nickname='+medicine_nickname+'' +
                            '&photo='+photo+'' +
                            '&category1='+category1+'' +
                            '&category2='+category2+'' +
                            '&production_place='+production_place+'' +
                            '&production_date='+production_date+'' +
                            '&lot_number='+lot_number+'' +
                            '&purchase_date='+purchase_date+'' +
                            '&quanlity_grade='+quanlity_grade+'' +
                            '&notes='+notes+'' +
                            '&purchase_price='+purchase_price+'' +
                            '&cost_price='+cost_price+'' +
                            '&sale_price='+sale_price+'' +
                            '&supplier_id='+supplier_id+'' +
                            '&frequence_code='+frequence_code+'' +
                            '&medicine_id='+medicine_id+'' +
                            '&sub_code='+sub_code+'' +
                            '&gb_code='+gb_code+'' +
                            '&min='+min+'' +
                            '&max='+max+'' +
                            '&cost_rate='+cost_rate+'' +
                            '&profit_rate='+profit_rate+'' +
                            '&drawer_location='+drawer_location,
                            success:function(data){
                                if(data==1){
                                    location.href="index.php?r=commodity_management/index"
                                }
                            }
                        })
                    }
                }
            })
        }

    })
</script>
<!--删除药材-->
<script>
    $(document).on("click",".delmedicine",function(){
        medicine_id=$(".medicine_idone").html()
        aa=confirm("你确认删除!")
        if(aa==true){
            $.ajax({
                url:'index.php?r=commodity_management/delmedicine',
                data:'medicine_id='+medicine_id,
                type:'get',
                success:function(data){
                    if(data==1){
                        location.href="index.php?r=commodity_management/index"
                    }
                }
            })
        }
    })
</script>
<!--修改基本信息-->
<script>
    $(document).on("click",".upone",function(){
        medicine_id=$(".medicine_idone").html()
        if(medicine_id==""){
            $("#bg1").hide();
            $("#show-jbxx").hide();
            alert("请选择你要修改的药材")
            return false
        }else{
            $.ajax({
                url:'index.php?r=commodity_management/upone',
                type:'get',
                data:'medicine_id='+medicine_id,
                success:function(data){
                    $(".listtwo").html(data)
                }
            })
        }

    })
</script>
<!--修改基本信息--联动-->
<script>
    $(document).on("change",".upmaxtype",function(){
        category=$(this).attr("value")
        $.ajax({
            url:'index.php?r=commodity_management/litwo',
            type:'get',
            dataType:'json',
            data:'category='+category,
            success:function(data){
                str="";
                str+="<select class='upmintype'>";
                for(i in data){
                    str+="<option value='"+data[i]['category']+"'>"+data[i]['category_name']+"</option>";
                }
                str+="</select>";
                $(".upmintype").html(str)
            }
        })
    })
</script>
<!--修改价格-->
<script>
    $(document).on("click",".uptwo",function(){
        medicine_id=$(".medicine_idone").html()
        if(medicine_id==""){
            $("#bg1").hide();
            $("#show-bj").hide();
            alert("请选择你要修改的药材")
            return false
        }else {
            $.ajax({
                url:'index.php?r=commodity_management/uptwo',
                type:'get',
                data:'medicine_id='+medicine_id,
                success:function(data){

                    $(".ycgl-bj-cont").html(data)
                }
            })

        }

    })
</script>
<script>
    $(document).on("click","#uptwobaocun",function(data){
        medicine_id=$(".uptwomedicine_id").attr("value")
        purchase_price=$(".uppurchase_price").val()
        cost_price=$(".upcost_price").val()
        sale_price=$(".upsale_price").val()
        cost_rate=$(".upcost_rate").val()
        profit_rate=$(".upprofit_rate").val()

        $.ajax({
            url:'index.php?r=commodity_management/uptwoprice',
            type:'get',
            data:'medicine_id='+medicine_id +
            '&purchase_price='+purchase_price+
            '&cost_price='+cost_price +
            '&sale_price='+sale_price +
            '&cost_rate='+cost_rate +
            '&profit_rate='+profit_rate,
            success:function(data){
                if(data==1){
                    $.ajax({
                        url:'index.php?r=commodity_management/detail',
                        type:'get',
                        data:'medicine_id='+medicine_id,
                        success:function(data){
                            $("#bg1").hide();
                            $("#show-bj").hide();
                            $(".list").html(data)
                        }
                    })
                }
            }
        })

    })
    </script>
<!--修改供货商-->
<script>
    $(document).on("click",".upthree",function(){
        medicine_id=$(".medicine_idone").html()
        if(medicine_id==""){
            $("#bg1").hide();
            $("#show-gys").hide();
            alert("请选择你要修改的药材")
            return false
        }else {
            $.ajax({
                url:'index.php?r=commodity_management/upthree',
                type:'get',
                data:'medicine_id='+medicine_id,
                success:function(data){
                   $(".content").html(data)
                }
            })
        }
    })
</script>
<script>
    $(document).on("click","#upthreebaocun",function(){
        supplier_id=$(".supplier_id").attr("value")
        upsupplier_id=$(".upsupplier_id:checked").attr("value")
        medicine_id=$(".upthreemedicine_id").attr("value")
        if(upsupplier_id==undefined){
            upsupplier_id=supplier_id
        }
        $.ajax({
            url:'index.php?r=commodity_management/upthreeok',
            type:'get',
            data:'medicine_id='+medicine_id+'&supplier_id='+upsupplier_id,
            success:function(data){
                if(data==1){
                    $.ajax({
                        url:'index.php?r=commodity_management/detail',
                        type:'get',
                        data:'medicine_id='+medicine_id,
                        success:function(data){
                            $("#bg1").hide();
                            $("#show-gys").hide();
                            $(".list").html(data)
                        }
                    })
                }
            }
        })
    })
</script>
<!--按照药材名称进行搜索-->
<script>
    $(document).on("click",".searchmedicine_name",function(){
        medicine_name=$(".medicine_name").val()
        if(medicine_name==""){
            alert("请填写你要搜索的药材名称")
            return false
        }
        $.ajax({
            url:'index.php?r=commodity_management/search',
            data:'medicine_name='+medicine_name,
            type:'get',
            success:function(data){
           if(data!=""){
               $(".medicine_idone").html(data)
               $.ajax({
                   url:'index.php?r=commodity_management/detail',
                   type:'get',
                   data:'medicine_id='+data,
                   success:function(data){
                       $(".list").html(data)
                   }
               })
           }else{
               alert("你搜索的药材数据不存在")
           }
            }
        })
    })


</script>


