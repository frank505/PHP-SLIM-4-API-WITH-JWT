<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Controllers\GuestEntryController;


return function (App $app)
{
    $app->post('/create-guest',[GuestEntryController::class,'createGuest']);
    $app->get("/view-guests",[GuestEntryController::class,'viewGuests']);
    $app->patch("/edit-guest/{id}",[GuestEntryController::class,'editGuests']);
    $app->delete('/delete-guest/{id}',[GuestEntryController::class,'deleteGuests']);

    $app->group("/auth",function($app)
    {
       $app->post("/login",[\App\Controllers\AuthController::class,"Login"]);
        $app->post("/register",[\App\Controllers\AuthController::class,"Register"]);
    });
};