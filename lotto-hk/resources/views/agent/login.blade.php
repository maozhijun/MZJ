<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.js"></script>
    <script src="{{ url('/js/sha1.js') }}"></script>
    <script src="{{ url('/js/alert.js') }}"></script>
</head>
<body>
<div data-role="page" id="main">
    <div data-role="header">
        <h1 class="title">代理后台登录</h1>
    </div>
    <div role="main" class="ui-content">
        <form method="post" action="/agent/auth/" onsubmit="return verifyForm(this);" data-ajax='false'>
            {{ csrf_field() }}
            <input type="hidden" name="target" value="{{ $target }}">
            <label for="phone">手机号码:</label>
            <input type="number" name="phone" id="phone" value="{{ $phone }}">
            <label for="password">密码:</label>
            <input type="password" data-clear-btn="true" name="password" id="password" value="">
            <label>
                <input type="checkbox" name="keep_online">保持登录状态
            </label>
            <input type="submit" data-theme="b" value="登录">
        </form>
    </div>
</div>
</body>
<script>
    function verifyForm(form) {
        if ($.trim(form.phone.value) === '' || $.trim(form.password.value) === '') {
            LAlert('手机号码或者密码不能为空', 'b');
            return false;
        }
        form.password.value = hex_sha1($.trim(form.password.value));
        return true;
    }
</script>
@if(isset($error))
    <script>
        $(function () {
            LAlert('{{ $error }}', 'b');
        });
    </script>
@endif
</html>