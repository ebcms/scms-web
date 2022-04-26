<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use App\Ebcms\Scms\Model\Area;
use App\Ebcms\Scms\Model\Cate;
use App\Ebcms\Scms\Model\Column;
use App\Ebcms\Scms\Model\Content as ModelContent;
use App\Ebcms\Scms\Model\Field;
use App\Ebcms\Scms\Model\Model;
use DiggPHP\Request\Request;
use DiggPHP\Template\Template;

class Content extends Common
{
    public function get(
        Request $request,
        Template $template,
        ModelContent $contentModel,
        Column $columnModel,
        Model $modelModel,
        Field $fieldModel,
        Cate $cateModel,
        Area $areaModel
    ) {
        if (!$content = $contentModel->get('*', [
            'cid' => $request->get('cid'),
        ])) {
            return $this->error('内容不存在~');
        }
        $template->assign('content', $content);

        if (!$column = $columnModel->get('*', [
            'id' => $content['column_id'],
        ])) {
            return $this->error('栏目不存在~');
        }
        $template->assign('column', $column);

        if (!$model = $modelModel->get('*', [
            'id' => $column['model_id'],
        ])) {
            return $this->error('栏目不存在~');
        }
        $template->assign('model', $model);

        $template->assign('fields', $fieldModel->select('*', [
            'model_id' => $model['id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]));

        if ($cate = $cateModel->get('*', [
            'column_id' => $column['id'],
            'name' => $request->get('cate'),
        ])) {
            $template->assign('cate', $cate);
        }

        if ($area = $areaModel->get('*', [
            'site_id' => $this->site['id'],
            'name' => $request->get('area'),
        ])) {
            $template->assign('area', $area);
        }

        return $this->html($template->renderFromFile('content@ebcms/scms-web'));
    }
}
