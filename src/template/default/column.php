<?php
function to_level(array $data): array
{
    $res = [];
    $level_fun = function (array $data, $pid, $level, &$res) use (&$level_fun) {
        foreach ($data as $vo) {
            if ($vo['pid'] == $pid) {
                $vo['_level'] = $level;
                $res[] = $vo;
                $level_fun($data, $vo['id'], $level + 1, $res);
            }
        }
    };
    $level_fun($data, 0, 0, $res);
    return $res;
}
?>
{include common/header@ebcms/scms-web}
<div class="container-xxl bg-light fixed-top" style="top:40px;">
    <div class="d-flex justify-content-between gap-2 py-2">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {$column['title']}
            </a>

            <div class="dropdown-menu overflow-auto p-3" style="max-height:400px;width:360px;">
                <div class="mb-2 d-flex gap-2 flex-wrap">
                    {foreach $columns as $vo}
                    <div class="position-relative">
                        <img src="{$vo.logo}" class="rounded-4 img-thumbnail" style="max-width:120px;max-height:120px;" alt="{$vo['title']}">
                        <div class="text-center mt-1 text-nowrap text-truncate">
                            <a href="{echo $router->build('/ebcms/scms-web/column',['column'=>$vo['name'],'site_id'=>$site['id']])}" class="stretched-link ">{$vo.title}</a>
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {$cate['title']??'不限'}
            </a>
            <ul class="dropdown-menu overflow-auto" style="max-height:400px;">
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/column',array_merge($request->get(), ['cate'=>null, 'page'=>null]))}">不限</a></li>
                {foreach $cates as $vo}
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/cate',array_merge($request->get(), ['cate'=>$vo['name'], 'page'=>null]))}">{$vo.title}</a></li>
                {/foreach}
            </ul>
        </div>
        <div class="dropdown">
            <?php
            $areas = to_level($areas);
            ?>
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {$area['title']??'不限'}
            </a>

            <ul class="dropdown-menu overflow-auto" style="max-height:400px;">
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/column',array_merge($request->get(), ['area'=>null, 'page'=>null]))}">不限</a></li>
                {foreach $areas as $vo}
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/column',array_merge($request->get(), ['area'=>$vo['name'], 'page'=>null]))}">{:str_repeat('ㅤ', $vo['_level'])}{$vo.title}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
</div>

<div style="height:50px;"></div>

<div class="">
    <div class="border-top">
        {foreach $contents as $vo}
        <div class="container-xxl d-flex flex-column gap-3 py-3 border-bottom">
            <div class="d-flex border-bottom pb-3">
                <div class="">
                    <img src="https://fuckusa.club/upload/2022/03-25/623d5b08a0949.png" width="50" height="50" alt="">
                </div>
                <div class="ms-2">
                    <div class="fw-bold">张三丰</div>
                    <div>
                        <span class="text-light bg-primary bg-gradient rounded-1" style="padding:0px 2px;">置顶</span>
                        <span class="text-light bg-secondary bg-gradient rounded-1" style="padding:0px 2px;">渠县</span>
                        <span class="text-light bg-success bg-gradient rounded-1" style="padding:0px 2px;">招聘</span>
                    </div>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-danger text-nowrap" href="tel:18888888888"><img src="http://m.demo1.mayicms.com/template/images/phonegb.gif" alt="" width="18"> 拨打电话</a>
                </div>
            </div>
            <div class="d-flex flex-column gap-2 position-relative">
                <div class="text-muted">
                    <a href="{echo $router->build('/ebcms/scms-web/content', ['site_id'=>$site['id'], 'content_id'=>$vo['content_id']])}" class="stretched-link">{$vo.title}</a>
                </div>
                <div class="">
                    <span class="text-primary">招聘</span>
                    <span class="text-secondary">3000-5000</span>
                    <span class="text-success">双休</span>
                    <span class="text-danger">社保</span>
                </div>
                {if $_pics=json_decode($vo['pics']?:'[]', true)}
                <div class="d-flex gap-2 flex-wrap">
                    {foreach $_pics as $vp}
                    <div>
                        <img src="{$vp.src}" class="rounded-4 img-thumbnail" style="max-width:120px;max-height:120px;" alt="{$vp['title']?:$vo['title']}">
                    </div>
                    {/foreach}
                </div>
                {/if}
            </div>
            <div class="bg-secondary bg-gradient bg-opacity-10 p-2 text-muted" style="font-size:.8em;">
                49 浏览 0 点赞 18 收藏 <span class="float-end">{:date('Y-m-d', $vo['update_time'])}</span>
            </div>
        </div>
        {/foreach}
    </div>
</div>
{include common/footer@ebcms/scms-web}