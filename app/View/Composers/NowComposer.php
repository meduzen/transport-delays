<?php

namespace App\View\Composers;

use Illuminate\Support\Carbon;
use Illuminate\View\View;

class NowComposer
{
    protected Carbon $now;

    /**
     * Create a new profile composer.
     */
    public function __construct() {
        $this->now = now();
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('now', $this->now);
    }
}
