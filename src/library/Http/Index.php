<?php

declare(strict_types=1);

namespace App\Ebcms\ScmsWeb\Http;

use DigPHP\Template\Template;

class Index extends Common
{
    public function get(
        Template $template
    ) {
        return $template->renderFromFile('index@ebcms/scms-web');
    }
}
