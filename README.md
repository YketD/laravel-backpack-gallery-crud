# YketD\BackpackGalleryCrud

Attempt to make the gallery crud field from Backpack work with Laravel 8 & 9.



# Original docs: SeanDowney\BackpackGalleryCrud

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

An admin interface to easily add/edit/remove Gallery, using [Laravel Backpack](laravelbackpack.com).

It uses [Glide](http://glide.thephpleague.com/) and provides helper methods to serve the images in frontend blade templates.

## Install

1) In your terminal:

``` bash
$ composer require seandowney/backpackgallerycrud
```

2) If your Laravel version does not have package autodiscovery then add the service provider to your config/app.php file:
```php
Cviebrock\EloquentSluggable\ServiceProvider::class,
SeanDowney\BackpackGalleryCrud\GalleryCRUDServiceProvider::class,
```

3) Publish the config file & run the migrations
```bash
$ php artisan vendor:publish --provider="SeanDowney\BackpackGalleryCrud\GalleryCRUDServiceProvider" #publish config, view  and migration files
$ php artisan migrate #create the gallery table
```

4) Configuration of file storage in `config/filesystems.php`.

```php
'galleries' => [
    'driver' => 'local',
    'root' => storage_path('app/galleries'),
],
```

5) Configuration of file storage in config/elfinder.php:

```php
'roots' => [
    [
        'driver'        => 'GalleryCrudLocalFileSystem',         // driver for accessing file system (REQUIRED)
        'path'          => '../storage/app/galleries',           // path to files - relative to `public` (REQUIRED)
        'URL'           => '/galleries', // URL to files (REQUIRED)
        'accessControl' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
        'autoload'      => true,
        'tmbPath'       => '',
        'tmbSize'       => 150,
        'tmbCrop'       => false,
        'tmbBgColor'    => '#000',
    ],
],
```

6) [Optional] Configuration of Glide image path in `config/seandowney/gallerycrud.php`.

```php
'glide_path' => 'image',
```

7) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/gallery') }}"><i class="fa fa-picture-o"></i> <span>Gallery</span></a></li>
```

## How to use the package
This package relies heavily on the `elFinder` File Manager in Bakpack.

* First create a gallery
* In your galleries folder (the `path` setting in your `config/elfinder.php` roots), create a folder with the same name as the `slug` in your gallery record.
* Upload image files into the folder
* Now you can edit the gallery and the images are visible
* You can add captions and include the images in the gallery or not
* To remove images from the gallery
  * uncheck the `Include` checkbox
  * then in the file manager remove the file from the folder for that gallery
* Helper methods are now available to load the images using Glide.
  * `gallery_image_url` will load images from a gallery eg `gallery_image_url($item['image_path'].'?w=300&h=200')`
  * `image_url` can be used where the images is from a `browse` field type so it may already include the disk path

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email sean at considerweb dot com instead of using the issue tracker.

## Credits

- Seán Downey - Lead Developer
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/seandowney/backpackgallerycrud.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/seandowney/backpackgallerycrud.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/seandowney/backpackgallerycrud
[link-downloads]: https://packagist.org/packages/seandowney/backpackgallerycrud
[link-contributors]: ../../contributors
