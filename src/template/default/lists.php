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
                <?php
                $columnModel = $container->get(\App\Ebcms\Scms\Model\Column::class);
                $cateModel = $container->get(\App\Ebcms\Scms\Model\Cate::class);
                $columns = $columnModel->select('*', [
                    'site_id' => $site['id'],
                    'ORDER' => [
                        'rank' => 'DESC',
                        'id' => 'ASC',
                    ],
                ]);
                ?>
                <div class="mb-2 d-flex gap-2 flex-wrap">
                    {foreach $columns as $vo}
                    <div class="position-relative">
                        <img src="{$vo.logo}" class="rounded-4 img-thumbnail" style="max-width:120px;max-height:120px;" alt="{$vo['title']}">
                        <div class="text-center mt-1 text-nowrap text-truncate">
                            <a href="{echo $router->build('/ebcms/scms-web/lists',['column'=>$vo['name'],'site_id'=>$site['id']])}" class="stretched-link ">{$vo.title}</a>
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
            <?php
            $cates = $cateModel->select('*', [
                'column_id' => $column['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ],
            ]);
            ?>
            <ul class="dropdown-menu overflow-auto" style="max-height:400px;">
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/lists',array_merge($request->get(), ['cate'=>null, 'page'=>null]))}">不限</a></li>
                {foreach to_level($cates) as $vo}
                {if $vo['column_id'] == $column['id']}
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/lists',array_merge($request->get(), ['cate'=>$vo['name'], 'page'=>null]))}">{:str_repeat('ㅤ', $vo['_level'])}{$vo.title}</a></li>
                {/if}
                {/foreach}
            </ul>
        </div>
        <div class="dropdown">
            <?php
            $areaModel = $container->get(\App\Ebcms\Scms\Model\Area::class);
            $areas = $areaModel->select('*', [
                'site_id' => $site['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ],
            ]);
            $areas = to_level($areas);
            ?>
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {$area['title']??'不限'}
            </a>

            <ul class="dropdown-menu overflow-auto" style="max-height:400px;">
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/lists',array_merge($request->get(), ['area'=>null, 'page'=>null]))}">不限</a></li>
                {foreach $areas as $vo}
                <li><a class="dropdown-item" href="{echo $router->build('/ebcms/scms-web/lists',array_merge($request->get(), ['area'=>$vo['name'], 'page'=>null]))}">{:str_repeat('ㅤ', $vo['_level'])}{$vo.title}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
</div>

<div style="height:50px;"></div>

<div class="container-xxl mb-3">
    <?php
    function get_pdata(array $data, array $item, array &$pdata = []): array
    {
        $pdata[] = $item;
        if ($item['pid']) {
            foreach ($data as $value) {
                if ($value['id'] == $item['pid']) {
                    get_pdata($data, $value, $pdata);
                    break;
                }
            }
        }
        return $pdata;
    }
    function get_subdata(array $data, $pid): array
    {
        $res = [];
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $res[] = $value;
            }
        }
        return $res;
    }
    ?>
    <form action="" id="filter">
        <div class="d-flex flex-column gap-2">
            {foreach $fields as $vo}
            {if $vo['type'] == 'type1'}
            <div>
                <div class="bg-secondary bg-gradient bg-opacity-10 py-1 px-2 mb-1">
                    <span class="text-danger fw-bold">{$vo.title}</span>
                </div>
                <div>
                    <?php
                    $_select = [];
                    if ($request->get($vo['name'])) {
                        foreach ($vo['data'] as $tmp) {
                            if ($tmp['name'] == $request->get($vo['name'])) {
                                $_select = $tmp;
                                break;
                            }
                        }
                    }
                    $_pdata = $_select ? get_pdata($vo['data'], $_select) : [];
                    $_subdata = get_subdata($vo['data'], $_select ? $_select['id'] : 0);
                    ?>

                    {php $_parent = []}
                    {foreach array_reverse($_pdata) as $vo1}
                    <div class="d-flex flex-wrap gap-1">
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$_parent['name']??''}" id="{$vo.name}_{$vo1['pid']}" autocomplete="off">
                        <label for="{$vo.name}_{$vo1['pid']}"><span class="badge text-muted">不限</span></label>
                        {foreach $vo['data'] as $vo2}
                        {if $vo2['pid'] == $vo1['pid']}
                        {if $vo2['id'] == $vo1['id']}
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$vo2.name}" id="{$vo.name}_{$vo2.name}" autocomplete="off" checked>
                        <label for="{$vo.name}_{$vo2.name}"><span class="badge bg-secondary">{$vo2.title}</span></label>
                        {else}
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$vo2.name}" id="{$vo.name}_{$vo2.name}" autocomplete="off">
                        <label for="{$vo.name}_{$vo2.name}"><span class="badge text-muted">{$vo2.title}</span></label>
                        {/if}
                        {/if}
                        {/foreach}
                    </div>
                    {php $_parent = $vo1}
                    {/foreach}

                    {if $_subdata}
                    <div class="d-flex flex-wrap gap-1">
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$_parent['name']??''}" id="{$vo.name}_{$_parent['id']??'0'}" autocomplete="off" checked>
                        <label for="{$vo.name}_{$_parent['id']??'0'}"><span class="badge bg-secondary">不限</span></label>
                        {foreach $_subdata as $vl}
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$vl.name}" id="{$vo.name}_{$vl.name}" autocomplete="off">
                        <label for="{$vo.name}_{$vl.name}"><span class="badge text-muted">{$vl.title}</span></label>
                        {/foreach}
                    </div>
                    {/if}
                </div>
            </div>
            {elseif $vo['type'] == 'type2'}
            <div>
                <div class="bg-secondary bg-gradient bg-opacity-10 py-1 px-2 mb-1">
                    <span class="text-danger fw-bold">{$vo.title}</span>
                </div>
                <div>
                    <div class="d-flex flex-wrap gap-1">
                        {if $request->get($vo['name'])}
                        <input type="radio" class="d-none" name="{$vo.name}" value="" id="{$vo.name}_" autocomplete="off">
                        <label for="{$vo.name}_"><span class="badge text-muted">不限</span></label>
                        {else}
                        <input type="radio" class="d-none" name="{$vo.name}" value="" id="{$vo.name}_" autocomplete="off" checked>
                        <label for="{$vo.name}_"><span class="badge bg-secondary">不限</span></label>
                        {/if}
                        {foreach $vo['data'] as $vl}
                        {if in_array($vl['name'], (array)$request->get($vo['name']))}
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$vl.name}" id="{$vo.name}_{$vl.name}" autocomplete="off" checked>
                        <label for="{$vo.name}_{$vl.name}"><span class="badge bg-secondary">{$vl.title}</span></label>
                        {else}
                        <input type="radio" class="d-none" name="{$vo.name}" value="{$vl.name}" id="{$vo.name}_{$vl.name}" autocomplete="off">
                        <label for="{$vo.name}_{$vl.name}"><span class="badge text-muted">{$vl.title}</span></label>
                        {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
            {elseif $vo['type'] == 'type3'}
            <div>
                <div class="bg-secondary bg-gradient bg-opacity-10 py-1 px-2 mb-1">
                    <span class="text-danger fw-bold">{$vo.title}</span>
                </div>
                <div>
                    <div class="d-flex flex-wrap gap-1">
                        {if $request->get($vo['name'])}
                        <input type="radio" class="d-none" id="{$vo.name}_" autocomplete="off">
                        <label for="{$vo.name}_" onclick="$(this).siblings('input').removeAttr('checked')"><span class="badge text-muted">不限</span></label>
                        {else}
                        <input type="radio" class="d-none" id="{$vo.name}_" autocomplete="off" checked>
                        <label for="{$vo.name}_" onclick="$(this).siblings('input').removeAttr('checked')"><span class="badge bg-secondary">不限</span></label>
                        {/if}
                        {foreach $vo['data'] as $vl}
                        {if in_array($vl['name'], (array)$request->get($vo['name']))}
                        <input type="checkbox" class="d-none" name="{$vo.name}[]" value="{$vl.name}" id="{$vo.name}_{$vl.name}" autocomplete="off" checked>
                        <label for="{$vo.name}_{$vl.name}"><span class="badge bg-secondary">{$vl.title}</span></label>
                        {else}
                        <input type="checkbox" class="d-none" name="{$vo.name}[]" value="{$vl.name}" id="{$vo.name}_{$vl.name}" autocomplete="off">
                        <label for="{$vo.name}_{$vl.name}"><span class="badge text-muted">{$vl.title}</span></label>
                        {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
    </form>
    <script>
        $(function() {
            $("#filter input").on("change", function() {
                $("#filter").submit();
            });
        });
    </script>
</div>

<div class="">
    <div class="border-top">
        {foreach $contents as $vo}
        <div class="container-xxl d-flex flex-column gap-3 py-3 border-bottom">
            <div class="d-flex border-bottom pb-3">
                <div class="">
                    <img src="http://demo1.mayicms.com/attachment/face/201904/pre_15548147269b1d0.jpg" width="50" height="50" alt="">
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
                    <a href="{echo $router->build('/ebcms/scms-web/content', ['site_id'=>$site['id'], 'cid'=>$vo['cid']])}" class="stretched-link">{$vo.title}</a>
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