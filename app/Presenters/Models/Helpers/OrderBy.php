<?php

namespace App\Presenters\Models\Helpers;

use App\Presenters\Presenter;

class OrderBy extends Presenter
{
    public function asLink( $column, $label = '' )
    {
        $icon = $this->instance->column === $column
            ? ( $this->instance->asc ? '<i class="fa fa-fw fa-chevron-up"></i>'
                : '<i class="fa fa-fw fa-chevron-down"></i>' )
            : '';

        $column = $this->instance->column === $column
            ? ( $this->instance->asc ? '-' : '' ) . $column
            : $column;

        $label = $label ?: trim( $column, '-' );

        $url = join( '?', [ $this->instance->url, "orderBy={$column}" ] );
        $url = str_replace( '??', '?', $url );

        return $this->returnAsHTML( "<a href=\"{$url}\">{$label} {$icon}</a>" );
    }
}
