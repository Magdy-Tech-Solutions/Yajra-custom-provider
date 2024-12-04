<?php

namespace Custom\Yajra\Html;

use Illuminate\Support\HtmlString;
use Yajra\DataTables\Html\Builder as DataTablesHtmlBuilder;

class Builder extends DataTablesHtmlBuilder
{

    protected array $tableTheadClass = [];

    /**
     * Generate DataTable's table html.
     */
    public function table(array $attributes = [], bool $drawFooter = false, bool $drawSearch = false): HtmlString
    {
        $this->setTableAttributes($attributes);

        $th = $this->compileTableHeaders();
        $htmlAttr = $this->html->attributes($this->tableAttributes);

        $tableHtml = '<table' . $htmlAttr . '>';
        $searchHtml = $drawSearch
            ? '<tr class="search-filter">' . implode('', $this->compileTableSearchHeaders()) . '</tr>'
            : '';

        $tableHtml .= '<thead'.($this->tableTheadClass ?? '').'>';
        $tableHtml .= '<tr>' . implode('', $th) . '</tr>' . $searchHtml . '</thead>';

        if ($drawFooter) {
            $tf = $this->compileTableFooter();
            $tableHtml .= '<tfoot><tr>' . implode('', $tf) . '</tr></tfoot>';
        }

        $tableHtml .= '</table>';

        return new HtmlString($tableHtml);
    }

    public function theadClass(array $attributes) {
        foreach ($attributes as $attribute => $value) {
            $this->tableTheadClass[$attribute] = $value;
        }

        return $this;
    }
}
