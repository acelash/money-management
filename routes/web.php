<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('budget', 'BudgetController@index')->name('budget');
    Route::get('load-article-data/{id}', 'BudgetController@loadArticleData')->name('load-article-data');
    Route::post('add-budget', 'BudgetController@create')->name('add-budget');
    Route::post('update-budget', 'BudgetController@update')->name('update-budget');
    Route::delete('remove-budget/{id}', 'BudgetController@destroy')->name('remove-budget');

    Route::get('resource', 'SourcesController@index')->name('resource.list');
    Route::get('load-resource-data/{id}', 'SourcesController@loadResourceData')->name('load-resource-data');
    Route::post('add-resource', 'SourcesController@create')->name('add-resource');
    Route::post('update-resource', 'SourcesController@update')->name('update-resource');
    Route::delete('remove-resource/{id}', 'SourcesController@destroy')->name('remove-resource');

    Route::get('transactions', 'TransactionsController@index')->name('transactions.list');
    Route::post('add-transaction', 'TransactionsController@create')->name('add-transaction');
    Route::delete('remove-transaction/{id}', 'TransactionsController@destroy')->name('remove-transaction');

    Route::post('add-target', 'HomeController@createTarget')->name('add-target');
    Route::get('reports', 'ReportsController@index')->name('reports');

    Route::get('cripto-resource', 'CriptoSourcesController@index')->name('cripto-resource.list');
    Route::get('load-cripto-resource-data/{id}', 'CriptoSourcesController@loadResourceData')->name('load-cripto-resource-data');
    Route::post('add-cripto-resource', 'CriptoSourcesController@create')->name('add-cripto-resource');
    Route::post('update-cripto-resource', 'CriptoSourcesController@update')->name('update-cripto-resource');
    Route::delete('remove-cripto-resource/{id}', 'CriptoSourcesController@destroy')->name('remove-cripto-resource');

    Route::post('add-cripto-investition', 'CriptoInvestitionsController@create')->name('add-cripto-investition');
    Route::delete('remove-cripto-investition/{id}', 'CriptoInvestitionsController@destroy')->name('remove-cripto-investition');

    Route::get('update-rates', 'HomeController@updateRates')->name('update-rates');
});