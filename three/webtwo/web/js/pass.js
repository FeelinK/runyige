  /*//表单验证
       $(function(){
 
                var ok1=false;
                var ok2=false;
                var ok3=false;
                // 验证用户姓名
                $('input[]')
                $('input[name="name"]').focus(function(){
                    $(this).next().text('请输入您的姓名').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().length >= 4 && $(this).val().length <=16 && $(this).val()!=''){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                        ok1=true; 
                    }else{
                        $(this).next().text('用户名错误').removeClass('state1').addClass('state3');
                    }  
                });
                //验证地址
                $('input[name="address"]').focus(function(){
                    $(this).next().text('请输入您的地址').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().length > 0 && $(this).val().length <=255 && $(this).val()!=''){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                        ok2=true;
                    }else{
                        $(this).next().text('地址不能为空！').removeClass('state1').addClass('state3');
                    }
                });
                //验证手机号码
                $('input[name="tel"]').focus(function(){
                    $(this).next().text('请输入您的手机号').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().search(/^1[3,5,7,8]\d{9}$/)==-1){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                         ok3=true;
                    }else{                  
                        $(this).next().text('请输入正确的手机号码').removeClass('state1').addClass('state3');
                    }
                });
                //验证年龄
                $('input[name="age"]').focus(function(){
                    $(this).next().text('请输入您的年龄').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().search(/^\d{1-3}]$/)==-1){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                         ok4=true;
                    }else{                  
                        $(this).next().text('请输入正确的年龄').removeClass('state1').addClass('state3');
                    }
                });
                //验证年龄
                $('input[name="age"]').focus(function(){
                    $(this).next().text('请输入您的年龄').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().search(/^\d{1-3}]$/)==-1){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                         ok4=true;
                    }else{                  
                        $(this).next().text('请输入正确的年龄').removeClass('state1').addClass('state3');
                    }
                });
                //提交按钮,所有验证通过方可提交
                //配送页表单验证
                $('#psover').click(function(){
                    if(ok1 && ok2 && ok3 ){
                        alert("恭喜你，答对了");
                        $('.psright').submit();
                        
                    }else{
                        alert("请输入完整方可提交");
                        return false;
                    }
                });
                //录入页表单验证
                $('#lr2over').click(function(){
                   if(ok1 && ok2 && ok3 ){
                        $('.lr2right').submit();
                    }else{
                        return false;
                    }
                });
                //
            });
            */
           /**
 * Created by Administrator on 15-5-23.
 */
/*
 会员名：
 1、onfocus时，显示提示信息
 2、onblur时，验证
 3、onkeyup时，统计字数

 密码：
 1、onfocus时，显示提示信息
 2、onblur时，验证
 3、onkeyup时，弱中强，当为中时激活确认密码并显示它的提示信息
 确认密码：
 1、onblur时，验证
 */
/*
* 会员名：
 1、onfocus时，显示提示信息
 2、onblur时，验证
 3、onkeyup时，统计字数

 * */
 /*找到所有需要验证的表单*/

var Form1=document.getElementById("form-ps"),
    user1=Form1.elements[0],
    tel1=Form1.elements[1],
    address1=Form1.elements[2],
    userMes=Form1.getElementsByTagName("p")[0],
    telMes=Form1.getElementsByTagName("p")[1],
    addressMes=Form1.getElementsByTagName("p")[2],
    submitBtn=document.getElementById("psover"),     /*配送页查找结束*/

    Form2=document.getElementById('form-lr2'),
    user2=Form2.elements[0],
    tel2=Form2.elements[1],
    address2=Form2.elements[2],
    userMes2=Form2.getElementsByTagName("p")[0],
    telMes2=Form2.getElementsByTagName("p")[1],
    addressMes2=Form2.getElementsByTagName("p")[2],
    submitBtn2=document.getElementById("lr2over"),   /*录入2页查找结束*/

    Form3=document.getElementById("form-jz"),
    checkbox=Form3.getElementByName('checkbox-jz'),
    text=Form3.getElementByName('text-jz'), 
    submitBtn3=document.getElementById("jzover");       /*煎制页查找结束*/

    /*配送页表单验证开始*/
     //名字验证
user1.onfocus=function(){
    userMes.style.display="block"
    div.css("background","red")
    userMes.innerHTML='<i class="ati"></i>5-25个字符，推荐使用中文会员名!'
}
user1.onblur=function(){
    var reg=/[^\w\u4e00-\u9fa5]/g
    if(this.value==""){
        userMes.innerHTML='<i class="err"></i>不能为空!'
    }else if(this.value.length<5||this.value.length>25){
        userMes.innerHTML='<i class="err"></i>长度必须在5--25之间!'
    }else if(reg.test(this.value)){
        userMes.innerHTML='<i class="err"></i>有非法字符!'
    }else{
        userMes.innerHTML='<i class="ok"></i>ok!'
    }
}
       //手机号验证
tel1.onfocus=function(){
    passMes.style.display="block"
    passMes.innerHTML='<i class="ati"></i>6-25个字符,不能为纯数字或者纯字母'
}
tel1.onblur=function(){
    var reg1=/[^a-zA-Z]/g,
        reg2=/\D/g,
        reg3=/^1[3,5,7,8]\d{9}$/;
    if(this.value==""){
       passMes.innerHTML='<i class="err"></i>不能为空!'
    }else if(this.value.length<6||this.value.length>25){
        passMes.innerHTML='<i class="err"></i>长度必须在6--25之间!'
    }else if(!reg1.test(this.value)){
        passMes.innerHTML='<i class="err"></i>不能为纯子母!'
    }else if(!reg2.test(this.value)){
        passMes.innerHTML='<i class="err"></i>不能为纯数字!'
    }else if(reg3.test(this.value)){
        passMes.innerHTML='<i class="ok"></i>ok!'
    }
}   
      //地址验证
Address1.onfocus=function(){
    addressMes.style.display="block"
    addressMes.innerHTML='<i class="ati"></i>0-250个字符'
}
Address1.onblur=function(){
    if(this.value==""){
        addressMes.innerHTML='<i class="err"></i>地址不能为空！'
    }else if(this.value.length>250){
        passMes.innerHTML='<i class="err"></i>最多可输入250个字符!'
    }else{
        addressMes.innerHTML='<i class="ok"></i>ok!'
    }
}
    //点击完成按钮时验证所有表单
submitBtn.onclick=function(){
    user1.onfocus();
    tel1.onfocus();
    address1.onfocus();
    user1.onblur();
    tel1.onblur();
    address1.onblur();
}
/*配送页表单验证结束*/

/*lr2页表单验证开始*/
     //名字验证
user2.onfocus=function(){
    userMes.style.display="block"
    div.css("background","red")
    userMes.innerHTML='<i class="ati"></i>5-25个字符，推荐使用中文会员名!'
}
user2.onblur=function(){
    var reg=/[^\w\u4e00-\u9fa5]/g
    if(this.value==""){
        userMes.innerHTML='<i class="err"></i>不能为空!'
    }else if(this.value.length<5||this.value.length>25){
        userMes.innerHTML='<i class="err"></i>长度必须在5--25之间!'
    }else if(reg.test(this.value)){
        userMes.innerHTML='<i class="err"></i>有非法字符!'
    }else{
        userMes.innerHTML='<i class="ok"></i>ok!'
    }
}
       //手机号验证
tel2.onfocus=function(){
    passMes.style.display="block"
    passMes.innerHTML='<i class="ati"></i>6-25个字符,不能为纯数字或者纯字母'
}
tel2.onblur=function(){
    var reg1=/[^a-zA-Z]/g,
        reg2=/\D/g,
        reg3=/^1[3,5,7,8]\d{9}$/;
    if(this.value==""){
       passMes.innerHTML='<i class="err"></i>不能为空!'
    }else if(this.value.length<6||this.value.length>25){
        passMes.innerHTML='<i class="err"></i>长度必须在6--25之间!'
    }else if(!reg1.test(this.value)){
        passMes.innerHTML='<i class="err"></i>不能为纯子母!'
    }else if(!reg2.test(this.value)){
        passMes.innerHTML='<i class="err"></i>不能为纯数字!'
    }else if(reg3.test(this.value)){
        passMes.innerHTML='<i class="ok"></i>ok!'
    }
}   
      //地址验证
Address2.onfocus=function(){
    addressMes.style.display="block"
    addressMes.innerHTML='<i class="ati"></i>0-250个字符'
}
Address2.onblur=function(){
    if(this.value==""){
        addressMes.innerHTML='<i class="err"></i>地址不能为空！'
    }else if(this.value.length>250){
        passMes.innerHTML='<i class="err"></i>最多可输入250个字符!'
    }else{
        addressMes.innerHTML='<i class="ok"></i>ok!'
    }
}
    //点击完成按钮时验证所有表单
submitBtn2.onclick=function(){
    user2.onfocus();
    tel2.onfocus();
    address2.onfocus();
    user2.onblur();
    tel2.onblur();
    address2.onblur();
}
/*录入2页表单验证结束*/

/*煎制页表单验证开始*/
