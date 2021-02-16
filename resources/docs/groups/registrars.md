# Registrars

Registrars are in the units and fiscalize transactions.

## Index

Paginate list of entities

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/registrars?page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/registrars"
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
            "unitId": 1,
            "numberLocal": "1212",
            "nextNumberLocal": 5303,
            "numberFiscal": "4000054593",
            "lastNumberFiscal": 0,
            "name": "Вчасно.Каса",
            "on": 1,
            "closed": true,
            "openedAt": "2021-02-16T09:37:27.000000Z",
            "closedAt": "2021-02-16T09:39:24.000000Z",
            "createdAt": "2021-02-09T16:02:55.000000Z",
            "updatedAt": "2021-02-16T09:39:24.000000Z"
        }
    ],
    "firstPageUrl": "http:\/\/localhost\/api\/registrars?page=1",
    "from": 1,
    "nextPageUrl": null,
    "path": "http:\/\/localhost\/api\/registrars",
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
    "http://localhost/api/registrars" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"unitId":1,"numberLocal":"123441","numberFiscal":"4000051101","name":"Nesterenko Volodymyr Borysovych (Test)","on":true,"closed":true}'
```

```javascript
const url = new URL(
    "http://localhost/api/registrars"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "unitId": 1,
    "numberLocal": "123441",
    "numberFiscal": "4000051101",
    "name": "Nesterenko Volodymyr Borysovych (Test)",
    "on": true,
    "closed": true
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

> Example response (201):

```json
{
    "id": 1,
    "unitId": 1,
    "numberLocal": 1,
    "numberFiscal": "23",
    "name": "Nesterenko Volodymyr Borysovych (Test)",
    "on": true,
    "closed": true,
    "updatedAt": "2020-12-23T13:35:12.000000Z",
    "createdAt": "2020-12-23T13:35:12.000000Z"
}
```

## Get

Get entity by ID

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/registrars/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/registrars/1"
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
    "unitId": 1,
    "numberLocal": 1,
    "numberFiscal": "23",
    "name": "Nesterenko Volodymyr Borysovych (Test)",
    "on": true,
    "closed": true,
    "updatedAt": "2020-12-23T13:35:12.000000Z",
    "createdAt": "2020-12-23T13:35:12.000000Z"
}
```

## Update

Update existing entity by ID

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/registrars/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"unitId":1,"numberLocal":"123441","numberFiscal":"4000051101","name":"Nesterenko Volodymyr Borysovych (Test)","on":true,"closed":true}'
```

```javascript
const url = new URL(
    "http://localhost/api/registrars/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "unitId": 1,
    "numberLocal": "123441",
    "numberFiscal": "4000051101",
    "name": "Nesterenko Volodymyr Borysovych (Test)",
    "on": true,
    "closed": true
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
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
    "http://localhost/api/registrars/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/registrars/1"
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
* [Legals](legals.md)
* [Units](units.md)
* [Commands](commands.md)
* [Receipts](receipts.md)
