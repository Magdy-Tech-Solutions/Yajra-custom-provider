<?php

namespace Custom\Yajra\Html;

use Illuminate\Support\HtmlString;
use Yajra\DataTables\Html\Builder as DataTablesHtmlBuilder;

class Builder extends DataTablesHtmlBuilder
{
    /**
     * @var string $theadTableClass
     */
    protected string $theadTableClass = '';

    /**
     * @var string $trTheadTableClass
     */
    protected string $trTheadTableClass = '';

    /**
     * @var string $additionalBodyAttribute
     */
    protected string $additionalBodyAttribute = '';

    /**
     * Generate DataTable javascript.
     */
    public function scripts(?string $script = null, array $attributes = []): HtmlString
    {
        $script = $script ?: $this->generateScripts();
        $attributes = $this->html->attributes(
            array_merge($attributes, ['type' => $attributes['type'] ?? static::$jsType])
        );

        return new HtmlString("<script{$attributes}>$script;{$this->additionalBodyAttribute}</script>");
    }

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

    public function thAttr(array $attributes)
    {
        foreach ($this->collection as $collection) {
            $collection->attributes = $attributes;
        }

        return $this;
    }

    public function tbodyAttr(array $attributes)
    {
        $table_id = $this->tableAttributes['id'];

        $setAttributes = '';
        foreach ($attributes as $key => $value) {
            if (is_int($key)) {
                $setAttributes .= "setAttribute('$value')";
            } else {
                $setAttributes .= "setAttribute('$key', '$value')";
            }
        }

        $script = `
            let tbody = document.querySelector('#$table_id tbody');

            tbody.$setAttributes;
        `;

        $this->additionalBodyAttribute .= $script;

        return $this;
    }
}
