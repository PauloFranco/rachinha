<?php

namespace App\Presenters;

use InvalidArgumentException;

trait Presentable
{
    /** @var  Presenter */
    protected $presenter;

    public function present()
    {
        $className = $this->getPresenterClassName();

        if (!class_exists( $className )) {
            throw new InvalidArgumentException( 'Presenter not found' );
        }

        if (!$this->presenter) {
            $this->presenter = new $className( $this );
        }

        return $this->presenter;
    }

    protected function getPresenterClassName()
    {
        return preg_replace( '/^App\\\\(.+)$/', 'App\\Presenters\\\\$1', __CLASS__ );
    }
}
