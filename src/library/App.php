<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb;

use App\Ebcms\ScmsWeb\Http\Cate;
use App\Ebcms\ScmsWeb\Http\Column;
use App\Ebcms\ScmsWeb\Http\Content;
use App\Ebcms\ScmsWeb\Http\Index;
use App\Ebcms\ScmsWeb\Http\Site;
use DiggPHP\Database\Db;
use DiggPHP\Framework\AppInterface;
use DiggPHP\Router\Collector;
use DiggPHP\Router\Router;

class App implements AppInterface
{
    public static function onDispatch(
        Db $db,
        Router $router
    ) {
        foreach ($db->select('ebcms_scms_site', '*', []) as $site) {
            $router->addGroup($site['siteurl'], function (Collector $collector) {
                $collector->get('[/]', Index::class, [], [], '/ebcms/scms-web/index');
                $collector->get('/site', Site::class, [], [], '/ebcms/scms-web/site');
                $collector->get('/{content_id:[a-zA-Z\d]{13}}', Content::class, [], [], '/ebcms/scms-web/content');
                $collector->get('/{column}', Column::class, [], [], '/ebcms/scms-web/column');
                $collector->get('/{column}[/{cate}]', Cate::class, [], [], '/ebcms/scms-web/cate');
            }, [], [
                'site_id' => $site['id']
            ]);
        }
    }
}
