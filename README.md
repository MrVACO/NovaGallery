![Mr.VACO Gallery (For Laravel Nova)](https://preview.dragon-code.pro/Mr.VACO/Gallery%20(For%20Laravel%20Nova).svg?pretty-title=0&github%5Brepository%5D=MrVACO%2FNovaGallery&mode=auto)

# Laravel Nova Gallery

> Plugin used https://github.com/ayvazyan10/nova-imagic

## Installation

1. Publish migration:

```bash
php artisan vendor:publish --tag=gallery-migrations
```

2. Run migration:

```bash
php artisan migrate
```

3. After migrations you need to update routes:

```bash
php artisan route:cache
```

4. Ready! Login to the admin area and enjoy :D 