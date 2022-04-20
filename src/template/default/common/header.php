<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        a {
            text-decoration: none;
            color:indianred;
        }

        .breadcrumb {
            color: #6c757d;
        }

        .breadcrumb a {
            color: #6c757d;
        }
    </style>
</head>

<body style="background:#f5f5f5;">
    <div class="bg-danger text-white fixed-top">
        <div class="container-xxl">
            <div class="position-relative py-2 overflow-hidden" style="height: 40px;">
                <span class="position-absolute top-50 start-0 translate-middle-y"><a href="{echo $router->build('/ebcms/scms-web/site', ['site_id'=>$site['id']])}" class="text-white dropdown-toggle"><svg class="icon" style="width: 1.2em;height: 1.2em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5463"><path d="M494.53 108.25c-182.81 0-331.01 148.2-331.01 331.01s331.01 484.1 331.01 484.1 331.01-301.28 331.01-484.1c0-182.81-148.2-331.01-331.01-331.01z m120.45 601.98c-44.48 52.85-89.42 99.28-120.45 130-31.03-30.72-75.97-77.15-120.45-130-45.54-54.11-81.58-104.12-107.12-148.62-35.91-62.56-43.44-101.06-43.44-122.35 0-36.61 7.16-72.1 21.27-105.47 13.65-32.27 33.2-61.25 58.11-86.16 24.91-24.91 53.9-44.46 86.16-58.11 33.37-14.12 68.86-21.27 105.47-21.27s72.1 7.16 105.47 21.27c32.27 13.65 61.25 33.2 86.16 58.11 24.91 24.91 44.46 53.9 58.11 86.16 14.12 33.37 21.27 68.86 21.27 105.47 0 21.28-7.54 59.79-43.44 122.35-25.54 44.51-61.58 94.51-107.12 148.62z" p-id="5464"></path><path d="M494.53 278.66c-81.31 0-147.22 65.91-147.22 147.22S413.22 573.1 494.53 573.1s147.22-65.91 147.22-147.22-65.91-147.22-147.22-147.22z m0 234.44c-48.09 0-87.22-39.13-87.22-87.22 0-48.09 39.13-87.22 87.22-87.22s87.22 39.13 87.22 87.22c0 48.09-39.13 87.22-87.22 87.22z" p-id="5465"></path></svg>{$site.title}</a></span>
                <span class="position-absolute top-50 start-50 translate-middle"><a href="{echo $router->build('/ebcms/scms-web/index', ['site_id'=>$site['id']])}" class="text-white fw-bold">分类信息网</a></span>
                <span class="position-absolute top-50 end-0 translate-middle-y">登录</span>
            </div>
        </div>
    </div>
    <div style="height:40px;"></div>