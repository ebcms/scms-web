{include common/header@ebcms/scms-web}
<div id="carouselExampleCaptions" class="carousel slide mb-3" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="http://demo.mymps.com.cn/attachment/focus/1264065647ohvmy.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Some representative placeholder content for the first slide.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="http://demo.mymps.com.cn/attachment/focus/1264065647ohvmy.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Some representative placeholder content for the second slide.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="http://demo.mymps.com.cn/attachment/focus/1264065647ohvmy.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php
$columns = $db->select('ebcms_scms_column', '*', [
    'site_id' => $site['id'],
    'ORDER' => [
        'rank' => 'DESC',
        'id' => 'ASC',
    ],
]);
?>
<div class="container-xxl mb-3">
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

<?php
$contents = $db->select('ebcms_scms_content', '*', [
    'site_id' => $site['id'],
    'ORDER' => [
        'id' => 'DESC',
    ],
]);
?>
<div class="container-xxl">
    {foreach $contents as $vo}
    <div class="mb-1 d-flex">
        <div>▪</div>
        <div class="ms-2">
            <a class="fw-light h6" href="{echo $router->build('/ebcms/scms-web/content', ['site_id'=>$site['id'], 'content_id'=>$vo['content_id']])}">{$vo.title}</a>
        </div>
    </div>
    {/foreach}
</div>
{include common/footer@ebcms/scms-web}