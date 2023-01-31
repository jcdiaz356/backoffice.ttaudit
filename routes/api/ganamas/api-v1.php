<?php

    use App\Http\Controllers\Api\Ganamas\ConcourseController;
    use App\Http\Controllers\Api\Ganamas\ConcourseDetailController;
    use App\Http\Controllers\Api\Ganamas\PromotionsController;
    use App\Http\Controllers\Api\Ganamas\UserController;

    Route::apiResource('promotions', PromotionsController::class);

    Route::post('promotionsForZone', [PromotionsController::class,'promotionsForZone']);

    Route::post('getUserForCode', [UserController::class,'getUserForCode']);

    Route::post('loadUserSaveTable',[UserController::class,'loadUserSaveTable']);

    Route::post('loadConcourseSaveTable',[ConcourseController::class,'loadConcourseSaveTable']);

    Route::post('loadConcourseDetailSaveTable',[ConcourseDetailController::class,'loadConcourseDetailSaveTable']);

    Route::post('loadDexSaveTable',[UserController::class,'loadDexSaveTable']);

    Route::post('getIndicatorsHome', [ConcourseDetailController::class,'getIndicatorsHome']);

    Route::post('getEstadoCuenta', [ConcourseDetailController::class,'getEstadoCuenta']);

    Route::post('getConcoursesForSeller', [ConcourseDetailController::class,'getConcoursesForSeller']);
    Route::post('getAllConcoursesForSeller', [ConcourseDetailController::class,'getAllConcoursesForSeller']);

    Route::post('getConcourseDetail', [ConcourseDetailController::class,'getConcourseDetail']);
    Route::post('getAllConcourseDetail', [ConcourseDetailController::class,'getAllConcourseDetail']);
