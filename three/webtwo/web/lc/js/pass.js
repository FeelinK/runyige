  //表单验证
       $(function(){
 
                var ok1=false;
                var ok2=false;
                var ok3=false;
                // 验证用户姓名
                $('input[name="name"]').focus(function(){
                    $(this).next().text('请输入您的姓名').removeClass('state1').addClass('state2');
                }).blur(function(){
                    if($(this).val().length >= 4 && $(this).val().length <=16 && $(this).val()!=''){
                        $(this).next().text('输入成功').removeClass('state1').addClass('state4');
                        ok1=true;
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
                //提交按钮,所有验证通过方可提交
                $('#psover').click(function(){
                    if(ok1 && ok2 && ok3 ){
                        alert("恭喜你，答对了");
                        $('.psright').submit();
                        
                    }else{
                        alert("请输入完整方可提交");
                        return false;
                    }
                });
                $('#lr2over').click(function(){
                   if(ok1 && ok2 && ok3 ){
                        $('.lr2right').submit();
                    }else{
                        return false;
                    }
                });
            });