# Check code

run `composer test` for phpunit

run `composer check` for ecs-fix and phpstan


# test project

There is a list of reservations in JSON saved in file reservations.json. The content of the file is:

```json
[  
   {  
      "reservationId":123456,
      "guest":"Petr Klas",
      "room":"Double room",
      "type": "day",
      "prices":{  
         "2019-05-01":"25.3",
         "2019-05-02":"25.3",
         "2019-05-03":"25.3",
         "2019-05-04":"25.3"
      },
      "currency":"EUR",
      "alreadyPaid":"50"
   },
   {  
      "reservationId":569833,
      "guest":"Miro Zbirka",
      "room":"Sauna",
      "type": "hour",
      "prices":{  
         "2019-06-08T14:00:00":"900",
         "2019-06-08T15:00:00":"800",
         "2019-06-08T16:00:00":"800",
         "2019-06-08T17:00:00":"800"
      },
      "currency":"CZK",
      "alreadyPaid":"500" 
   }
]
```

* type - type of the reservation (day means reservation booked for multiple days,  hour  means reservation booked for multiple hours)
* prices - price for each night / hour.
* alreadyPaid - already paid amount

# Your task

Your task is to write the code in OOP PHP that read the file, and it's content, transform the JSON in new structure and store transformed JSON into the file called "/tmp/reservations_transformed.json"

The output format should be as follows:

```json
[
  {
    "reservationId":123456,
    "firstName":"Petr",
    "lastName":"Klas",
    "room":"Double room",
    "term":{
      "from":"2019-05-01",
      "to":"2019-05-05",
      "nights":4
    },
    "priceToBePaid":[
      {
        "currency":"CZK",
        "price":"1331.2"
      },
      {
        "currency":"EUR",
        "price":"51.2"
      }
    ]
  },
  {
    "reservationId":569833,
    "firstName":"Miro",
    "lastName":"Zbirka",
    "room":"Sauna",
    "term":{
      "from":"2019-06-08T14:00:00",
      "to":"2019-06-08T17:00:00",
      "hours":4
    },
    "priceToBePaid":[
      {
        "currency":"CZK",
        "price":"2800"
      },
      {
        "currency":"EUR",
        "price":"107.69"
      }
    ]
  }
]
```

* prices for each day / hour should be tranformed into date / time range (from - to). In case of days, there should be always +1 day, because the guest stays four nights, which is equal to 5 days.
* you need to sum the daily / hourly prices and substract the already paid amount. This amount "priceToBePaid" needs to be defined always in CZK and EUR currency. Exchange rate is 1 EUR = 26 CZK.



"priceToBePaid" calculation example for the first reservation:

```
25,3 * 4  = 101,2 - 50 = 51,2 EUR
51,2 EUR * 26 = 1331,2 Kč.
```

Use plain OOP PHP. Use interfaces, abstract classes, traits wherever it makes a sense to you. Consider using some design principles e.g. SOLID. Don't forget to treat the error states and incorrect inputs (e.g. file not exists, malformed json, empty price, etc.).

Please send the complete task to my e-mail address: petr.klas@previo.cz