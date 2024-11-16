<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

/*
 basiclly we make the route that goes to the method (in the controller class) that load the view
 which means this is gonna be the work flow, when you want to add a new functionality:
 add a new route -> add a new control method -> add a new view
*/


// All Listings
Route::get('/', [ListingController::class, 'index']); // this is how to access the index method in the LisitngController class


// Manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');


// Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth'); // middleware is used to make sure that this function can be used by authenticated users


// Store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');


// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');


// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');


// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');
/*
In the Laravel framework, when you define routes with parameters enclosed in curly braces {},
you are creating a route parameter. These route parameters allow you to capture values
from the URL and pass them to your controller methods for further processing.
*/


// Single Listing 
Route::get('/listings/{listing}', [ListingController::class, 'show']);
/*
for example here:
In our case, the show method in your ListingController is type-hinted with Listing $listing,
 which tells Laravel to automatically resolve the Listing model instance based on the route parameter named listing.

and you access a URL like /listings/1, Laravel will automatically fetch the Listing model
 with the ID of 1 and pass it as an argument to the show method in your controller.
*/


// Show register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest'); // this middleware to make sure that only not logged in users can ccess the register form


// Create new user
Route::post('/users', [UserController::class, 'store']);
// the link between this route and the form is the action attribute of the form, so this how this  route is activiated


// Log user out
Route::post('/logout', [UserController::class, 'logout']);


// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest'); // we are naming the route 'login', to use the route to show the login form when an unauthenticate user tries to to edit delete or post a Job, and the middelware so only guest users can access the login form
// we named it login because there is a method in the Authenticate.php that redirect the guest users to the login route if he trise to post a jobe for example

// Log in user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
