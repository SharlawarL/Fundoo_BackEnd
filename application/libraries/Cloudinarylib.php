<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// setup the dummy class for Cloudinary
class Cloudinarylib {

    public function __construct()
    {

        // include the cloudinary library within the dummy class
        require('vendor/cloudinary/cloudinary_php/src/Cloudinary.php');
        require 'vendor/cloudinary/cloudinary_php/src/Uploader.php';
        require 'vendor/cloudinary/cloudinary_php/src/Api.php';

        \Cloudinary::config(array(
            "cloud_name" => "megabit-solution",
            "api_key" => "362584955692738",
            "api_secret" => "-_a-12YzdeFnl7t-Nh75hV-jOTU"
        ));
    }
}