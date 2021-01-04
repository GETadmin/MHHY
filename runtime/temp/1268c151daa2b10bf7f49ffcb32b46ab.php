<?php /*a:1:{s:64:"D:\phpstudy_pro\WWW\mhhy\application\admin\view\login\index.html";i:1609230444;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
	<link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>

</head>
<body class="login-bg">
    
    <div class="login">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required|username" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required|pass" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            var url = "<?php echo url('admin/Login/logindispose'); ?>";
            layui.use('form', function(){
              var form = layui.form;
              // layer.msg('玩命卖萌中', function(){
              //   //关闭后的操作
              //   });
                //验证器
                form.verify({
                    username: function(value, item){ //value：表单的值、item：表单的DOM对象
                        if(/(^\_)|(\__)|(\_+$)/.test(value)){
                            return '用户名不能有特殊字符';
                        }
                        if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                            return '用户名不能有特殊字符';
                        }
                        if(/(^\_)|(\__)|(\_+$)/.test(value)){
                            return '用户名首尾不能出现下划线\'_\'';
                        }
                        if(/^\d+\d+\d$/.test(value)){
                            return '用户名不能全为数字';
                        }

                        //如果不想自动弹出默认提示框，可以直接返回 true，这时你可以通过其他任意方式提示（v2.5.7 新增）
                        if(value === 'xxx'){
                            alert('用户名不能为敏感词');
                            return true;
                        }
                    }

                    //我们既支持上述函数式的方式，也支持下述数组的形式
                    //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
                    ,pass: [
                        /^[\S]{6,12}$/
                        ,'密码必须6到12位，且不能出现空格'
                    ]
                });
              //监听提交
              form.on('submit(login)', function(data){
                $.ajax({
                    type: "post",
                    url: url,
                    data: data.field,
                    dataType: "json",
                    success: function (datas) {
                        layer.msg(datas.msg, {
                            icon: 1,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            if (datas.code == 1) {
                                location.href = datas.url
                            } else {
                                location.href = location.href;
                            }
                        });
                    },
                    error : function() {
                        layer.msg('异常', {icon: 5});
                    }
                });
                return false;
              });
            });
        })
    </script>

    
    <!-- 底部结束 -->
    <!--<script>-->
    <!--//百度统计可去掉-->
    <!--var _hmt = _hmt || [];-->
    <!--(function() {-->
      <!--var hm = document.createElement("script");-->
      <!--hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";-->
      <!--var s = document.getElementsByTagName("script")[0]; -->
      <!--s.parentNode.insertBefore(hm, s);-->
    <!--})();-->
    <!--</script>-->
</body>
</html>