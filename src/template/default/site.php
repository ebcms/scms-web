{include common/header@ebcms/scms-web}
<div class="container-xxl">
    {foreach $sites as $tmp}
    <div class="h2 my-3">test</div>
    <div class="d-flex flex-wrap gap-3">
        {foreach $sites as $vo}
        <a href="{echo $router->build('/ebcms/scms-web/index', ['site_id'=>$vo['id']])}">{$vo.title}</a>
        {/foreach}
    </div>
    {/foreach}
</div>
{include common/footer@ebcms/scms-web}