<?php 
// This file is required for each modules
// File name must be config.php
// It should return an associative array
// Array must contain the following key-value pair:  "idname" => "idname-of-the-module"
// idname could only contain following symbols: A-Za-z0-9 and - sysmbol
// Returned array could contain some optional data and your own meta data
// Optional data are generally visible on Modules page (/plugins)
// Additional meta data are for your own use, script doesn't use them anywhere automatically


// Disable the direct access to this file
// This is not required, but recommended
if (!defined('APP_VERSION')) die("Yo, what's up?"); 


// Return the config array
return [
    "idname" => "sample-module", // Required.
                                 // sample-module will be the directory name of the module
                                 // module should contain sample-module.php file

    "plugin_name" => "Auto Repost", // Optional. 
                                    // This is the name of your module, could be any string
                                    // Name will be visible on Modules page (/plugins)

    "plugin_uri" => "http://getnextpost.io", // Optional.
                                             // External link to the plugin's website

    "author" => "Nextpost", // Optional.
                            // Name of the plugin author

    "author_uri" => "http://getnextpost.io", // Optional.
                                             // External link to the author's website

    "version" => "1.0.0", // Optional.
                          // Version number of the plugin

    "desc" => "Lorem ipsum dolor sit amet.", // Optional.
                                             // Description of the module

    "settings_page_uri" => APPURL . "/e/sample-module/settings" // Optional.
                                                                // Page URI for the module settings page
                                                                // Page route must be handled by sample-module.php file


    // Meta data
    "icon_style" => "background-color: #00E3AE; background: linear-gradient(45deg, #00E3AE 0%, #9BE15D 100%); color: #fff; font-size: 18px;",
    "foo" => "bar",
    "baz" => "qux"
];
    