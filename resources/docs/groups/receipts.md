# Receipts

Fiscalization of receipts and returns

## Validate

Sends a check for fiscalization, returns an object containing information about the check, local and fiscal numbers.

Automatically opens a shift if it is closed.

> Example request:

```json
{
    "meta": {
        "personTin": "627133",
        "registrarFiscal": "4000054593",
        "orderCode": "123-321-123"
    },
    "total": {
        "sum": "417.66"
    },
    "pay": [
        {
            "payformcd": "0",
            "payformnm": "ГОТІВКА",
            "sum": "317.66",
            "provided": "400.00",
            "remains": "82.34"
        },
        {
            "payformcd": "1",
            "payformnm": "КАРТКА",
            "sum": "100.00"
        }
    ],
    "tax": [
        {
            "type": "0",
            "name": "ПДВ",
            "letter": "A",
            "prc": "20.00",
            "sign": "false",
            "turnover": "298.16",
            "sum": "59.63"
        },
        {
            "type": "0",
            "name": "ПДВ",
            "letter": "Б",
            "prc": "7.00",
            "sign": "false",
            "turnover": "119.50",
            "sum": "1.43"
        }
    ],
    "body": [
        {
            "code": "98765",
            "uktzed": "876543",
            "name": "Куряче Стегно",
            "unitcd": "25",
            "unitnm": "кг",
            "amount": "5.701",
            "price": "52.30",
            "letters": "A",
            "cost": "298.16"
        },
        {
            "code": "76543456",
            "uktzed": "543210",
            "name": "Пиво",
            "unitcd": "87",
            "unitnm": "бут",
            "amount": "6",
            "price": "16.50",
            "letters": "Б",
            "cost": "99.00"
        },
        {
            "code": "76543123",
            "uktzed": "876543",
            "name": "Сироп від кашлю",
            "unitcd": "87",
            "unitnm": "бут",
            "amount": "1",
            "price": "20.50",
            "letters": "Б",
            "cost": "20.50"
        }
    ]
}
```

```bash
curl -X POST \
    "http://localhost/api/receipt/validate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/receipt/validate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "type": 0,
    "subType": 0,
    "uuid": "490f968b-569a-4bcc-b0d1-f3ba5b4887b3",
    "status": 200,
    "numberFiscal": "3228434",
    "fiscalAt": "2021-02-16T18:08:40.000000Z",
    "numberLocal": 5322,
    "createdAt": "2021-02-16T18:08:44.000000Z",
    "id": 1,
    "orderCode": "123-321-123",
    "registrarFiscal": "4000054593",
    "unitName": "\"Новорічна лавка\"",
    "unitOrgName": "Тестовий платник 4",
    "unitAddress": "УКРАЇНА, ЖИТОМИРСЬКА ОБЛ., М. КОРОСТЕНЬ, вул.Михайла Грушевського, 15-А"
}
```

## Return

Sends a check with items for return with specify the original check fiscal number, returns an object containing
information about the return check, local and fiscal number.

Automatically opens a shift if it is closed.

> Example request:

```json
{
    "meta": {
        "personTin": "627133",
        "registrarFiscal": "4000054593",
        "orderCode": "123-321-123",
        "refundFiscal": "3226198"
    },
    "total": {
        "sum": "397.16"
    },
    "pay": [
        {
            "payformcd": "0",
            "payformnm": "ГОТІВКА",
            "sum": "397.16",
            "provided": "397.16"
        }
    ],
    "tax": [
        {
            "type": "0",
            "name": "ПДВ",
            "letter": "A",
            "prc": "20.00",
            "sign": "false",
            "turnover": "397.16",
            "sum": "79.42"
        }
    ],
    "body": [
        {
            "code": "98765",
            "uktzed": "876543",
            "name": "Куряче Стегно",
            "unitcd": "25",
            "unitnm": "кг",
            "amount": "5.701",
            "price": "52.30",
            "letters": "A",
            "cost": "298.16"
        },
        {
            "code": "76543456",
            "uktzed": "543210",
            "name": "Молоко 3.2%",
            "unitcd": "87",
            "unitnm": "бут",
            "amount": "6",
            "price": "16.50",
            "letters": "A",
            "cost": "99.00"
        }
    ]
}
```

```bash
curl -X POST \
    "http://localhost/api/receipt/refund" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/receipt/refund"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "type": 0,
    "subType": 1,
    "uuid": "823c8fdf-778d-4a0a-9e3d-89b6be8c88c5",
    "status": 200,
    "numberFiscal": "3228481",
    "fiscalAt": "2021-02-16T18:10:04.000000Z",
    "numberLocal": 5323,
    "createdAt": "2021-02-16T18:10:05.000000Z",
    "id": 2,
    "orderCode": "1604998114-0080",
    "registrarFiscal": "4000054593",
    "unitName": "\"Новорічна лавка\"",
    "unitOrgName": "Тестовий платник 4",
    "unitAddress": "УКРАЇНА, ЖИТОМИРСЬКА ОБЛ., М. КОРОСТЕНЬ, вул.Михайла Грушевського, 15-А"
}
```

## Cancel

Sends a document containing the fiscal number of the sent previously document for which need to cancel, aka
&quot;Storno&quot; operation.

Automatically opens a shift if it is closed.

> Example request:

```json
{
    "meta": {
        "cancelFiscal": "3226286"
    }
}
```

```bash
curl -X POST \
    "http://localhost/api/receipt/cancel" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/receipt/cancel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

> Example response (200):

```json
{
    "type": 0,
    "subType": 5,
    "uuid": "2f2f50eb-4abf-4fbf-8ab1-bafa56988dbf",
    "status": 200,
    "numberFiscal": "3226389",
    "fiscalAt": "2021-02-16T17:30:36.000000Z",
    "numberLocal": 5314,
    "createdAt": "2021-02-16T17:30:37.000000Z",
    "id": 20
}
```

## Transaction

Return an object containing information about the check by fiscal number.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/receipt/transaction/fiscal/3226389" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/receipt/transaction/fiscal/aut"
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
    "type": 0,
    "subType": 5,
    "uuid": "2f2f50eb-4abf-4fbf-8ab1-bafa56988dbf",
    "status": 200,
    "numberFiscal": "3226389",
    "fiscalAt": "2021-02-16T17:30:36.000000Z",
    "numberLocal": 5314,
    "createdAt": "2021-02-16T17:30:37.000000Z",
    "id": 20
}
```

## Documentation

* [Introduction](../index.md)
* [Legals](legals.md)
* [Units](units.md)
* [Registrars](registrars.md)
* [Commands](commands.md)
