## Installation
### Composer
Run the following command:
```
composer require bluesheep/php-jsonenv
```

## Usage
A simple example:
```php
<?php

use JsonEnv/JsonEnv;

$env = new JsonEnv();
$env->load();
```

## Notes
- The default filename is `env.json`. It is recommended to override this with an absolute path.


