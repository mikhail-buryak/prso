# Commands

Actions for sync and processing data from the tax api

## Get objects

Get business units registered for a legal person

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/commands/legal/1/objects/max/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/legal/1/objects/max/1"
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
    "taxObjects": [
        {
            "entity": 55137,
            "singleTax": false,
            "name": "\"Новорічна лавка\"",
            "address": "УКРАЇНА, ЖИТОМИРСЬКА ОБЛ., М. КОРОСТЕНЬ, вул.Михайла Грушевського, 15-А",
            "tin": "34554363",
            "ipn": "123456789020",
            "orgName": "Тестовий платник 4",
            "transactionsRegistrars": [
                {
                    "numFiscal": 4000054593,
                    "numLocal": 1212,
                    "name": "Вчасно.Каса",
                    "closed": false
                }
            ]
        }
    ]
}
```

## Post objects

Create/restore business units, registrars registered for a legal person

> Example request:

```bash
curl -X POST \
    "http://localhost/api/commands/legal/1/objects/max/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/legal/1/objects/max/1"
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
    "message": "OK",
    "touchedUnits": 327,
    "touchedRegistrars": 2078
}
```

## Get registrar state

Return the current state of the registrar

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/commands/registrar/1/state" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/state"
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
    "shiftState": 0,
    "shiftId": 206591,
    "openShiftFiscalNum": "3168306",
    "zRepPresent": true,
    "name": null,
    "subjectKeyId": null,
    "firstLocalNum": 5303,
    "nextLocalNum": 5308,
    "lastFiscalNum": null,
    "offlineSupported": true,
    "chiefCashier": true,
    "offlineSessionId": "10852",
    "offlineSeed": "934715197384212",
    "offlineNextLocalNum": "1",
    "offlineSessionDuration": "0",
    "offlineSessionsMonthlyDuration": "0",
    "closed": false,
    "taxObject": null
}
```

## Post registrar state

Sync the current state of the registrar

> Example request:

```bash
curl -X POST \
    "http://localhost/api/commands/registrar/1/state" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/state"
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
    "message": "OK"
}
```

## Get shifts

Returns shift history objects for the specified registrar

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/commands/registrar/1/shifts?from=ipsa&amp;to=tempore?from=2020-12-24+20%3A20%3A20.000000&to=2020-12-25+20%3A20%3A20.000000" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/shifts?from=ipsa&amp;to=tempore"
);

let params = {
    "from": "2020-12-24 20:20:20.000000",
    "to": "2020-12-25 20:20:20.000000",
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
    "shifts": [
        {
            "shiftId": 69372,
            "openShiftFiscalNum": "1059974",
            "closeShiftFiscalNum": "1063799",
            "opened": "2020-12-25T12:43:17.694345",
            "openName": "Тестовий платник 4 (Тест)",
            "openSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "closed": "2020-12-25T15:54:50.265822",
            "closeName": "Тестовий платник 4 (Тест)",
            "closeSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "zRepFiscalNum": "1063798"
        },
        {
            "shiftId": 69499,
            "openShiftFiscalNum": "1063829",
            "closeShiftFiscalNum": "1064209",
            "opened": "2020-12-25T15:56:19.202484",
            "openName": "Тестовий платник 4 (Тест)",
            "openSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "closed": "2020-12-25T16:12:33.596632",
            "closeName": "Тестовий платник 4 (Тест)",
            "closeSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "zRepFiscalNum": "1064208"
        },
        {
            "shiftId": 69518,
            "openShiftFiscalNum": "1064743",
            "closeShiftFiscalNum": "1067190",
            "opened": "2020-12-25T16:35:12.11172",
            "openName": "Тестовий платник 4 (Тест)",
            "openSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "closed": "2020-12-25T18:39:36.877732",
            "closeName": "Тестовий платник 4 (Тест)",
            "closeSubjectKeyId": "e95d10f3c104b1bbe5c74a8eaaccb4c33300d5d6306b45ce3154765f6b334459",
            "zRepFiscalNum": "1067189"
        }
    ]
}
```

## Get documents

Return the list of documents for the specified registrar shift

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/commands/registrar/1/shifts/68842/documents" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/shifts/68842/documents"
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
    "documents": [
        {
            "numFiscal": "1059974",
            "numLocal": 1423,
            "docDateTime": "2020-12-25T12:43:17",
            "docClass": "Check",
            "checkDocType": "OpenShift",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1060684",
            "numLocal": 1424,
            "docDateTime": "2020-12-25T13:22:04",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1060864",
            "numLocal": 1425,
            "docDateTime": "2020-12-25T13:32:51",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": true
        },
        {
            "numFiscal": "1060887",
            "numLocal": 1426,
            "docDateTime": "2020-12-25T13:33:52",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1060911",
            "numLocal": 1427,
            "docDateTime": "2020-12-25T13:35:05",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1060978",
            "numLocal": 1428,
            "docDateTime": "2020-12-25T13:38:11",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1061016",
            "numLocal": 1429,
            "docDateTime": "2020-12-25T13:40:19",
            "docClass": "Check",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1063798",
            "numLocal": 1430,
            "docDateTime": "2020-12-25T15:54:49",
            "docClass": "ZRep",
            "checkDocType": "SaleGoods",
            "revoked": false,
            "storned": false
        },
        {
            "numFiscal": "1063799",
            "numLocal": 1431,
            "docDateTime": "2020-12-25T15:54:50",
            "docClass": "Check",
            "checkDocType": "CloseShift",
            "revoked": false,
            "storned": false
        }
    ]
}
```

## Get last shift totals

Return the data of last shift for the specified registrar

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/commands/registrar/1/shifts/last/totals" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/shifts/last/totals"
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
    "shiftState": 1,
    "zRepPresent": false,
    "totals": {
        "real": {
            "sum": 1252.98,
            "totalCurrencyCommission": 0,
            "ordersCount": 3,
            "totalCurrencyCost": 0,
            "payForm": [
                {
                    "payFormCode": 0,
                    "payFormName": "ГОТІВКА",
                    "sum": 952.98
                },
                {
                    "payFormCode": 1,
                    "payFormName": "КАРТКА",
                    "sum": 300
                }
            ],
            "tax": [
                {
                    "type": 0,
                    "name": "ПДВ",
                    "letter": "A",
                    "prc": 20,
                    "sign": false,
                    "turnover": 894.48,
                    "sourceSum": 0,
                    "sum": 178.89
                },
                {
                    "type": 0,
                    "name": "ПДВ",
                    "letter": "Б",
                    "prc": 7,
                    "sign": false,
                    "turnover": 358.5,
                    "sourceSum": 0,
                    "sum": 4.29
                }
            ]
        },
        "ret": null,
        "cash": null,
        "currency": null,
        "serviceInput": 0,
        "serviceOutput": 0
    }
}
```

## Close shift

Generate and send a Z-report, close the shift for the specified registrar

> Example request:

```bash
curl -X POST \
    "http://localhost/api/commands/registrar/1/shifts/close" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/commands/registrar/1/shifts/close"
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
    "message": "OK"
}
```

## Documentation

* [Introduction](../index.md)
* [Legals](legals.md)
* [Units](units.md)
* [Registrars](registrars.md)
* [Receipts](receipts.md)
