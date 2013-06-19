<h2>{lng lng="user_statistics"}{* <span class="icon-info" onclick="alert('This is help')"></span>*}</h2>
<table class="vert-lines w100" cellspacing="0">
        <col>
        <col width="50">
        <col width="50">
        <col width="50">
        <col width="50">
        <thead>
                <tr>
                        {foreach from=$labels item="label"}
                            <th><strong>{$label}</strong></th>
                        {/foreach}
                </tr>
        </thead>
        <tbody>
                {foreach from=$stats item="stat" key="cat"}
                <tr>
                        <th>{$stat.label}</th>
                        <td><a href="{link action=user.manage.home" status=$cat date_start=$stat.today.date_start date_end=$stat.today.date_end}">{$stat.today.count}</a></td>
                        <td><a href="{link action="user.manage.home" status=$cat date_start=$stat.week.date_start date_end=$stat.week.date_end}">{$stat.week.count}</a></td>
                        <td><a href="{link action="user.manage.home" status=$cat date_start=$stat.month.date_start date_end=$stat.month.date_end}">{$stat.month.count}</a></td>
                        <td><a href="{link action="user.manage.home" status=$cat}">{$stat.total.count}</a></td>
                </tr>
                {/foreach}
        </tbody>
</table>