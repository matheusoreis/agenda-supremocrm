<?php

use SupremoCRM\Agenda\Core\Router;

Router::get('contacts', 'ContactController@index');
Router::get('contacts/create', 'ContactController@create');
Router::post('contacts/store', 'ContactController@store');
Router::get('contacts/{id}/edit', 'ContactController@edit');
Router::post('contacts/{id}/update', 'ContactController@update');
Router::get('contacts/{id}/delete', 'ContactController@delete');
Router::get('contacts/search', 'ContactController@search');
Router::get('contacts/cities', 'ContactController@getCities');

Router::get('states', 'StateController@index');
Router::get('states/create', 'StateController@create');
Router::post('states/store', 'StateController@store');
Router::get('states/{id}/edit', 'StateController@edit');
Router::post('states/{id}/update', 'StateController@update');
Router::get('states/{id}/delete', 'StateController@delete');

Router::get('cities', 'CityController@index');
Router::get('cities/create', 'CityController@create');
Router::post('cities/store', 'CityController@store');
Router::get('cities/{id}/edit', 'CityController@edit');
Router::post('cities/{id}/update', 'CityController@update');
Router::get('cities/{id}/delete', 'CityController@delete');

Router::get('', function () {
    header('Location: /contacts');

    exit;
});
