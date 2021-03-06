<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>手机APP下载页面：根据终端辨别下载地址</title>
    <script type="text/javascript">
        // 获取终端的相关信息
        var Terminal = {
            // 辨别移动终端类型
            platform : function(){
                var u = navigator.userAgent, app = navigator.appVersion;
                return {
                    // android终端或者uc浏览器
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                    // 是否为iPhone或者QQHD浏览器
                    iPhone: u.indexOf('iPhone') > -1 ,
                    // 是否iPad
                    iPad: u.indexOf('iPad') > -1
                };
            }(),
            // 辨别移动终端的语言：zh-cn、en-us、ko-kr、ja-jp...
            language : (navigator.browserLanguage || navigator.language).toLowerCase()
        }
    
        // 根据不同的终端，跳转到不同的地址
        var theUrl = 'http://www.cnstorm.com';
        if(Terminal.platform.android){
            theUrl = 'http://www.cnstorm.com/app/cnstorm.apk';
        }else if(Terminal.platform.iPhone){
            theUrl = 'https://itunes.apple.com/us/app/cnstorm/id914402588?l=zh&ls=1&mt=8';
        }else if(Terminal.platform.iPad){
            theUrl = 'https://itunes.apple.com/us/app/cnstorm/id914402588?l=zh&ls=1&mt=8';
        }
    
        location.href = theUrl;
    </script>
</head>
<body>
    <!--
        有啥问题，请直接到这里来反馈：http://www.cnstorm.com

        iPhone、iPad下载

        Android下载
    -->
</body>
</html>