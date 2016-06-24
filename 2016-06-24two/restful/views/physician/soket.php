<?php echo json_encode($list) ;?>
<html>
<body>
<script type="text/javascript" src="jquery1-8-0.js"></script>
<script>
     $(document).ready(function(){

         // 创建一个Socket实例
         var socket = new WebSocket('ws://101.200.232.66:8000');
        // 打开Socket
         socket.onopen = function(event) {
             // 发送一个初始化消息
             socket.send(<?php echo json_encode($soket)?>);
             // 监听Socket的关闭
             socket.onclose = function(event) {
                 console.log('Client notified socket has closed',event);
             };
             // 关闭Socket....
             //socket.close()
         };
     })
</script>
</body>
</html>