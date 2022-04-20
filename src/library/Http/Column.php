<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use DigPHP\Database\Db;
use DigPHP\Request\Request;
use DigPHP\Template\Template;

class Column extends Common
{
    public function get(
        Request $request,
        Template $template,
        Db $db
    ) {
        $where = [];
        $where['site_id'] = $this->site['id'];

        if (!$column = $db->get('ebcms_scms_column', '*', [
            'name' => $request->get('column'),
        ])) {
            return $this->error('栏目不存在~');
        }
        $template->assign('column', $column);
        $where['column_id'] = $column['id'];

        $cates = $db->select('ebcms_scms_cate', '*', [
            'column_id' => $column['id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        $template->assign('cates', $cates);

        $columns = $db->select('ebcms_scms_column', '*', [
            'site_id' => $column['site_id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        $template->assign('columns', $columns);

        $areas = $db->select('ebcms_scms_area', '*', [
            'site_id' => $column['site_id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        $template->assign('areas', $areas);

        $where['LIMIT'] = 100;
        $where['ORDER'] = [
            'id' => 'DESC'
        ];
        $contents = $db->select('ebcms_scms_content', '*', $where);
        $template->assign('contents', $contents);

        return $template->renderFromFile('column@ebcms/scms-web');
    }
}
