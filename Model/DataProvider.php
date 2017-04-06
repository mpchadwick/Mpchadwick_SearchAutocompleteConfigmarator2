<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model;

use Magento\CatalogSearch\Model\Autocomplete\DataProvider as Subject;

class DataProvider
{
    public function afterGetItems(Subject $subject, array $items)
    {
        // Note: We intercept here (rather than intercepting the db query
        // and setting a limit) because there is logic in getItems
        // which bumps current query to front, if found

        // todo: Check config
        return array_splice($items, 0, 3);
    }
}
