<?php

use App\Http\Controllers\Api\Ttaudit\AuditController;

Route::prefix('audits')->group(function (){

    Route::get('listCompanies', [AuditController::class,'getCompanies']);
    Route::post('getResposeProductsAuditResult', [AuditController::class,'getResposeProductsAuditResult']);
    Route::post('getResposeBrandsForCompany', [AuditController::class,'getBrandsForCompanyCategory']);
    Route::post('getProductsAuditPreview', [AuditController::class,'getProductsAuditPreview']);
    Route::post('getFotoExitoForPoll', [AuditController::class,'getFotoExitoForPoll']);

});
