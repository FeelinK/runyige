<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>客户管理</title>
    <link rel="stylesheet" href="css/person-editor.css">
</head>
<body>

<!-- 编辑弹出 -->
<div id="personeditor" style="display:none;">
    <div class="personeditor">
        <h3>员工管理--编辑<b id="closeperson"><img src="img/close.jpg" alt=""></b></h3>
        <div class="personeditorcont">
            <div class="personeditorcont_l">
                <p><img src="img/user_03.jpg" alt=""></p>
                <button>选择文件</button><br>
                <span>未选择任何文件</span>
            </div>
            <div class="personeditorcont_r">
                <h2>基本信息</h2>
                <h4><b>员工姓名</b><label><input type="text" placeholder="崔二庆"></label></h4>
                <h4><b>员工ID</b><label><input type="text" placeholder="AD123456"></label></h4>
                <h4><b>员工注册账号<br>(手机号码)</b><label><input type="text" placeholder="13612345678"></label></h4>
                <h4><b>密码</b><label><input type="passwords" placeholder="******"></label></h4>
                <h4><b>职位</b><label><input type="text" placeholder="经理"></label></h4>
                <h4><b>联系电话</b><label><input type="text" placeholder="13612345678"></label></h4>
                <h4><b>任职日期</b><label><input type="text" placeholder="2016/04/17"></label></h4>
                <h4><b>备注</b><label><textarea name="" id="" cols="30" rows="3" placeholder="名医医馆"></textarea></label></h4>
                <button class="baocun1">保存</button>
            </div>

        </div>
    </div>
</div>
<div id="personeditor-2" style="display:none;">
    <div class="personeditor">
        <h3>员工管理--生成<b id="closeperson2"><img src="img/close.jpg" alt="" ></b></h3>
        <div class="personeditorcont">
            <div class="personeditorcont_l">
                <p><img src="img/user_03.jpg" alt=""></p>
                <button>选择文件</button><br>
                <span>未选择任何文件</span>
            </div>
            <div class="personeditorcont_r">
                <h2>基本信息</h2>
                <h4><b>员工姓名</b><label><input type="text" class="staff_name"></label></h4>
                <h4><b>员工ID</b><label><input type="text" class="staff_id"></label></h4>
                <h4><b>员工注册账号<br>(手机号码)</b><label><input type="text" class="mobile"></label></h4>
                <h4><b>密码</b><label><input type="passwords" class="password_hash"></label></h4>
                <h4><b>职位</b><label><input type="text" class="role_name"></label></h4>
                <h4><b>联系电话</b><label><input type="text" ></label></h4>

                <button class="baocun2">保存</button>
            </div>

        </div>
    </div>
</div>

<div class="person">

    <header class="header">
        <div class="logo">
            <img src="img/订单_02.png" alt="">
        </div>
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;中央药房</p>
        <ul>
            <a href="ddjs.html"><li>订单</li></a>
            <a href="user-yuebie.html"><li>客户</li></a>
            <a href="shezhi.html"><li>设置</li></a>
        </ul>
    </header>

    <div class="container">
        <h1><a href="shezhi.html"><b><img src="img/back_03.jpg" alt=""></b>设置 > 员工管理</a></h1>
        <input type="hidden" class="one">
        <h3>
            <span>全部</span>
            <i value="A-D" class="first_letter">A-D</i>
            <i value="E-H" class="first_letter">E-H</i>
            <i value="I-L" class="first_letter">I-L</i>
            <i value="M-P" class="first_letter">M-P</i>
            <i value="Q-T" class="first_letter">Q-T</i>
            <i value="U-W" class="first_letter">U-W</i>
            <i value="X-Z" class="first_letter">X-Z</i>
            <label>
                <img src="img/add_07.jpg" alt="" id="add-person">
            </label>
        </h3>
        <div class="personcont">
            <div class="personcont_l">
                <ul>
                    <?php foreach($arr as $k=>$v){?>
                    <li class="staff_id" value="<?php echo $v['staff_id']?>" class="staff_id"><?php echo $v['staff_name']?></li>
                    <?php }?>
                </ul>
            </div>
            <div class="personcont_r">
                <h4><b><img src="img/rubbsh_07.jpg"  class="delstaff" alt=""></b>基本信息<i  id="personshow"><img src="img/xiugai_07.jpg" alt=""></i></h4>
                <ul>
                    <li>员工姓名</li>
                    <li>员工id</li>
                    <li>员工注册账号</li>
                    <li>密码</li>
                    <li>职位</li>
                    <li>联系电话</li>
                    <li>任职日期</li>
                    <li>备注</li>
                </ul>
                <p><img src="img/user_03.jpg" alt=""></p>
                <ol>
                    <li>崔二庆</li>
                    <li>AD123456</li>
                    <li>13141234481</li>
                    <li>******</li>
                    <li>经理</li>
                    <li>13141234481</li>
                    <li>2016/04/17</li>
                    <li>名医医馆</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery1.8.js"></script>
<script src="js/index.js"></script>
<script src="js/shouye.js"></script>
<script src="js/jquery1-8-0.js"></script>
</body>
</html>
<!--按照首字母匹配-->
<script>
    $(document).on("click",".first_letter",function(){
        first_letter=$(this).attr("value")
        $.ajax({
            url:'index.php?r=staff_management/search',
            type:'get',
            data:'first_letter='+first_letter,
            success:function(data){
          $(".personcont_l").html(data)
            }
        })
    })
</script>
<!--根据员工id匹配基本细信息-->
<script>
    $(document).on("click",".staff_id",function(){
        staff_id=$(this).attr("value")
        $(".one").html(staff_id)
        $.ajax({
            url:'index.php?r=staff_management/detail',
            type:'get',
            data:'staff_id='+staff_id,
            success:function(data){
                $(".personcont_r").html(data)
            }
        })
    })
</script>
<!--删除员工-->
<script>
    $(document).on("click",".delstaff",function(){
        staff_id=$(".one").html()
       aa=confirm("你确定要删除")
        if(aa=true){
            $.ajax({
                url:'index.php?r=staff_management/delstaff',
                type:'get',
                data:'staff_id='+staff_id,
                success:function(data){
                    if(data==1){
                        location.href="index.php?r=staff_management/index"
                    }
                }
            })
        }
    })
</script>