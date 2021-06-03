<?php

namespace App\Presenters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use IntlDateFormatter;
use Jenssegers\Date\Date;

/**
 * Class Presenter
 *
 * @see     https://github.com/laracasts/Presenter/blob/master/src/Laracasts/Presenter/Presenter.php
 *
 * @property \Illuminate\Database\Eloquent\Model $instance
 *
 * @package App\Presenters
 */
abstract class Presenter
{
    const LOCALIZED_DATE_FORMAT = 'd/m/Y';

    /** @var  Model */
    protected $instance;

    /** @var array */
    protected $formats = [];

    protected $dateFormatter       = null;
    protected $dateFormatterBooted = false;

    public function __construct( Model $instance )
    {
        $this->instance = $instance;
    }

    public static function parseWeekDay( Carbon $dia )
    {
        switch ($dia->dayOfWeek) {
            case 0:
                return 'Dom';
            case 1:
                return 'Seg';
            case 2:
                return 'Ter';
            case 3:
                return 'Qua';
            case 4:
                return 'Qui';
            case 5:
                return 'Sex';
            case 6:
                return 'Sáb';
        }
    }

    function parseMonth( Carbon $date )
    {
        switch ($date->month) {
            case 1:
                $result = 'Janeiro';
                break;
            case 2:
                $result = 'Fevereiro';
                break;
            case 3:
                $result = 'Março';
                break;
            case 4:
                $result = 'Abril';
                break;
            case 5:
                $result = 'Maio';
                break;
            case 6:
                $result = 'Junho';
                break;
            case 7:
                $result = 'Julho';
                break;
            case 8:
                $result = 'Agosto';
                break;
            case 9:
                $result = 'Setembro';
                break;
            case 10:
                $result = 'Outubro';
                break;
            case 11:
                $result = 'Novembro';
                break;
            case 12:
                $result = 'Dezembro';
                break;
            default:
                $result = null;
        }

        return join( ' de ', array_filter( [ $result, $date->year ] ) );
    }

    public function created_at()
    {
        return 'criado em ' . $this->instance->created_at->format( self::LOCALIZED_DATE_FORMAT );
    }

    public function updated_at()
    {
        if (empty( $this->instance->updated_at )) {
            return null;
        }

        return 'atualizado em ' . $this->instance->updated_at->format( self::LOCALIZED_DATE_FORMAT );
    }

    public function deleted_at()
    {
        if (empty( $this->instance->deleted_at )) {
            return null;
        }

        return 'removido em ' . $this->instance->deleted_at->format( self::LOCALIZED_DATE_FORMAT );
    }

    public function forForm( $field, $default = null )
    {
        $value = value_or_null( $this->instance->{$field} );

        if (empty( $value )) {
            return $default;
        }

        if (in_array( $field, $this->instance->getDates() )) {
            /** @var Carbon $value */
            return $value->format( 'Y-m-d' );
        }

        return $this->instance->{$field};
    }

    /**
     * Allow for property-style retrieval
     *
     * @param $property
     *
     * @return mixed
     */
    public function __get( $property )
    {
        if (array_key_exists( $property, $this->formats )) {
            return $this->formatProperty( $property, $this->formats[ $property ] );
        }

        if (method_exists( $this, $property )) {
            return $this->{$property}();
        }

        return $this->instance->{$property};
    }

    public static function formatOption( $name, $value, $label, $default = '' )
    {
        $selected = old( $name, $default ) == $value ? 'selected' : '';

        return new HtmlString( "<option value=\"{$value}\" {$selected}>{$label}</option>" );
    }

    public function formToggle( $name, $value = '1', $default = '' )
    {
        $isChecked = value_or_null( old( $name, $default ) ) == $value;

        return new HtmlString( view( 'common.form.toggle', compact( 'isChecked', 'name', 'value' ) ) );
    }

    public function formatNumber( $value, $places = 2, $decimalSeparator = '.', $thousandsSeparator = '' )
    {
        $value = value_or_null( $value ) ?: 0;

        if (!is_numeric( $value )) {
            $value = $this->instance->{$value};
        }

        if (!is_numeric( $value )) {
            throw new \InvalidArgumentException( 'Should be a number' );
        }

        $value = (float)number_format( $value, $places, '.', '' );

        return number_format( $value, $places, $decimalSeparator, $thousandsSeparator );
    }

    public function formatInteger( $value, $thousandsSeparator = '' )
    {
        return $this->formatNumber( $value, 0, '', $thousandsSeparator );
    }

    public function formatCurrency( $value, $decimalPlaces = 2 )
    {
        $value = value_or_null( $value ) ?: 0;

        if (empty( $value ) || !is_numeric( $value )) {
            $value = 0;
        }

        $value = (float)number_format( $value, $decimalPlaces, '.', '' );

        if ($value < 0) {
            $value = join( '', [ '(R$', number_format( -$value, $decimalPlaces, ',', '.' ), ')' ] );

            return new \Illuminate\Support\HtmlString( "<span style=\"color: #A94442;\">{$value}</span>" );
        }

        return join( '', [ 'R$', number_format( $value, $decimalPlaces, ',', '.' ) ] );
    }

    protected function formatPercentage( $value, $precision = 2 )
    {
        $value = value_or_null( $value ) ?: 0;

        if (empty( $value ) || !is_numeric( $value )) {
            $value = 0;
        }

        $value = (float)number_format( $value, ( $precision + 1 ), '.', '' );

        if ($value < 0) {
            $value = join( '', [ '-', number_format( -$value, $precision, ',', '.' ), '%' ] );

            return new \Illuminate\Support\HtmlString( "<span style=\"color: #A94442;\">{$value}</span>" );
        }

        return join( '', [ number_format( $value, $precision, ',', '.' ), '%' ] );
    }

    protected function formatBrazilianDate( $date, $highlightToday = false )
    {
        $date = value_or_null( $date );

        if (empty( $date )) {
            return null;
        }

        if (!$date instanceof Carbon) {
            $date = Date::createFromFormat( 'Y-m-d', $date, tz() );
        }

        $formattedDate = $date->format( 'd/m/Y' );

        if ($date->isToday() && $highlightToday) {
            return new HtmlString( "{$formattedDate} <span class=\"label label-primary\">HOJE</span>" );
        }

        return $formattedDate;
    }

    protected function formatFullDate( $date )
    {
        $date = value_or_null( $date );

        if (empty( $date )) {
            return null;
        }

        $formatter = $this->getDateFormatter();

        if (empty( $formatter )) {
            return $this->formatBrazilianDate( $date );
        }

        if (!$date instanceof Carbon) {
            $date = Date::createFromFormat( 'Y-m-d', $date, tz() );
        }

        $this->dateFormatter->setPattern( "dd 'de' LLLL 'de' yyyy" );

        return $formatter->format( $date );
    }

    protected function formatEmail( $email )
    {
        return new HtmlString( "<i class=\"fa fa-fw fa-envelope-o\"></i>&nbsp;<a href=\"mailto:{$email}\">{$email}</a>" );
    }

    protected function formatRamal( $ramal )
    {
        return new HtmlString( "<i class=\"fa fa-fw fa-phone\"></i>&nbsp;<small>{$ramal}</small>" );
    }

    public static function inflect( $count, $singular, $plural, $none = 'nenhum', $one = 'um' )
    {
        $count = intval( $count );

        if ($count === 0) {
            return join( ' ', [ $none, $singular ] );
        }

        if ($count === 1) {
            return join( ' ', [ $one, $singular ] );
        }

        return join( ' ', [ number_format( $count, 0, ',', '.' ), $plural ] );
    }

    protected function getDateFormatter()
    {
        if ($this->dateFormatterBooted) {
            return $this->dateFormatter;
        }

        $this->dateFormatter = new IntlDateFormatter( 'pt_BR', IntlDateFormatter::FULL, IntlDateFormatter::FULL );

        if (!Str::startsWith( $this->dateFormatter->getLocale(), 'pt' )) {
            $this->dateFormatter = null;
        }

        $this->dateFormatterBooted = true;

        return $this->dateFormatter;
    }

    private function formatProperty( $property, $type )
    {
        if ($type === 'currency') {
            return $this->formatCurrency( $this->instance->{$property} );
        }

        if (in_array( $type, [ 'perc', 'percentage' ] )) {
            return $this->formatPercentage( $this->instance->{$property}, 1 );
        }

        if (in_array( $type, [ 'perc-m', 'percentage-m' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return '-';
            }

            return $this->formatPercentage( $this->instance->{$property}, 1 );
        }

        if (in_array( $type, [ 'perc-mb', 'percentage-mb' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return new HtmlString( '<span style="display: block;" class="text-center">-</span>' );
            }

            return $this->formatPercentage( $this->instance->{$property}, 1 );
        }

        if (in_array( $type, [ 'perc2', 'percentage2' ] )) {
            return $this->formatPercentage( $this->instance->{$property}, 2 );
        }

        if (in_array( $type, [ 'perc2-m', 'percentage2-m' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return '-';
            }

            return $this->formatPercentage( $this->instance->{$property}, 2 );
        }

        if (in_array( $type, [ 'perc2-mb', 'percentage2-mb' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return new HtmlString( '<span style="display: block;" class="text-center">-</span>' );
            }

            return $this->formatPercentage( $this->instance->{$property}, 2 );
        }

        if (in_array( $type, [ 'int', 'integer' ] )) {
            return $this->formatInteger( $this->instance->{$property}, '.' );
        }

        if (in_array( $type, [ 'int-m', 'integer-m' ] )) {
            if (is_numeric( $this->instance->{$property} ) && intval( $this->instance->{$property} ) === 0) {
                return '-';
            }

            return $this->formatInteger( $this->instance->{$property}, '.' );
        }

        if (in_array( $type, [ 'int-mb', 'integer-mb' ] )) {
            if (is_numeric( $this->instance->{$property} ) && intval( $this->instance->{$property} ) === 0) {
                return new HtmlString( '<span style="display: block;" class="text-center">-</span>' );
            }

            return $this->formatInteger( $this->instance->{$property}, '.' );
        }

        if (in_array( $type, [ 'decimal', 'double', 'float' ] )) {
            return $this->formatNumber( $this->instance->{$property}, 2, ',', '.' );
        }

        if (in_array( $type, [ 'decimal-m', 'double-m', 'float-m' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return '-';
            }

            return $this->formatNumber( $this->instance->{$property}, 2, ',', '.' );
        }

        if (in_array( $type, [ 'decimal-mb', 'double-mb', 'float-mb' ] )) {
            if (is_numeric( $this->instance->{$property} ) && floatval( $this->instance->{$property} ) === 0.0) {
                return new HtmlString( '<span style="display: block;" class="text-center">-</span>' );
            }

            return $this->formatNumber( $this->instance->{$property}, 2, ',', '.' );
        }

        if (in_array( $type, [ 'boolean' ] )) {
            return $this->instance->{$property} ? 'sim' : '-';
        }

        if (in_array( $type, [ 'date' ] ) && $this->instance->{$property} instanceof Carbon) {
            return $this->formatBrazilianDate( $this->instance->{$property}, false );
        }

        return $this->instance->{$property};
    }

    public static function asCombo( Collection $items, $name, $default = null, $required = true, $autofocus = false )
    {
        $requiredAttribute  = $required ? 'required' : '';
        $autofocusAttribute = $autofocus ? 'autofocus' : '';

        $tokens = [];

        $tokens[] = "<select class=\"form-control\" name=\"{$name}\" id=\"{$name}\" {$requiredAttribute} {$autofocusAttribute}>";

        if ($required) {
            $tokens[] = '<option value="">Escolha...</option>';
        }

        foreach ($items as $item) {
            $tokens[] = $item->present()->asOption( $name, $default );
        }

        $tokens[] = "</select>";

        return new HtmlString( join( '', $tokens ) );
    }

    public static function timeGreeting()
    {
        $now = now_tz();

        if ($now->hour >= 4 && $now->hour < 12) {
            return 'bom dia';
        }

        if ($now->hour >= 12 && $now->hour < 19) {
            return 'boa tarde';
        }

        return 'boa noite';
    }

    public static function formatSeconds( $seconds )
    {
        $seconds = (int)$seconds;

        $hours   = floor( $seconds / 3600 );
        $seconds -= 3600 * $hours;

        $minutes = floor( $seconds / 60 );
        $seconds -= 60 * $minutes;

        if ($hours === 0 && $minutes === 0 && $seconds === 0) {
            return 'zero segundos';
        }

        $retorno = '';

        if ($hours > 0) {
            $retorno .= static::inflect( $hours, 'hora', 'horas' );
        }

        if ($minutes > 0) {
            if ($hours > 0) {
                $retorno .= ( $seconds > 0 ? ', ' : ' e ' );
            }
            $retorno .= static::inflect( $minutes, 'minuto', 'minutos' );
        }

        if ($seconds > 0) {
            if ($hours + $minutes > 0) {
                $retorno .= ' e ';
            }
            $retorno .= static::inflect( $seconds, 'segundo', 'segundos' );
        } elseif ($hours + $minutes == 0) {
            $retorno = 'nenhum segundo';
        }

        return $retorno;
    }

    protected function returnAsHTML( $content, $html = true )
    {
        if ($html === false) {
            return strip_tags( $content );
        }

        return new HtmlString( $content );
    }
}
