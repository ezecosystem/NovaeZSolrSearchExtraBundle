<?php
/**
 * NovaeZSolrSearchExtraBundle.
 *
 * @package   NovaeZSolrSearchExtraBundle
 *
 * @author    Novactive <f.alexandre@novactive.com>
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaeZSolrSearchExtraBundle/blob/master/LICENSE
 */

namespace Novactive\EzSolrSearchExtra\Query\SortClauseVisitor;

use eZ\Publish\API\Repository\Values\Content\Query\SortClause as APISortClause;
use EzSystems\EzPlatformSolrSearchEngine\Query\SortClauseVisitor;
use Novactive\EzSolrSearchExtra\Query\SortClause;

/**
 * Class CustomField.
 */
class CustomField extends SortClauseVisitor
{
    /**
     * Check if visitor is applicable to current sortClause.
     *
     * @param APISortClause $sortClause
     *
     * @return bool
     */
    public function canVisit(APISortClause $sortClause)
    {
        return $sortClause instanceof SortClause\CustomField;
    }

    /**
     * Map field value to a proper Solr representation.
     *
     * @param APISortClause $sortClause
     *
     * @return string
     */
    public function visit(APISortClause $sortClause)
    {
        return $sortClause->target . $this->getDirection($sortClause);
    }
}
