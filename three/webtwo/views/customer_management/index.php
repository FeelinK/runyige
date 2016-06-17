<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>客户管理</title>
    <link rel="stylesheet" href="css/usermin-editor.css">
</head>
<body>

<!-- 编辑弹出 -->
<div id="usereditor" style="display:none">
    <div class="usereditor">
        <h3>客户管理--编辑<b id="closeuser"><img src="img/close.jpg" alt=""></b></h3>
        <div class="usereditorcont">
            <h2>基本信息</h2>
            <ol>
                <li><span>客户名称</span><label><input type="text" placeholder="王神医"></label></li>
                <li><span>客户地址</span><label><input type="text" placeholder="北京市海淀区清华东路12号楼1106"></label></li>
                <li><span>主账号</span><label><input type="text" placeholder="13141234481"></label></li>
                <li><span>联系人</span><label><input type="text" placeholder="王神医"></label></li>
                <li><span>联系电话</span><label><input type="text" placeholder="13141234481"></label></li>
                <li><span>服务开始日期</span><label><input type="text" placeholder="2016/04/17"></label></li>
                <li><span>备注</span><label><input type="text" placeholder="名医馆"></label></li>
            </ol>
            <ul>
                <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
                <li style="line-height:35px;font-size:17px;"><input type="radio">分成<span>医馆分成比例</span><b>50%</b></li>
                <li style="line-height:35px;font-size:17px;"><input type="radio">合约价<span>加价成比例</span><b>20%</b></li>
                <li style="margin-left: 125px;color:#ccc;">结算日<select name="" id="">
                        <option value="">当月月底</option>
                        <option value="">下月月底</option>
                    </select></li>
                <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">药材等级</li>
                <li>药材等级<span><select name="" id="">

                            <option value="">优</option>
                        </select></span></li>
            </ul>
            <button id="baocun">保存</button>
        </div>
    </div>
</div>
<div id="usereditor-2" style="display:none">
    <div class="usereditor">
        <h3>客户管理--生成<b ><img src="img/close.jpg" alt="" id="closeuser2"></b></h3>
        <div class="usereditorcont">
            <h2>基本信息</h2>
            <ol>
                <li><span>客户名称</span><label><input type="text" class="h_name"></label></li>
                <li><span>客户地址</span><label><input type="text" class="h_address"></label></li>
                <li><span>主账号</span><label><input type="text" class="main_account_id"></label></li>
                <li><span>联系人</span><label><input type="text" class="doctor_name"></label></li>
                <li><span>联系电话</span><label><input type="text" class="doctor_phone" ></label></li>
            </ol>
            <ul>
                <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
                <li style="line-height:35px;font-size:17px;"><input type="radio">分成<span>医馆分成比例</span><b><input type="text"  class="profit_margine" style="width:40px">%</b></li>

                <li style="margin-left: 125px;color:#ccc;">结算日<select class="clearing_type">
                        <?php foreach($clearday as $k=>$v){?>
                        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                        <?php }?>
                    </select></li>

            </ul>
            <button id="baocun2">保存</button>
        </div>
    </div>
</div>
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
        <h1><a href="shezhi.html"><b><img src="img/back_03.jpg" alt=""></b></a>设置 >客户管理</h1>
        <div class="search">
            <b><img src="img/订单_06.jpg" alt=""></b><input type="text" placeholder="客户名称"  class="searchcontent">
            <input type="button" value="搜索" class="sousuo2">
        </div>
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
                <label>
                    <img src="img/add_07.jpg" alt="" class="add-usermin">
                </label>
            </h3>

            <div class="shopcontbot">
                <div class="shopcontbot_l">
                    <input type="hidden" value="<?php echo $hospital_name?>" class="one">
                        <?php foreach($arr as $k=>$v){?>
                        <span value="<?php echo $v['main_account_id']?>"class="main_account_id"><?php echo $v['hospital_name']?></span>
                      <?php }?>

                </div>

                <div class="list">
                <div class="shopcontbot_r">
                    <input type="hidden" class="up_main" value="">

                    <h4><b><img src="img/rubbsh_07.jpg" alt="" class="deleteinfo"></b>基本信息<i id="usershow"><img src="img/xiugai_07.jpg" alt="" id="up" class="up"></i></h4>
                    <ol>
                        <li><span>客户名称</span><label>王神医</label></li>
                        <li><span>客户地址</span><label>北京市海淀区清华东路12号楼1106</label></li>
                        <li><span>主账号</span><label>13141234481</label></li>
                        <li><span>联系人</span><label>王神医</label></li>
                        <li><span>联系电话</span><label>13141234481</label></li>
                        <li><span>服务开始日期</span><label>2016/04/07</label></li>
                        <li><span>备注</span><label>名医馆</label></li>
                    </ol>
                    <ul>
                        <li style="line-height:53px;font-size:20px;list-style-image:url(img/客户管理2_03.gif)">核算方式</li>
                        <li style="line-height:35px;font-size:17px;"><input type="radio">分成<span>医馆分成比例</span><b>50%</b></li>
                        <li style="margin-left: 125px;color:#ccc;">结算日<span>当月月底</span></li>

                    </ul>

                </div>
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
<script>
    $(document).on("click",".main_account_id",function(){
        $(this).css("color","#8c8c8c").siblings().css("color","#ebebeb")
       var main_account_id=$(this).attr("value");
        $.ajax({
            url:'index.php?r=customer_management/detail',
            type:'get',
            data:'main_account_id='+main_account_id,
            success:function(data){
                $(".list").html(data)
            }
        })

    })
</script>
<!--修改基本信息-->
<script>
    $(document).on("click","#up",function(){
        main_account_id=$(".up_main").attr("value")

        $.ajax({
            url:'index.php?r=customer_management/upinfo',
            type:'get',
            data:'main_account_id='+main_account_id,
            success:function(data){
                $("#usereditor").html(data)

            }
        })

    })
</script>
<!--根据搜索匹配医馆-->
<script>
    $(document).on("click",".sousuo2",function(){
        searchcontent=$(".searchcontent").val()
        $.ajax({
            url:'index.php?r=customer_management/search',
            type:'get',
            data:'hospital_name='+searchcontent,
            success:function(data){
                $(".shopcontbot_l").html(data)
            }
        })
    })
</script>
<!--根据首字母匹配医馆-->
<script>
    $(document).on("click",".first_letter",function(){
        first_letter=$(this).attr("value")
        hospital_name=$(".one").attr("value")



       $.ajax({
            url:'index.php?r=customer_management/search',
            type:'get',
           data:'first_letter='+first_letter+'&hospital_name='+hospital_name,
            success:function(data){
               $(".shopcontbot_l").html(data)
           }
       })
    })
</script>
<!--添加客户-->
<script>
  $(document).on("click","#baocun2",function(){
      h_name=$(".h_name").val()
      h_address=$(".h_address").val()
      main_account_id=$(".main_account_id").val()
      doctor_name=$(".doctor_name").val()
      doctor_phone=$(".doctor_phone").val()
      profit_margine=$(".profit_margine").val()
      clearing_type=$(".clearing_type").attr("value")
      if(h_name==""||h_address==""||main_account_id==""||doctor_name==""||doctor_phone==""||profit_margine==""||clearing_type==""){
          alert("请完整填写客户信息")
      }else{
          $.ajax({
              url:'index.php?r=customer_management/addhospital',
              type:'get',
              data:'h_name='+h_name+'&h_address='+h_address+'&main_account_id='+main_account_id+
              '&doctor_name='+doctor_name+'&doctor_phone='+doctor_phone+'&clearing_type='+clearing_type+'&profit_margine='+profit_margine,
              success:function(data){
                  if(data==1){
                      location.href='index.php?r=customer_management/index'
                  }
              }
          })
      }



  })
</script>
<!--删除-->
<script>
    $(document).on("click",".deleteinfo",function(){

        main_account_id=$(".up_main").attr("value")
        if(main_account_id!=""){
         var qq=confirm("你确定要删除")
            if(qq==true) {
                $.ajax({
                    url: 'index.php?r=customer_management/deleteinfo',
                    type: 'get',
                    data: 'main_account_id=' + main_account_id,
                    success: function (data) {
                        if (data == 1) {
                            location.href = 'index.php?r=customer_management/index'

                        }
                    }
                })
            }

        }
    })
</script>
<script>
  $(document).on("click","#baocun",function(){
      h_name=$(".h_name").val()
      h_address=$(".h_address").val()
      mobile=$(".mobile").val()
      doctor_name=$(".doctor_name").val()
      doctor_phone=$(".doctor_phone").val()
      profit_margine=$(".profit_margine").val()
      clearing_type=$(".clearing_type").attr("value")
      main_account_id=$(".up_main").attr("value")
      $.ajax({
          url:'index.php?r=customer_management/upinfotwo',
          type:'get',
          data:'h_name='+h_name+'&h_address='+h_address+'&main_account_id='+main_account_id+
          '&doctor_name='+doctor_name+'' +
          '&doctor_phone='+doctor_phone+'' +
          '&clearing_type='+clearing_type+'' +
          '&profit_margine='+profit_margine+'' +
          '&mobile='+mobile,
          success:function(data){
              if (data == 1) {
                  location.href = 'index.php?r=customer_management/index'

              }
          }
      })
  })
</script>