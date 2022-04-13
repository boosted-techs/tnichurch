<?php

//Less define our simple routes in this file to help us map to the exact methods in our project

$route['']                                  =               "Home/index";
$route['about-us']                          =               "Home/about";
$route['blog']                              =               "Home/blog";
$route['contact-us']                        =               "Home/contact";
$route['events']                            =               "Home/events";
$route['sermons']                           =               "Home/sermons";
$route['shop']                              =               "Home/shop";


$route['wp-admin']                          =               "Admin/login";
$route['wp-admin/dashboard']                =               "Admin/index";
$route['wp-admin/forgot-pwd']               =               "Admin/forgot_password";
$route['wp-admin/logout']                   =               "Admin/logout";
$route['wp-admin/sign-in']                  =               "Admin/sign_in";