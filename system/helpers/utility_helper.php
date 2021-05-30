<?php
defined('BASEPATH') or exit('No direct script access allowed');


/*
| This function returns the fulll path to the '/assets/css' directory
*/
function css_asset_url()
{
    return base_url() . 'assets/css/';
}

/*
| This function returns the fulll path to the '/assets/img' directory
*/
function img_asset_url()
{
    return base_url() . 'assets/img/';
}

/*
| This function returns the fulll path to the '/assets/img' directory
*/
function js_asset_url()
{
    return base_url() . 'assets/js/';
}
