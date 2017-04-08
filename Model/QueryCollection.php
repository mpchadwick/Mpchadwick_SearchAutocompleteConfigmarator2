<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model;

use Magento\Search\Model\ResourceModel\Query\Collection as SourceCollection;
use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\DB\Helper as ResourceHelper;

class QueryCollection
{
    const CONFIG_LIKE_MATCH_POSITION = 'catalog/search/like_match_position';

    protected $scopeConfig;
    protected $_resourceHelper;

    public function __construct(
        ScopeConfig $scopeConfig,
        ResourceHelper $resourceHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_resourceHelper = $resourceHelper;
    }

    public function aroundSetQueryFilter(SourceCollection $subject, callable $proceed, $query)
    {
        $result = $proceed($query);

        $position = $this->scopeConfig->getValue(
            self::CONFIG_LIKE_MATCH_POSITION,
            ScopeInterface::SCOPE_STORE
        );

        $result->getSelect()->reset(
            \Magento\Framework\DB\Select::WHERE
        )->where(
            'num_results > 0 AND display_in_terms = 1 AND query_text LIKE ?',
            $this->_resourceHelper->addLikeEscape($query, ['position' => $position])
        );

        return $result;
    }
}
