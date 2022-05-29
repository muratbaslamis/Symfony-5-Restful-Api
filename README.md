Symfony 5 Restful api

-  <a href="https://www.getpostman.com/collections/bca9652c9b479fa2abb6" target="_blank"> Postman Collection </a>


Token Alma

İstek
```json
POST /login_check HTTP/1.1
Accept: application/json
Content-Type: application/json
Content-Length: xy

{
    "username":"muratbaslamis",
    "password":"testsifre"
}
```
Cevap
```json
HTTP/1.1 200 OK
Server: localhost
Content-Type: application/json
Content-Length: xy

{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDI5MjM2ODksImV4cCI6MTYwMjkyNzI4OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdF91c2VybmFtZTIifQ.Ax_5TjrU_aID5lonG8ENaxpL-9-NYdgOu_5Ly9CC-3Bi4LU7vzuqq_OdQ8FvMtdTw3qoLMJp2RJ9L86B4qHTicZMdOiOJ8aMY_tlQQRY1p2Bx3weSK1p4VHdRLl20aEOZLFyBJCfPia4EqZidzzlmD8mrr_-atSQ1eD2VWQmqbT5ux2p5Rqg768aut1w3Se2xIuU_ijmtgXtngN_OyPpUxTYXWLXc4690i0BQYhPgHFk8EIm2qa3ZboumPnle6uywIX43PL6-ORWknmuoPrah7QV0oKCTCeFsxBQlbJwlzpPaWBFSCRI9aWAJahZodK2pq7BPFFspmy9wprJXasxEg"
}
```

**Failed Response:**
```json
HTTP/1.1 401 Unauthorized
Server: localhost
Content-Type: application/json
Content-Length: xy

{
    "code": 401,
    "message": "Invalid credentials."
}
``` 


Sipariş Ekleme

kullaniciid = jwt tokena göre alınıyor

İstek
```json
POST /api/siparisler/ekle HTTP/1.1
Accept: application/json
Content-Type: application/json
Content-Length: xy

{
    "orderCode":"23",
    "productid":"asdasd",
    "quantity":"3",
    "address":"test adres"
}
```
Cevap
```json
HTTP/1.1 201 Created
Server: localhost
Content-Type: application/json
Content-Length: xy

{
"status":"Sipariş eklendi"
}
```
**Failed Response:**
```json
HTTP/1.1 500 Server Error
Server: localhost
Content-Type: application/json
Content-Length: xy

{
    "code": 500,
    "message": "Integrity constraint violation: 1062 Duplicate entry 'orderCode_example' for key 'UNIQ_E52FFDEE3AE40A8F'"
}
``` 

Sipariş Güncelleme

kullaniciid ve sipariş id ye göre güncelleme yapılır.Sipariş kargo günü (Shippingdate) geçtiyse güncelleme yapmaz.

İstek
```json
PUT api/siparisler/guncelle/1 HTTP/1.1
Accept: application/json
Content-Type: application/json
Content-Length: xy

{
    "orderCode":"77777",
    "productid":"3",
    "quantity":"3",
    "address":"test adres"
}
```
Cevap
```json
HTTP/1.1 200 OK
Server: localhost
Content-Type: application/json
Content-Length: xy


{
"status":"Sipariş güncellendi"
}


```
**Failed Response:**
```json
HTTP/1.1 500 Server Error
Server: localhost
Content-Type: application/json
Content-Length: xy

{
    "code": 500,
    "message": "Notice: Undefined index: (yanlis gönderilen parametreler keyleri veya gönderilmeyen parametreler)"
}
``` 

Sipariş Detay

sipariş id ye ve kullanıcı id ye göre sipariş response edilir.

İstek
```json
GET api/siparisler/detay/1 HTTP/1.1

```
Cevap
```json
HTTP/1.1 200 OK
Server: My RESTful API
Content-Type: application/json
Content-Length: xy

{
    "id": 1,
    "orderCode": "77777",
    "productid": 3,
    "quantity": 3,
    "address": "test adres",
    "shippingdate": {
        "date": "2022-05-30 19:57:03.000000",
        "timezone_type": 3,
        "timezone": "Europe/Berlin"
    }
}
```
**Failed Response:**
```json
HTTP/1.1 404 Cannot be found
Server: localhost
Content-Type: application/json
Content-Length: xy

{
    "code": 404,
    "message": "Sipariş bulunamadı"
}
``` 


Sipariş Listesi


İstek
```json
GET /api/siparisler/siparislerim HTTP/1.1

```
Cevap
```json
HTTP/1.1 200 OK
Server: My RESTful API
Content-Type: application/json
Content-Length: xy

[
    {
        "id": 1,
        "orderCode": "77777",
        "productid": 3,
        "quantity": 3,
        "address": "test adres",
        "shippingdate": {
            "date": "2022-05-30 19:57:03.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        }
    },
    {
        "id": 3,
        "orderCode": "111",
        "productid": 12,
        "quantity": 3,
        "address": "test adres",
        "shippingdate": {
            "date": "2022-05-30 23:56:18.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        }
    },
    {
        "id": 5,
        "orderCode": "33333",
        "productid": 0,
        "quantity": 3,
        "address": "test adres",
        "shippingdate": {
            "date": "2022-05-30 00:01:28.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        }
    },
    {
        "id": 7,
        "orderCode": "31",
        "productid": 0,
        "quantity": 3,
        "address": "test adres",
        "shippingdate": {
            "date": "2022-05-30 00:01:48.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        }
    },
    {
        "id": 8,
        "orderCode": "23",
        "productid": 0,
        "quantity": 3,
        "address": "test adres",
        "shippingdate": {
            "date": "2022-05-30 00:01:51.000000",
            "timezone_type": 3,
            "timezone": "Europe/Berlin"
        }
    }
]
```
**Failed Response:**
```json
HTTP/1.1 404 Cannot be found
Server: My RESTful API
Content-Type: application/json
Content-Length: xy

{
    "code": 404,
    "message": "Sipariş bulunamadı"
}
``` 
