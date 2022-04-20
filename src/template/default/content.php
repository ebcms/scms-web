{include common/header@ebcms/scms-web}
<div id="carouselcontent" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        {foreach json_decode($content['pics']?:'[]', true) as $key => $vo}
        <button type="button" data-bs-target="#carouselcontent" data-bs-slide-to="{$key}" {if !$key}class="active" aria-current="true" {/if} aria-label="Slide {$key}"></button>
        {/foreach}
    </div>
    <div class="carousel-inner">
        {foreach json_decode($content['pics']?:'[]', true) as $key=> $vo}
        <div class="carousel-item {if !$key}active{/if}">
            <img src="{$vo.src}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>{$vo.title}</h5>
            </div>
        </div>
        {/foreach}
    </div>
</div>

<div class="container-xxl border-bottom py-3 bg-white">
    <h1 class="h4 fw-bold mb-2">{$content.title}</h1>
    <div class="text-muted" style="font-size:.8em;">{:date('Y-m-d H:i:s', $content['update_time'])} 340次</div>
</div>
<div class="container-xxl mb-2 py-3 bg-white">
    <table>
        <tbody>
            {foreach $fields as $vo}
            {if $vo['is_filter']}
            <tr>
                <td class="text-muted">{$vo.title}：</td>
                <td>{$vo.name}</td>
            </tr>
            {/if}
            {/foreach}
        </tbody>
    </table>
</div>
<div class="container-xxl bg-white py-3 border-bottom">
    <div class="fs-6 fw-bold">联系方式</div>
    <table>
        <tbody>
            <tr>
                <td class="text-muted">联系QQ：</td>
                <td>154255652</td>
            </tr>
            <tr>
                <td class="text-muted">联系电话：</td>
                <td>154255652</td>
            </tr>
            <tr>
                <td class="text-muted">微信号：</td>
                <td>154255652</td>
            </tr>
        </tbody>
    </table>
    <div class="border border-warning bg-warning bg-opacity-10 px-2 py-1 text-danger">联系我的时候，请说你在xx网站上面看到的！</div>
</div>
<div class="container-xxl bg-white mb-2 py-3">
    <div class="d-flex gap-3">
        <div class="text-center">
            <div><img src="http://m.demo1.mayicms.com/template/images/jubao.gif" alt=""></div>
            <div>举报</div>
        </div>
        <div>
            <div class="text-danger fw-bold">如遇无效、虚假、诈骗信息，请立即举报</div>
            <div class="text-muted" style="font-size:.9em;">为了您的资金安全，请见面交易，切勿提前支付任何费用</div>
        </div>
    </div>
</div>

<div class="container-xxl bg-white py-3">
    <div class="fs-6 fw-bold">详细信息</div>
    <table>
        <tbody>
            {foreach $fields as $vo}
            {if !$vo['is_filter']}
            <tr>
                <td class="text-muted">{$vo.title}：</td>
                <td>{$vo.name}</td>
            </tr>
            {/if}
            {/foreach}
        </tbody>
    </table>
    <div>{$content.detail}</div>
</div>
{include common/footer@ebcms/scms-web}