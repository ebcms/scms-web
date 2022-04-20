<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use App\Ebcms\Admin\Traits\ResponseTrait;
use App\Ebcms\Admin\Traits\RestfulTrait;
use DigPHP\Database\Db;
use DigPHP\Request\Request;
use DigPHP\Template\Template;

abstract class Common
{
    use RestfulTrait;
    use ResponseTrait;

    protected $site = [];

    public function __construct(
        Request $request,
        Template $template,
        Db $db
    ) {
        if (!$site = $db->get('ebcms_scms_site', '*', [
            'id' => $request->get('site_id'),
        ])) {
        }
        $this->site = $site;

        $template->assign('site', $site);
    }
}
