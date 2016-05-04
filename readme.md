# Drupalcamp Athens website repository!

This repository is used for drupalcamp website development collaboration.

### How to install:

##### 1. Clone git repository
 
```sh
git clone https://github.com/drupalcampgr/page2016.git
```

##### 1. Initialize settings.php

```sh
cd page2016
cp sites/default/default.settings.php sites/default/settings.php
nano settings.php
```
```sh
$databases['default']['default'] = array (
  'database' => 'drupalcamp',
  'username' => 'drupalcamp',
  'password' => 'xxxxxxxxx',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '',
  'driver' => 'mysql',
);

$config_directories['sync'] = 'config/sync';
```

**Note: I also initialized hash_salt as it was also required for me**
If you get any errors just add a random string in settings.php

```sh
$settings['hash_salt'] = 'PUT_SOMETHING_HERE';
```

##### 3. Install site normally

```sh
drush si
```
**(you might to save the username/password from the results)**

```sh
drush cset "system.site" uuid 30f9bfa2-9a2f-43d7-82c7-ef96c5c3bbef -y
drush cim -y
```

-----------------------
The import failed due for the following reasons:
Entities exist of type Shortcut link and Default. These entities
need to be deleted before importing.

```sh
drush ev '\Drupal::entityManager()->getStorage("shortcut_set")->load("default")->delete();'
drush cim -y
```

