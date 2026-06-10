<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoJob;
use App\Jobs\GenerateCatalog\GenerateCatalogMainJob;

class DiggingDeeperController extends Controller
{
    public function processVideo()
    {
        ProcessVideoJob::dispatch();
        // Відкладення виконання завдання від моменту потрапляння в чергу:
        // ->delay(10)
        // ->onQueue('name_of_queue')
    }

    /**
     * @link http://localhost/api/digging_deeper/prepare-catalog
     *
     * sail artisan queue:listen --queue=generate-catalog --tries=3 --delay=10
     */
    public function prepareCatalog()
    {
        GenerateCatalogMainJob::dispatch();

        return response()->json(['message' => 'Генерацію каталогу запущено у фоні']);
    }
}
