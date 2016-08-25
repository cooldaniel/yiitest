
<div>iframe test</div>




<script>
window.open('http://www.baidu.com');
</script>



<iframe id="iframeOne" src="<?php echo $this->createUrl('test/page'); ?>" height="300" width="100%"></iframe>

<script>
$(function(){
    $('#iframeOne').load(function(){
        var doc = this.contentDocument || this.contentWindow.document;
        var page = $(doc).find('#thePage').html();
        console.log(page);
    });
});
</script>


<iframe id="iframeTwo" src="http://xzhshop.local/" height="300" width="100%"></iframe>

<script>
$(function(){
    $('#iframeTwo').load(function(){
        var doc = this.contentDocument || this.contentWindow.document;
        //var page = $(doc).find('#thePage').html();
        alert(doc);
    });
});
</script>
