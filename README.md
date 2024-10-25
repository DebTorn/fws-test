# FWS test task

[![Tech stack](https://skillicons.dev/icons?i=php,laravel,mysql,docker,redis)](https://skillicons.dev)

This task was prepared for FWS Online Ltd.

---

## :rocket: Features :rocket:

- :bulb: Sync DB from CSV
- :bulb: Export products as XML

---

## 💾 Installation 💾

1. Create `.env` file based on `.env.example`. Pay close attention to the instructions which marked with **"TODO"**!

2. Start `sail` docker containers with the following command:
    ```batch
    ./vendor/bin/sail up -d --build
    ```

3. Jump into `container` shell:
    ```batch
    docker exec -it todo-list-todo-app-1 /bin/bash
    ```

4. Install `composer` packages within the `container`:
    ```batch
     composer install
    ```

5. Generate `app-key` with `artisan` keygen within `container` shell:
    ```batch
    php artisan key:generate
    ```

6. Run  `migrations` with seeder in the `container` shell:
    ```batch
    php artisan migrate
    ```

7. Regenerate `container` in the base shell:
    ```batch
    ./vendor/bin/sail down
    ./vendor/bin/sail up -d --build
    ```

---

## 🤕 Header requirements 🤕

The following informations must also be sent in the header:

```
Accept:        application/json
Content-type:  application/json
```

The header's `Content-type` parameter is mostly `application/json`. If it's not, it will be mentioned at the endpoint description.

---

## Endpoints

### Import
This endpoint triggers the CSV import process.

**Before** triggering the import process, copy the `CSV_FILE_NAME` file into the `storage/app/private` folder and set the `csv` name in the `.env` file.

*Type*: **POST**
*URI*: `/api/import`
*Response format*: `JSON`

**After triggered**
```json
{
	"message": "CSV import already in progress"
}
```

:warning: **IMPORTANT:** :warning: After triggered the import you an check the process status in `storage/logs/laravel.log`. In this file you an see the current chunk and when the process finished.

### Export
This endpoint triggers the XML export process.

**Before** triggering the export process, set the `XML_FILE_NAME` name in the `.env` file.

In the end of the process you can check the file in `storage/app/public` folder.

*Type*: **GET**
*URI*: `/api/export`
*Response format*: `JSON`

**Response when XML created**
```json
{
	"message": "XML file exported successfully",
	"file_path": "/var/www/html/storage/app/public/xy.xml"
}
```
