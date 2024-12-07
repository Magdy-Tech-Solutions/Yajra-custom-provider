<?php

namespace Custom\Yajra\Html;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Traits\Macroable;
use Yajra\DataTables\Html\Builder as DataTablesHtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\HtmlBuilder;
use Yajra\DataTables\Html\Parameters;
use Yajra\DataTables\Utilities\Helper;

class Builder extends DataTablesHtmlBuilder
{
    /**
     * @var string $theadTableClass
     */
    protected string $theadTableClass = '';

    /**
     * @var string $theadTableClass
     */
    protected string $trTheadTableClass = '';


    /**
     * Generate DataTable's table html.
     */
    public function table(array $attributes = [], bool $drawFooter = false, bool $drawSearch = false): HtmlString
    {
        $this->setTableAttributes($attributes);

        $th = $this->compileTableHeaders();
        $htmlAttr = $this->html->attributes($this->tableAttributes);

        $tableHtml = '<table ' . $htmlAttr . '>';
        $searchHtml = $drawSearch
            ? '<tr class="search-filter">' . implode('', $this->compileTableSearchHeaders()) . '</tr>'
            : '';

        $tableHtml .= '<thead ' . $this->theadTableClass . '>';
        $tableHtml .= '<tr ' . $this->trTheadTableClass . '>' . implode('', $th) . '</tr>' . $searchHtml . '</thead>';

        if ($drawFooter) {
            $tf = $this->compileTableFooter();
            $tableHtml .= '<tfoot><tr>' . implode('', $tf) . '</tr></tfoot>';
        }

        $tableHtml .= '</table>';

        return new HtmlString($tableHtml);
    }

    public function theadAttr(array $attributes)
    {
        $class = '';

        foreach ($attributes as $key => $value) {
            if (is_int($key)) {
                $class .= " $value";
            } elseif (is_array($value)) {
                $class .= " $key=\"" . implode(' ', $value) . "\"";
            } else {
                $class .= " $key=\"$value\"";
            }
        }

        $this->theadTableClass = trim($class);

        return $this;
    }

    public function trTheadAttr(array $attributes)
    {
        $class = '';

        foreach ($attributes as $key => $value) {
            if (is_int($key)) {
                $class .= " $value";
            } elseif (is_array($value)) {
                $class .= " $key=\"" . implode(' ', $value) . "\"";
            } else {
                $class .= " $key=\"$value\"";
            }
        }

        $this->trTheadTableClass = trim($class);

        return $this;
    }

    public function thAttr(array $attributes) {
        foreach ($this->collection as $collection) {
            $collection->attributes = $attributes;
        }

        return $this;
    }
}
