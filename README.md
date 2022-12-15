<p align="center"><img src="./laravel-grapes-logo.png" width="300"></p>
<p align="center">
<img src="https://img.shields.io/packagist/v/mnapoli/PHP-DI.svg">
<img alt="GitHub" src="https://img.shields.io/github/license/allamo123/laravel-grapes?color=%23000&style=plastic">
<img alt="Total Download" src="https://img.shields.io/packagist/dm/msa/laravel-grapes">
<img alt="GitHub release (latest by date including pre-releases)" src="https://img.shields.io/github/v/release/allamo123/laravel-grapes?include_prereleases">
</p>
<p align="left"><img src="./screenshots/screenshot_01.png"></p>

## About Laravel Grapes

Laravel Grapes is a library for laravel framework, that offer cms drag and drop page builder for frontend which support all Laravel functionality and help user to change all frontend and content just in simple clicks.

Laravel Grapes Comes With A Pro Version Available On [Code Canyon](https://codecanyon.net/)

## Installation Steps

```jsx 
composer require msa/laravel-grapes
```
```jsx 
php artisan vendor:publish --provider="MSA\LaravelGrapes\LaravelGrapesServiceProvider" --tag="*"
```

```jsx 
php artisan migrate
```


#### Go to config/lg.php

```jsx
    <?php

    return [
        // routes configurations
        'builder_prefix' => 'hello', // prefix for builder

        'middleware' => null, // middleware for builder

        'frontend_prefix' => 'hi', // prefix for frontend
    ];`
```

##### 1) builder_prefix
<p>The builder by default come with route front hello/front-end-builder.<p>
<p>you can change the builder prefix to hi so now the builder load with route prefix hi instead of hello.<p>
