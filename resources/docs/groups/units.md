# Units

Business units owned by the legal entity in which the transaction is carried out (store, warehouse, etc.)

## Index

Paginate list of entities

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/units?page=1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/units"
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
            "legalId": 1,
            "taxId": "55137",
            "tin": "34554363",
            "ipn": "123456789020",
            "name": "\"Новорічна лавка\"",
            "orgName": "Тестовий платник 4",
            "address": "УКРАЇНА, ЖИТОМИРСЬКА ОБЛ., М. КОРОСТЕНЬ, вул.Михайла Грушевського, 15-А",
            "createdAt": "2021-02-09T16:02:55.000000Z",
            "updatedAt": "2021-02-09T16:02:55.000000Z"
        }
    ],
    "firstPageUrl": "http:\/\/localhost\/api\/units?page=1",
    "from": 1,
    "nextPageUrl": null,
    "path": "http:\/\/localhost\/api\/units",
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
    "http://localhost/api/units" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"personId":1,"taxId":"12344512","tin":"34554363","ipn":"123456789018","name":"Store#1","orgName":"Company#1","address":"Ukraine, Kiev, Lugova, 2"}'

```

```javascript
const url = new URL(
    "http://localhost/api/units"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "personId": 1,
    "taxId": "12344512",
    "tin": "34554363",
    "ipn": "123456789018",
    "name": "Store#1",
    "orgName": "Company#1",
    "address": "Ukraine, Kiev, Lugova, 2"
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
    "personId": 1,
    "taxId": "12324514",
    "tin": "34554355",
    "ipn": "123456789012",
    "name": "Store#1",
    "orgName": "Company#1",
    "address": "Ukraine, Kiev, Lugova, 2",
    "updatedAt": "2020-12-23T13:57:07.000000Z",
    "createdAt": "2020-12-23T13:57:07.000000Z"
}
```

## Get

Get entity by ID

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/units/17" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/units/17"
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
    "personId": 1,
    "taxId": "12324514",
    "tin": "34554355",
    "ipn": "123456789012",
    "name": "Store#1",
    "orgName": "Company#1",
    "address": "Ukraine, Kiev, Lugova, 2",
    "updatedAt": "2020-12-23T13:57:07.000000Z",
    "createdAt": "2020-12-23T13:57:07.000000Z"
}
```

## Update

Update existing entity by ID

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/units/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"personId":1,"taxId":"12344512","tin":"34554363","ipn":"123456789018","name":"Store#1","orgName":"Company#1","address":"Ukraine, Kiev, Lugova, 2"}'

```

```javascript
const url = new URL(
    "http://localhost/api/units/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "personId": 1,
    "taxId": "12344512",
    "tin": "34554363",
    "ipn": "123456789018",
    "name": "Store#1",
    "orgName": "Company#1",
    "address": "Ukraine, Kiev, Lugova, 2"
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
    "http://localhost/api/units/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/units/1"
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
* [Registrars](registrars.md)
* [Commands](commands.md)
* [Receipts](receipts.md)
