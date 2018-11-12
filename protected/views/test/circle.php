
<div class="test" style="background-color: #0DA434; width: 100px; height: 100px;"></div>

<script>
    $(document).ready(function () {
        
        function moving(obj) {

            var $i = 1;
            var $left = '';
            var $top = '';
            var callback = function () {};

            while(1) {

                if ($i > 4) {
                    break;
                }

                if ($i == 1 || $i == 2) {
                    $left = '100px';
                } else {
                    $left = '0px';
                }

                if ($i == 1 || $i == 4) {
                    $top = '0px';
                } else {
                    $top = '100px';
                }

                if ($i == 4) {
                    callback = function () {
                        moving(obj);
                    }
                } else {
                    callback = function () {};
                }

                $(obj).animate({
                    left:'0px',
                    opacity:'1',
                    height:'100px',
                    width:'100px',
                    "margin-left":$left,
                    "margin-top":$top,
                    "margin-right":'0px',
                    "margin-bottom":'0px'
                }, callback);

                $i++;
            }
        }

        $(".test").toggle(function () {
            moving(this);
        }, function () {
            $(this).stop();
        });
    });
</script>