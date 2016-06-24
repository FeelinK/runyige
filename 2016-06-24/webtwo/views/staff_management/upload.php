

<div id="center">

    <div id="event">
        <div id="dashed">
            <div id="topImg">

            </div>
            <div id="middle">
                点击上传
                <input type="file" id="selectFile">
                <lable for="selectFile"></lable>
            </div>
            <div id="bottom">
                将文件拖到这里试试?
            </div>
        </div>
    </div>
    <ul id="uList">
        <!-- 			<li>
                        <div class="image">
                            <img src="./assets/image/aa.jpg" alt="">
                        </div>
                        <div class="uploadInfo">
                            <span class="fileName">文件名称: <con>ssad</con></span>
                            <span class="imageSize">图片尺寸: <con>ssad</con></span>
                            <span class="fileSize">文件大小: <con>ssad</con></span>
                            <span class="speed">上传速度: <con>ssad</con></span>
                            <span class="loaded">上传详情: <con>zzzz</con></span>
                            <span class="stage">
                                上传状态: <con>ssad</con>
                            </span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                    60%
                                  </div>
                            </div>
                        </div>
                    </li> -->

    </ul>
</div>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="ajaxupload/assets/js/lUpload.js"></script>
<script>
    // 说明 $('#drop').dropFile为拖拽上传 $('#drop').pasteFile为粘贴上传 $('#drop').selectFile 为选择上传
    // 拖拽上传
    var opts = {
        url : 'index.php?r=staff_management/uploadtwo.php',
        maxfiles: 111 , // 单次上传的数量
        maxfilesize : 11,  // 单个文件允许的大小 (M)
        multithreading : true, // true为同时上传false为队列上传
        type : [], // 限制上传的类型
        Knowntype : {'other':'./assets/image/other.jpg', 'html':'./assets/image/html.png'}, // 自定义其他文件的缩略图
        tpl : function(type) { // 自定义模板
            var imageTpl = '<li>\
				<div class="image">\
					<img src="ajaxupload/assets/image/other.jpg" alt="">\
				</div>\
				<div class="uploadInfo">\
					<span class="fileName">文件名称: <text>ssad</text></span>\
					<span class="imageSize">图片尺寸: <text>ssad</text></span>\
					<span class="fileSize">文件大小: <text>ssad</text></span>\
					<span class="fileType">文件类型: <text>ssad</text></span>\
					<span class="speed">上传速度: <text>ssad</text></span>\
					<span class="loaded">上传详情: <text>zzzz</text></span>\
					<span class="stage">\
						上传状态: <text>等待上传</text>\
					</span>\
					<div class="progress" style="display:none">\
						<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" id="progress">\
						    10%\
						  </div>\
					</div>\
				</div>\
			</li>';
            var otherTpl = '<li>\
				<div class="image">\
					<img src="ajaxupload/assets/image/other.jpg" alt="">\
				</div>\
				<div class="uploadInfo">\
					<span class="fileName">文件名称: <text>ssad</text></span>\
					<span class="fileSize">文件大小: <text>ssad</text></span>\
					<span class="fileType">文件类型: <text>ssad</text></span>\
					<span class="speed">上传速度: <text>ssad</text></span>\
					<span class="loaded">上传详情: <text>zzzz</text></span>\
					<span class="stage">\
						上传状态: <text>等待上传</text>\
					</span>\
					<div class="progress" style="display:none">\
						<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" id="progress">\
						    60%\
						  </div>\
					</div>\
				</div>\
			</li>';
            if(type == 'image') {
                return imageTpl;
            } else if(type == 'other') {
                return otherTpl;
            }
        },
        // result 结构 {thisDom: 当前被上传的节点, progress: 进度, speed: "网速", loaded: "已上传的大小 992 KB"}
        dynamic : function(result) { // 返回网速及上传百分比
            result.thisDom.find('#progress').css('width', result.progress + '%').html(result.progress + '%');
            result.thisDom.find('.speed').text("网速：" + result.speed + " K\/S")
            result.thisDom.find('.loaded text').text(result.loaded + ' / ' + result.total)

        },
        complete : function(file) { // 上传完成后调用的
            var uList = $('#uList li').eq(file.index);

            uList.find('.stage text').html('上传完成！');

            // console.log('第' + file.index + '文件上传完成!');
        },
        // 设置图片类型文件View模板
        setImageTpl : function(data) {
            var tpl = opts.tpl('image', 1);
            $('#uList').html($('#uList').html() + tpl);
            var thisLi = $('#uList li').eq(data.file.index);
            thisLi.find('.image img').attr('src', data.fileReaderiImage.target.result);
            thisLi.find('.fileName').text(data.file.name);
            thisLi.find('.imageSize text').text(data.newImage.width + ' X ' + data.newImage.height);
            thisLi.find('.fileSize text').text(data.fileSize);
            thisLi.find('.fileType text').text(data.fileType);

        },
        // 设置其他文件类型View模板
        setOtherTpl : function(data) {
            var tpl = opts.tpl('other', 1);
            $('#uList').html($('#uList').html() + tpl);
            var thisLi = $('#uList li').eq(data.file.index);
            thisLi.find('.fileName text').text(data.file.name);
            thisLi.find('.fileSize text').text(data.fileSize);
            thisLi.find('.fileType text').text(data.fileType);
        },
        // 上传状态改变时触发
        stageChange : function(file) {
            var uList = $('#uList li').eq(file.index);
            uList.find('.progress').show();
            uList.find('.stage text').html('正在被上传');
            // console.log(file.index + '正在被上传');
        } // 当开启队列上传时可以知道那个文件正在被上传

    };
    $('#event').dropFile(opts);
    $('#event #selectFile').selectFile(opts);
    $('#event').pasteFile(opts);
</script>
</body>
</html>