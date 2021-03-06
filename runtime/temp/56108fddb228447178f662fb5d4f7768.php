<?php /*a:1:{s:66:"D:\phpstudy_pro\WWW\mhhy\application\admin\view\index\welcome.html";i:1609827514;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.0</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/static/admin/css/font.css">
        <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    </head>
    <body>
        <div class="x-body">
            <blockquote class="layui-elem-quote"></blockquote>
            <fieldset class="layui-elem-field">
              <legend>信息统计</legend>
              <div class="layui-field-box">
                <table class="layui-table" lay-even>
                    <thead>
                        <tr>
                            <th>统计</th>
                            <th>资讯库</th>
                            <th>图片库</th>
                            <th>产品库</th>
                            <th>用户</th>
                            <th>管理员</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>总数</td>
                            <td>92</td>
                            <td>9</td>
                            <td>0</td>
                            <td>8</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>今日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>昨日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本周</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本月</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
                <table class="layui-table">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="30%">服务器计算机名</th>
                        <td><span id="lbServerName"><?php echo htmlentities($data['hostname']); ?></span></td>
                    </tr>
                    <tr>
                        <td>服务器IP地址</td>
                        <td><?php echo htmlentities($data['ip']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器域名</td>
                        <td><?php echo htmlentities($data['domain']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器端口 </td>
                        <td><?php echo htmlentities($data['port']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器IIS版本 </td>
                        <td><?php echo htmlentities($data['versions']); ?></td>
                    </tr>
                    <tr>
                        <td>本文件所在文件夹 </td>
                        <td><?php echo __FILE__; ?></td>
                    </tr>
                    <tr>
                        <td>服务器操作系统 </td>
                        <td><?php echo htmlentities($data['uname']); ?></td>
                    </tr>
                    <tr>
                        <td>系统所在文件夹 </td>
                        <td><?php echo htmlentities($data['systemdir']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器脚本超时时间 </td>
                        <td><?php echo htmlentities($data['max_run_time']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器的语言种类 </td>
                        <td><?php echo htmlentities($data['language']); ?></td>
                    </tr>
                    <tr>
                        <td>ThinkPHP 版本 </td>
                        <td><?php echo htmlentities(app()->version()); ?></td>
                    </tr>
                    <tr>
                        <td>服务器当前时间 </td>
                        <td><?php echo htmlentities($data['time']); ?></td>
                    </tr>
                    <tr>
                        <td>服务器PHP版本 </td>
                        <td><?php echo htmlentities($data['php_vers']); ?></td>
                    </tr>
                    <tr>
                        <td>PHP脚本所有者 </td>
                        <td><?php echo htmlentities($data['course_name']); ?></td>
                    </tr>
                    <tr>
                        <td>逻辑驱动器 </td>
                        <td><?php echo htmlentities($data['diskinfo']); ?></td>
                    </tr>
                    <tr>
                        <td>PHP环境 </td>
                        <td><?php echo htmlentities($data['php_mode']); ?></td>
                    </tr>
                    <tr>
                        <td>CPU 类型 </td>
                        <td><?php echo htmlentities($data['CPUsum']); ?></td>
                    </tr>
                    <tr>
                        <td>解译引擎 </td>
                        <td><?php echo htmlentities($data['translate']); ?></td>
                    </tr>
                    <tr>
                        <td>当前程序占用内存 </td>
                        <td><?php echo htmlentities($data['internal']); ?></td>
                    </tr>
                    <tr>
                        <td>PHP所占内存 </td>
                        <td><?php echo htmlentities($data['internal']); ?></td>
                    </tr>
                    <tr>
                        <td>当前Session数量 </td>
                        <td><?php echo htmlentities($data['Sessionsum']); ?></td>
                    </tr>
                    <tr>
                        <td>当前SessionID </td>
                        <td><?php echo htmlentities($data['SessionID']); ?></td>
                    </tr>
                    <tr>
                        <td>当前系统用户名 </td>
                        <td>NETWORK SERVICE</td>
                    </tr>
                </tbody>
            </table>
              </div>
            </fieldset>
            <blockquote class="layui-elem-quote layui-quote-nm">wsn-提供</blockquote>
            
        </div>
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
    </body>
</html>