# Legals

Legal persons who carry out commodity transactions

## Index
Paginate list of entities

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/legals?page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/legals"
);

let params = {
    "page": "1",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "currentPage": 1,
    "data": [
        {
            "id": 1,
            "tin": "627133",
            "createdAt": "2021-02-09T14:24:15.000000Z",
            "updatedAt": "2021-02-09T15:34:14.000000Z"
        }
    ],
    "firstPageUrl": "http:\/\/localhost\/api\/legals?page=1",
    "from": 1,
    "nextPageUrl": null,
    "path": "http:\/\/localhost\/api\/legals",
    "perPage": 20,
    "prevPageUrl": null,
    "to": 1
}
```

## Create
Creates an entity

> Example request:

```bash
curl -X POST \
    "http://localhost/api/legals" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -F "tin=34554363" \
    -F "passphrase=tect4" \
    -F "key=@/tmp/phpdAiNOI"     -F "cert=@/tmp/phpHkhaJG" 
```

```javascript
const url = new URL(
    "http://localhost/api/legals"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('tin', '34554363');
body.append('passphrase', 'tect4');
body.append('key', document.querySelector('input[name="key"]').files[0]);
body.append('cert', document.querySelector('input[name="cert"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response => response.json());
```

> Example response (201):

```json
{
    "id": 1,
    "tin": "345333342",
    "createdAt": "2021-02-08T21:59:43.000000Z",
    "updatedAt": "2021-02-08T21:59:43.000000Z"
}
```

## Get
Get entity by ID

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/legals/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/legals/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "id": 1,
    "tin": "345333342",
    "createdAt": "2021-02-08T21:59:43.000000Z",
    "updatedAt": "2021-02-08T21:59:43.000000Z"
}
```

## Update
Update existing entity by ID

> Example request:

```bash
curl -X POST \
    "http://localhost/api/legals/1" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -F "tin=34554363" \
    -F "passphrase=tect4" \
    -F "key=@/tmp/phphcKHgN"     -F "cert=@/tmp/phpLmdjKo" 
```

```javascript
const url = new URL(
    "http://localhost/api/legals/1"
);

let headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('tin', '34554363');
body.append('passphrase', 'tect4');
body.append('key', document.querySelector('input[name="key"]').files[0]);
body.append('cert', document.querySelector('input[name="cert"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "message": "OK"
}
```

## Delete
Delete existing entity by ID

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/legals/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/legals/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "message": "OK"
}
```

## Documentation

* [Introduction](../index.md)
* [Units](units.md)
* [Registrars](registrars.md)
* [Commands](commands.md)
* [Receipts](receipts.md)
