<h1><span class="section-icon icon-asterix"></span> {lng lng="xml_sitemap_generator"}</h1>
<form name="generator" id="generator">
    <fieldset>
        <div class="field">
            <button class="css3 button-generator">{lng lng="generate"}</button>
        </div>
    </fieldset>
</form>

{literal}
    <script type="text/javascript">
        $(".button-generator").bind("click", function(){
            PinaSkin.showModalMessage('{/literal}{lng lng="action_executed"}', '{lng lng="please_wait_"}{literal}');

            $.ajax({
                    type: 'post',
                    url: 'api.php',
                    data: {
                        action: 'xml-sitemap.manage.generate',
                    },
                    success: function(result) {
                            PinaSkin.hideModalMessage(function(){
                                    if(result.r == 'ok') {
                                        alert('{/literal}{lng lng="action_completed"}{literal}');
                                    } else {
                                        alert('{/literal}{lng lng="error"}{literal}');
                                    }
                            });
                    },
                    error: function() {
                            alert('{/literal}{lng lng="request_sending_failed"}{literal}');
                    },
                    dataType: 'json'
            });
            return false;
        });
    </script>
{/literal}