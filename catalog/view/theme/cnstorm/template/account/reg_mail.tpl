<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $login_from ?> - 补全个人信息</title>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/css/base.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-logreg.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script type="text/javascript">
function checkform() {

        var email = $.trim($('input[name=email]').val());
        var span = $('#errorMessage_email');

          if (email == '') {

            msg = '邮箱不能为空';
            span.html(msg).fadeIn();
            return false;
        } else {
            var pe = /^[^\@]+@.*\.[a-z]{2,6}$/;
            if (!email || !pe.test(email)) {
                msg = '请输入符合规范的邮箱地址';
                span.html(msg).fadeIn();
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "index.php?route=account/register/checkemail",
                    data: "email=" + email,
                    success: function(flag) {
                        if (flag) {
                            msg = "该邮箱已经存在";
                            span.html(msg).fadeIn();
                            return false;
                        } else {
                            span.addClass('none');
                            $('#reg_mail').submit();
                        }
                    }
                });
            }
        }
}
</script>
</head>
<body style="margin: 0 auto; padding: 0; width: 998px;">
<div class="rm_top"> <a href="/" class="logo"></a> <a href="/" title="返回首页" class="backHome">返回首页</a></div>
<div class="small_main">
  <div class="send_style" style="margin:100px auto 40px auto">
    <table>
      <tbody>
        <tr>
          <th><h1 class="icon_bold"></h1></th>
          <td><h2 class="msg_bold">补全个人信息</h2>
            <p>为了更好的服务于您，请补全您的<b><?php echo $login_from ?></b>的邮箱信息</p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table class="table_edit">
    <form id="reg_mail" method="post" action="/index.php?route=account/reg_mail">
    <tbody> 
      <tr>
        <th class="mailbox">邮箱：</th>
        <td><input type="text" name="email" id="reg_email" class="input_border" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
          <span id="errorMessage_email" style="padding: 3px 0 12px 20px; color:red;" class="none"></span></td>
      </tr>
      <tr>
        <th></th>
        <td>
          <input type="button" id="reg_button" value="提交" class="input_send" onClick="return checkform()"></td>
      </tr>
      </form>
    </tbody>
  </table>
</div>
</body>
