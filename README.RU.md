![Mr.VACO Gallery (For Laravel Nova)](https://preview.dragon-code.pro/Mr.VACO/Gallery%20(For%20Laravel%20Nova).svg?pretty-title=0&github%5Brepository%5D=MrVACO%2FNovaGallery&mode=auto)

# Laravel Nova Галерея

> Использован плагин https://github.com/ayvazyan10/nova-imagic

## Установка

1. Выполнить публикацию миграции:

```bash
php artisan vendor:publish --tag=gallery-migrations
```

2. Выполнить миграцию:

```bash
php artisan migrate
```

3. После миграций необходимо обновить роуты:

```bash
php artisan route:cache
```

4. Готово! Заходи в админку и наслаждайся :D 