﻿/*左部单击切换字体颜色与北京颜色*/
$(".f-left").on("click","h3",function(){
	$(this).css("color","black").find("span").css("background","#779800")
	$(this).siblings("h3").css("color","#ccc").find("span").css("background","#e3e4e4")

})
// 单击进入打印事件页面
$(".yfjd").on("click","#print",function(){
	$("#show").children(".bq").show();
	$("#show").children(".yfjd").hide();
})
$("#xxshow").on("click",function(){
	$("#show").children(".ddxx").show().siblings().hide();
})
/*流程中点击按钮显示相对应的遮罩层以及内容块*/
$("#btnshow").on("click",function(){
	$("#show").children(".yfjd").show().siblings("").hide();
})
$("#btnshow1").on("click",function(){
	$("#show").children(".lr").show().siblings("").hide();
	//alert("aaa");
})
$("#lrover").on("click",function(){

	$("#psdshow").children(".psd").show();
})
$("#psdover").on("click",function(){
	$("#show").children(".psd").hide();
	$("#show").children(".lr2").show();	
	$("#show").children(".lr").hide();	
})
$("#lr2over").on("click",function(){
	$("#show").children(".yfjd").show();
	$("#show").children(".lr2").hide();	
})
$("#btnshow2").on("click",function(){
	$("#show").children(".yfjd").hide();
	$("#show").children(".zdjc").show();
})
$("#zdjcover").on("click",function(){
	$("#show").children(".zdjc").hide();
	$("#show").children(".shenfang").show();
})
$("#shenfangover").on("click",function(){
	$("#show").children(".yfjd").show();
	$("#show").children(".shenfang").hide();
	
})
$("#btnshow5").on("click",function(){
	$("#show").children(".yfjd").hide();
	$("#show").children(".fc").show();
})
$("#fcover").on("click",function(){
	$("#show").children(".yfjd").show();
	$("#show").children(".fc").hide();
	
})
$("#btnshow6").on("click",function(){
	$("#show").children(".yfjd").hide();
	$("#show").children(".jz").show();
})
$("#jzover").on("click",function(){
	$("#show").children(".yfjd").show();
	$("#show").children(".jz").hide();
	
})
$("#btnshow7").on("click",function(){
	$("#show").children(".yfjd").hide();
	$("#show").children(".ps").show();
})
$("#psover").on("click",function(){
	$("#show").children(".yfjd").show();
	$("#show").children(".ps").hide();
	
})

/*遮罩层的显示与隐藏*/
     function showdiv() {
            document.getElementById("bg").style.display = "block";
            document.getElementById("show").style.display = "block";
        }
        function hidediv() {
            document.getElementById("bg").style.display = 'none';
            document.getElementById("show").style.display = 'none';
        }
         function psdshowdiv() {
            document.getElementById("psdbg").style.display = "block";
            document.getElementById("psdshow").style.display = "block";
        }
        function psdhidediv() {
            document.getElementById("psdbg").style.display = 'none';
            document.getElementById("psdshow").style.display = 'none';
        }
       /* 打印事件（jqprint）*/
		  function print(){
		    $("#printContainer").jqprint({
		     debug: false, //如果是true则可以显示iframe查看效果（iframe默认高和宽都很小，可以再源码中调大），默认是false
		     importCSS: true, //true表示引进原来的页面的css，默认是true。（如果是true，先会找$("link[media=print]")，若没有会去找$("link")中的css文件）
		     printContainer: true, //表示如果原来选择的对象必须被纳入打印（注意：设置为false可能会打破你的CSS规则）。
		     operaSupport: true//表示如果插件也必须支持歌opera浏览器，在这种情况下，它提供了建立一个临时的打印选项卡。默认是true
		    });
		   }
		    function print2(){
		    $(".printContainer2").jqprint({
		     debug: false, //如果是true则可以显示iframe查看效果（iframe默认高和宽都很小，可以再源码中调大），默认是false
		     importCSS: true, //true表示引进原来的页面的css，默认是true。（如果是true，先会找$("link[media=print]")，若没有会去找$("link")中的css文件）
		     printContainer: true, //表示如果原来选择的对象必须被纳入打印（注意：设置为false可能会打破你的CSS规则）。
		     operaSupport: true//表示如果插件也必须支持歌opera浏览器，在这种情况下，它提供了建立一个临时的打印选项卡。默认是true
		    });
		 $(".printContainer3").jqprint({
		     debug: false, //如果是true则可以显示iframe查看效果（iframe默认高和宽都很小，可以再源码中调大），默认是false
		     importCSS: true, //true表示引进原来的页面的css，默认是true。（如果是true，先会找$("link[media=print]")，若没有会去找$("link")中的css文件）
		     printContainer: true, //表示如果原来选择的对象必须被纳入打印（注意：设置为false可能会打破你的CSS规则）。
		     operaSupport: true//表示如果插件也必须支持歌opera浏览器，在这种情况下，它提供了建立一个临时的打印选项卡。默认是true
		    });
		   }
		 /*单击返回按钮返回上一步操作*/
		$("history").on("click",function(){
			window.history.go(-1); 
		})
	;(function(){
	/*点击编辑遮罩层显示*/
	$("#editor").on("click",function(){
		$("#bjeditor").show();
	})
	/*点击遮罩层关闭*/
	$("#close").on("click",function(){
		$("#bjeditor").hide();
	})
	$("#close2").on("click",function(){

		$("#usereditor").show();
})
		$("#usershow").on("click",function(){	
		$("#bjeditor-2").hide();
	})
      $("#usershow").on("click",function(){
		$("#usereditor").show();
	})
	
	$("#closeuser").on("click",function(){
		$("#usereditor").hide();
	})
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


	//点击+号添加一行
	$("#jia").on("click",function(){
		//alert(111);
		$("#tabs").append("<tr class='tr-trs'><td><input type='text' class='trs_1' placeholder='药名' style='width:82px;color:#e3e4e4;'><div class='aa'></div></td><td><input type='text' placeholder='重量'  style='width:82px;color:#e3e4e4;'>克</td><td><select name='' id=''><option value=''>先煎</option><option value=''>后下</option><option value=''>包煎</option><option value=''>烊化</option><option value=''>冲服</option></select></td><td class='del'><img src='img/订单详细-2_03.gif' alt='' ></td></tr>");
		//$("table").children().append("<tr class='tr-trs'><td><input type='text' placeholder='药名' style='width:82px;color:#e3e4e4;'></td><td><input type='text' placeholder='重量'  style='width:82px;color:#e3e4e4;'>克</td><td><select name='' id=''><option value=''>先煎</option><option value=''>后下</option><option value=''>包煎</option><option value=''>烊化</option><option value=''>冲服</option></select></td><td id='del'><img src='img/订单详细-2_03.gif' alt='' ></td></tr>")
	})
	$(document).on("click",".del",function(){
		$(this).parent().remove();
	})
	/*$(document).delegate(".del","click",function(){
		//alert(1111);
		$(this).parent().remove();
	})*/
	$(".add-usermin").on("click",function(){
		$("#usereditor-2").show();
	})
		$("#add-person").on("click",function(){
		$("#personeditor-2").show();
	})

$(document).on("focus",".trs_1",function(){
		$(this).next(".aa").show();
	})
	$(document).on("blur",".trs_1",function(){
		$(this).next(".aa").hide();
	})
	/*设置页供应商管理编辑与生成的显示与隐藏*/
	$("#baocun").on("click",function(){
		$("#usereditor").hide();
	})
	
	$("#closeuser2").on("click",function(){
		$("#usereditor-2").hide();
	})
		$("#personshow").on("click",function(){
		$("#personeditor").show();
	})
        $("#scgys").on("click",function(){
		$("#addtwo").show();
	}) 
          $("#addbaocun").on("click",function(){
		$("#addtwo").hide();
	})
	 $("#closetwo").on("click",function(){
		$("#addtwo").hide();
	})
		$("#closeperson2").on("click",function(){
		$("#personeditor-2").hide();
	})
		$("#closeperson").on("click",function(){
		$("#personeditor").hide();
	})
			$(".baocun1").on("click",function(){
		$("#personeditor").hide();
	})
	$(".baocun2").on("click",function(){
	$("#personeditor-2").hide();
	})
	
})()
