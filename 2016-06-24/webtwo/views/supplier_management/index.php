<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>供应商管理</title>
    <link rel="stylesheet" href="css/shopadmin-editor.css">
</head>
<body>

<!-- 编辑弹出 -->
<div id="bjeditor">
    <div class="bjeditor">
        <h3>供应商管理--编辑<b id="close"><img src="img/close.jpg" alt="" id="close"></b></h3>
        <div class="bjeditorcont">
            <h2>基本信息</h2>
            <h4><b>供应商名称</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
            <h4><b>供应商地址</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
            <h4><b>供应商联系人<br>(手机号码)</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
            <h4><b>联系电话</b><label><input type="text" placeholder="北京大致医药公司" ></label></h4>
            <h4><b>邮箱</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
            <h4><b>微信</b><label><input type="text" placeholder="北京大致医药公司"></label></h4>
            <h4><b>备注</b><label><textarea name="" id="" cols="30" rows="3"></textarea></label></h4>
            <button id="baocun">保存</button>
        </div>
    </div>
</div>
<!--添加-->
<div id="addtwo" style="display: none">
    <div class="bjeditor">
        <h3>供应商管理--生成<b id="close"><img src="img/close.jpg" alt="" id="closetwo"></b></h3>
        <div class="bjeditorcont">
            <h2>基本信息</h2>
            <h4><b>供应商名称</b><label><input type="text" class="supplier_name"></label></h4>
            <h4><b>供应商地址</b><label><input type="text"  class="address"></label></h4>
            <h4><b>供应商联系人<br>(手机号码)</b><label><input type="text"  class="contact"></label></h4>
            <h4><b>联系电话</b><label><input type="text" class="tel"></label></h4>
            <h4><b>邮箱</b><label><input type="text"  class="email"></label></h4>
            <h4><b>微信</b><label><input type="text" class="weixin"></label></h4>
            <button id="addbaocuntwo">保存</button>
        </div>
    </div>
</div>
<!--添加结束-->
<div class="shopadmin">

    <header class="header">
        <div class="logo">
            <img src="img/订单_02.png" alt="">
        </div>
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;中央药房</p>
        <ul>
            <li><a href="ddjs.html">订单</a></li>
            <li><a href="user-yuebie.html">客户</a></li>
            <li><a href="index.php?r=setup/index">设置</a></li>
        </ul>
    </header>

    <div class="container">
        <h1><a href="shezhi.html"><b><img src="img/back_03.jpg" alt=""></b>设置 > 供应商管理</a></h1>
        <div class="shopadmincont">
            <h3>
                <span>全部</span>
                <i value="A-D" class="first_letter">A-D</i>
                <i value="E-H" class="first_letter">E-H</i>
                <i value="I-L" class="first_letter">I-L</i>
                <i value="M-P" class="first_letter">M-P</i>
                <i value="Q-T" class="first_letter">Q-T</i>
                <i value="U-W" class="first_letter">U-W</i>
                <i value="X-Z" class="first_letter">X-Z</i>

                <label><img src="img/add_07.jpg" id="scgys" alt=""
                        ></label></h3>
            <div class="shopcontbot">
                <div class="shopcontbot_l">
                    <ul>
                        <?php foreach($arr as $k=>$v){?>
                        <li class="supplier_id" value="<?php echo $v['supplier_id']?>"><?php echo $v['supplier_name']?></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="shopcontbot_r">

                    <h4><b><img src="img/rubbsh_07.jpg" alt="" class="delete"></b>基本信息<i><a href=""></a><img src="img/xiugai_07.jpg" alt="" id="editor"></i></h4>
                    <ol>
                        <li><span>供应商名称</span><label>王神医</label></li>
                        <li><span>供应商地址</span><label>北京市海淀区北清路13号102</label></li>
                        <li><span>供应商联系人</span><label>张胜利</label></li>
                        <li><span>联系电话</span><label>13141234481</label></li>
                        <li><span>邮箱</span><label>xxxxx@126.com</label></li>
                        <li><span>微信</span><label>13141234481</label></li>
                        <li><span>备注</span><label>名医医馆</label></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery1.8.js"></script>
<script src="js/shouye.js"></script>
<script src="js/jquery1-8-0.js"></script>

</body>
</html>
<!--根据id匹配数据-->
<script>
    $(document).on("click",".supplier_id",function(){
        supplier_id=$(this).attr("value")
        $.ajax({
            url:'index.php?r=supplier_management/detail',
            type:'get',
            data:'supplier_id='+supplier_id,
            success:function(data){
                $(".shopcontbot_r").html(data)
            }
        })
    })
</script>
<!--删除供应商-->
<script>
    $(document).on("click",".delete",function(){
        supplier_id=$(".one").attr("value")
        var aa=confirm("你确定要删除?")
        if(aa==true){
            $.ajax({
                url:'index.php?r=supplier_management/delete',
                type:'get',
                data:'supplier_id='+supplier_id,
                success:function(data){
                    if(data==1){
                        location.href="index.php?r=supplier_management/index"
                    }
                }
            })
        }
    })
</script>
<!--根据首字母匹配数据-->
<script>
    $(document).on("click",".first_letter",function(){
        first_letter=$(this).attr("value")
        $.ajax({
            url:'index.php?r=supplier_management/first_letter',
            type:'get',
            data:'first_letter='+first_letter,
            success:function(data){
                $(".shopcontbot_l").html(data)
            }
        })
    })
</script>
<!--修改-->
<script>
    $(document).on("click","#editor",function(){
        supplier_id=$(".one").attr("value")
        $.ajax({
            url:'index.php?r=supplier_management/update',
            type:'get',
            data:'supplier_id='+supplier_id,
            success:function(data){
                $(".bjeditorcont").html(data)
            }
        })
    })
</script>
<!--修改保存数据-->
<script>
    $(document).on("click","#upbaocun",function(){
        supplier_id=$(".one").attr("value")
        supplier_name=$(".supplier_name").val()
        address=$(".address").val()
        contact=$(".contact").val()
        tel=$(".tel").val()
        email=$(".email").val()
        weixin=$(".weixin").val()
        $.ajax({
            url:'index.php?r=supplier_management/updatetwo',
            type:'get',
            data:'supplier_id='+supplier_id+'' +
            '&supplier_name='+supplier_name+'' +
            '&address='+address+'' +
            '&contact='+contact+'' +
            '&tel='+tel+'&email='+email+
            '&weixin='+weixin,
            success:function(data){
                if(data==1){
                    location.href="index.php?r=supplier_management/index"
                }
            }

        })

    })
</script>
<!--添加-->
<script>
    $(document).on("click","#addbaocuntwo",function(){
        supplier_name=$(".supplier_name").val()
        address=$(".address").val()
        contact=$(".contact").val()
        tel=$(".tel").val()
        email=$(".email").val()
        weixin=$(".weixin").val()
        if(supplier_name==""||address==""||contact==""||tel==""||email==""||weixin==""){
            alert("不能为空")
        }else{
            $.ajax({
                url:'index.php?r=supplier_management/add',
                type:'get',
                data:'supplier_name='+supplier_name+'' +
                '&address='+address+'' +
                '&contact='+contact+'' +
                '&tel='+tel+'&email='+email+
                '&weixin='+weixin,
                success:function(data){
                    if(data==1){
                        location.href="index.php?r=supplier_management/index"
                    }
                }

            })
        }
    })
</script>