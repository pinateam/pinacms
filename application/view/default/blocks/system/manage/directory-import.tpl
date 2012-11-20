<h1><span class="section-icon icon-asterix"></span> {lng lng="import"}</h1>
<div id="config">
    <form name="import" id="import">
        <fieldset>
             <div class="field">
                <label for="coding">{lng lng="path"}</label>
                {include file="skin/admin/splitter-input.tpl" name="path" id="path" items=$pathes title="path"|lng value="directory"}
            </div>
            <div class="field">
            </div>
            <div class="field">
                <label for="coding">{lng lng="codepage"}</label>
                {include file="skin/admin/splitter-input.tpl" name="coding" id="coding" items=$codings title="codepage"|lng value="UTF-8"}
            </div>
            <div class="field">
            <button class="css3 button-import">{lng lng="import"}</button>
            </div>
        </fieldset>
    </form>

</div>

{literal}
    <script type="text/javascript">
        $(".button-import").bind("click", function(){
            showBlockUI('{/literal}{lng lng="action_executed"}', '{lng lng="please_wait_"}{literal}');
            var data = $("#import").getData();

            $.ajax({
                    type: 'post',
                    url: 'api.php',
                    data: {action: 'system.manage.directory-import',
                           data: data,
                    },
                    success: function(result) {
                            hideBlockUI(function(){
                                    if(result.r == 'ok' && result.d.result) {
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