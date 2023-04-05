<?php

namespace App\Services;

use App\Listeners\QueryExecutedListener;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Events\QueryExecuted;

class RegisterShowExecutedQueryListenerProxy
{
    protected  Dispatcher $eventDispatcher;
    public function __construct(Dispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function register():void{
        if (env("SHOW_EXECUTED_QUERIES",false))
            $this->eventDispatcher->listen(
                QueryExecuted::class,QueryExecutedListener::class
            );
    }
}
