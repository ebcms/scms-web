<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use DigPHP\Request\Request;
use DigPHP\Template\Template;

class Cate extends Common
{
    public function get(
        Request $request,
        Template $template,
        Column $columnModel,
        Field $fieldModel,
        Data $dataModel,
        Cate $cateModel,
        Area $areaModel,
        Content $contentModel
    ) {
        $where = [];
        $where['site_id'] = $this->site['id'];

        if (!$column = $columnModel->get('*', [
            'name' => $request->get('column'),
        ])) {
            return $this->error('栏目不存在~');
        }
        $template->assign('column', $column);
        $where['column_id'] = $column['id'];

        $fields = $fieldModel->select('*', [
            'model_id' => $column['model_id'],
            'is_filter' => 1,
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        foreach ($fields as &$vo) {
            $vo['data'] = $dataModel->select('*', [
                'field_id' => $vo['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ]
            ]);
        }
        unset($vo);
        $template->assign('fields', $fields);

        if ($cate = $cateModel->get('*', [
            'column_id' => $column['id'],
            'name' => $request->get('cate'),
        ])) {
            $template->assign('cate', $cate);
            // todo 所有子栏目
            $where['cate_id'] = $cate['id'];
        }

        if ($area = $areaModel->get('*', [
            'site_id' => $this->site['id'],
            'name' => $request->get('area'),
        ])) {
            $template->assign('area', $area);
            // todo 所有子区域
            $where['area_id'] = $area['id'];
        }

        foreach ($fields as $vo) {
            if ($vo['type'] == 'type1') {
                if ($request->has('get.' . $vo['name'])) {
                    $tmp = $request->get($vo['name']);
                    if (is_string($tmp) && strlen($tmp)) {
                        $where[$vo['field']] = $dataModel->get('value', [
                            'field_id' => $vo['id'],
                            'name' => $tmp
                        ]);
                    }
                }
            } elseif ($vo['type'] == 'type2') {
                if ($request->has('get.' . $vo['name'])) {
                    $tmp = $request->get($vo['name']);
                    if (is_string($tmp) && strlen($tmp)) {
                        // $where[$vo['field']] = $dataModel->get('value', [
                        //     'field_id' => $vo['id'],
                        //     'name' => $tmp
                        // ]);
                        $x = $dataModel->get('value', [
                            'field_id' => $vo['id'],
                            'name' => $tmp
                        ]);
                        $where[] = $vo['field'] . ' & ' . $x . ' = ' . $x;
                    }
                }
            }
        }

        $where['LIMIT'] = 100;
        $where['ORDER'] = [
            'id' => 'DESC'
        ];
        $contents = $contentModel->select('*', $where);
        $template->assign('contents', $contents);

        return $template->renderFromFile('lists@ebcms/scms-web');
    }
}
