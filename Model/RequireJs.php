<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model;

use Magento\Framework\RequireJs\Config\File\Collector\Aggregated as RequireJsCollector;

class RequireJs
{
    public function afterGetFiles(RequireJsCollector $subject, array $files)
    {
        foreach ($files as $k => $v) {
            if ($v->getModule() === 'Mpchadwick_SearchAutocompleteConfigmarator') {
                unset($files[$k]);
            }
        }

        return $files;
    }
}
