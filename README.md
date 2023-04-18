laravel-admin extension
======

# BForm

Dynamic laravel-admin form-builder with form-validation panel


## Configuration

In the `extensions` section of the `config/admin.php` file, add some configuration that belongs to this extension.
```php

    'extensions' => [

        'bform' => [
        
            //Set to false if you want to disable this extension
            'enable' => true,
            
            // Editor configuration
            'config' => [
                'prefix' => 'bform',
                'db-prefix' => 'bform_',
            ]
        ]
    ]

```

## Installation

1. `composer require laravel-admin-ext/bform`
2. `php artisan migration`
3. `php artisan db:seed BFormMenuSeeder` to add relate admin-menus

## TODO

- [ ] Menus seeder
- [ ] Prevent duplicate field for a pattern
- [ ] Breadcrumb or link to patterns in pattern-fields panel
