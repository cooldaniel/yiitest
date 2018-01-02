

<br/>
<h1>Test data and validation report.</h1>

<br/>
<p>Model name: <i style="color:#BF2323"><?php echo get_class($model); ?></i>.</p>

<style>
span.error{
    color: #BF2323;
    font-weight: bold;
}
</style>

<?php
$dataProvider = new CArrayDataProvider($data);
$dataProvider->keyField = 'code';
$this->widget('zii.widgets.grid.CGridView', [
    'dataProvider'=>$dataProvider,
    'columns'=>array_merge([
            [
                'name'=>'Row ID',
                'value'=>'$row+1',
            ]
        ], array_keys(reset($data))
    ),
]);
?>

<script>

/**
 * Deal with the error information using js because can not do this by rendering the widget.
 */

$(function(){

    /**
     * Deal with the error information by each tr.
     */
    $('table.items tbody').find('tr').each(function () {

        var headers = getHeaders();
        var tr = $(this);

        // The last td is the errors container column
        var lastTd = tr.find('td').last();
        var errors = lastTd.text();

        // No error
        if (errors == '[]') {
            lastTd.html('');
            return;
        }

        // Having error
        errors = $.parseJSON(errors);

        // Mark the error columns value
        for (var i=0; i<headers.length; i++) {
            // Search the column error and mark the corresponding td if found
            name = headers[i];

            if (errors[name] != undefined) {
                // The current td
                var td = $(tr.find('td')[i]);
                if ($.trim(td.text()) == '') {
                    // The td value is empty, mark as *
                    td.html('<span class="error">*</span>')
                } else {
                    // The td value is not empty
                    td.html('<span class="error">'+td.text()+'</span>')
                }
            }
        }

        // Transfer the errors array as plain list
        var html = '';
        for (var i=0; i<headers.length; i++) {
            name = headers[i];

            if (errors[name] != undefined) {
                console.log(errors[name]);
                html += '<div>'+errors[name]+'</div>';
            }
        }
        lastTd.html(html);
    });

    /**
     * Get the th cells text from the tables.
     */
    function getHeaders() {
        var headers = [];
        $('table.items').find('th').each(function () {
            headers.push($(this).text());
        });
        return headers;
    }

});
</script>
