<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ConversationController@index')->name(config('conversation.routes.prefix'));;
