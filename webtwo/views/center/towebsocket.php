<div id="aaa"></div>
<meta charset="UTF-8" />
<script src='http://cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script src="jquery1-8-0.js"></script>
<script>
    // 连接服务端
    var socket = io('http://workerman.net:2120');
    // uid可以是自己网站的用户id，以便针对uid推送以及统计在线人数
    uid = 123;
    // socket连接后以uid登录
    socket.on('connect', function(){
        socket.emit('login', uid);
    });
    // 后端推送来消息时
    socket.on('new_msg', function(msg){
        console.log("收到消息："+msg);
        $("#aaa").html(msg);
    });
    // 后端推送来在线数据时
    socket.on('update_online_count', function(online_stat){
        console.log(online_stat);
    });
</script>