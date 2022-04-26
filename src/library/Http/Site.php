<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use DiggPHP\Database\Db;
use DiggPHP\Template\Template;

class Site extends Common
{
    public function get(
        Template $template,
        Db $db
    ) {
        $sites = $db->select('ebcms_scms_site', '*', [
            'state' => 1,
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        return $this->html($template->renderFromFile('site@ebcms/scms-web', [
            'sites' => $sites
        ]));
    }
}
