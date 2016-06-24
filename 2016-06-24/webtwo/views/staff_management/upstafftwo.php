<div class="personeditorcont_l">
    <p class="bb"><img src="<?php echo $arr['photo']?>" width="150" height="150px"></p>
    <input type="hidden" class="upimg">
    <form enctype="multipart/form-data" method='post' >

        <input name='a' type='file' class='ajax'>
    </form>
</div>
<div class="personeditorcont_r">
    <h2>基本信息</h2>
    <h4><b>员工姓名</b><label><input type="text" value="<?php echo $arr['staff_name']?>" class="upstaff_name"></label></h4>
    <h4><b>员工注册账号<br>(手机号码)</b><label><input type="text" value="<?php echo $arr['mobile']?>" class="upmobile"></label></h4>
    <h4><b>密码</b><label><input type="password" value="<?php echo $arr['password_hash']?>" class="uppassword_hash"></label></h4>
    <h4><b>职位</b><label>
            <select class="uprole_id">
                <?php foreach($role as $k=>$v){?>
                <option value="<?php echo $v['role_id']?>"><?php echo $v['role_name']?></option>
               <?php }?>
                </select>

        </label></h4>

    <button class="upstaffsave">保存</button>
</div>
<script src="js/jquery1-8-0.js"></script>
<script>
    $('.ajax').change(function(){
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
                    var we='100px'
                    var he='100px'
                    $(".upimg").val(res)
                    $(".bb").html('<img src="http://o7eryb4fl.bkt.clouddn.com/'+res+'" weight="'+we+'" height="'+he+'">')
                }
            }
        })
    })
</script>
