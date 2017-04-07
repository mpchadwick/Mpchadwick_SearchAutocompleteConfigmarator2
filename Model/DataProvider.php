<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model;

use Magento\CatalogSearch\Model\Autocomplete\DataProvider as Subject;
use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Store\Model\ScopeInterface;

class DataProvider
{
    const CONFIG_AUTOCOMPLETE_LIMIT = 'catalog/search/autocomplete_limit';
    const CONFIG_HIDE_RESULT_COUNT = 'catalog/search/hide_result_count';

    protected $limit;
    protected $hideResultCount;

    public function __construct(ScopeConfig $scopeConfig)
    {
        $this->limit = (int) $scopeConfig->getValue(
            self::CONFIG_AUTOCOMPLETE_LIMIT,
            ScopeInterface::SCOPE_STORE
        );

        $this->hideResultCount = (bool) $scopeConfig->getValue(
            self::CONFIG_HIDE_RESULT_COUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function afterGetItems(Subject $subject, array $items)
    {
        if ($this->hideResultCount) {
            foreach ($items as $k => $v) {
                unset($v['num_results']);
            }
        }

        // todo: Magento\Search\Model\Autocomplete::getItems will merge
        // the results of each provider. So it would be more if additional
        // providers were added. OOB Magento only uses
        // Magento\CatalogSearch\Model\Autocomplete\DataProvider, but need
        // to determine if this is the best place

        // Note: We intercept here (rather than intercepting the db query
        // and setting a limit) because there is logic in getItems
        // which bumps current query to front, if found
        return ($this->limit) ? array_splice($items, 0, $this->limit) : $items;
    }
}
