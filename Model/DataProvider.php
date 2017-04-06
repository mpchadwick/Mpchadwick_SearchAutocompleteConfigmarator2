<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model;

use Magento\CatalogSearch\Model\Autocomplete\DataProvider as Subject;
use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Store\Model\ScopeInterface;

class DataProvider
{
    const CONFIG_AUTOCOMPLETE_LIMIT = 'catalog/search/autocomplete_limit';

    protected $limit;

    public function __construct(ScopeConfig $scopeConfig)
    {
        $this->limit = (int) $scopeConfig->getValue(
            self::CONFIG_AUTOCOMPLETE_LIMIT,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function afterGetItems(Subject $subject, array $items)
    {
        // Note: We intercept here (rather than intercepting the db query
        // and setting a limit) because there is logic in getItems
        // which bumps current query to front, if found
        return ($this->limit) ? array_splice($items, 0, $this->limit) : $items;
    }
}
