<h1><span class="section-icon icon-asterix"></span>{lng lng="export"}</h1>
<div id="result">

</div>

<div id="config">
    <button class="css3 button-export">{lng lng="export"}</button>
</div>


{literal}
<script type="text/javascript">

    $(".button-export").bind("click", function(){
        showBlockUI('{/literal}{lng lng="action_executed"}', '{lng lng="please_wait_"}{literal}');

        $.ajax({
                type: 'post',
                url: 'api.php',
                data: {action: 'system.manage.directory-export'},
                success: function(result) {
                        hideBlockUI(function() {
                                if(result.r == 'ok') {
                                            alert('{/literal}{lng lng="action_completed"}{literal}');
                                            $('#result').html();
                                            for (i=0;i<result.d["pathes"].length;i++)
                                            {
                                                $('#result').append(result.d["pathes"][i]+'<br />');
                                            }
                                } else {
                                        if (result.e[0]) alert(result.e[0].m);
                                }
                                $('#result').fadeTo(0, 1);
                        });
                },
                error: function() {
                        alert('{/literal}{lng lng="request_sending_failed"}{literal}');
                },
                dataType: 'json'
        });
    });

</script>
{/literal}