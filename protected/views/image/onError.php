
<p>通过onerror加载默认图片</p>

<img src="/imgNotExists.png" class="SomeImg" />
<script>
    $(function () {
        $('.SomeImg').error(function (event) {
            event.preventDefault();
            $(this).attr('src', '/monkey.gif');
        });
    });
</script>