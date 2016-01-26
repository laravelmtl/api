FORMAT: 1A

# LaravelMTl

# Users [/users]
User resource representation. Version 1

# Users [/users]
User resource representation. Version 2

## Display a listing of the users. [GET /users]


+ Parameters
    + include (string, optional) - The entities to load per listing.
        + Default: 

## Store a newly created resource in storage. [POST /users]


+ Request (application/x-www-form-urlencoded)
    + Body

            username=foo&email=valid@email.com

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "username": "foo",
                "email": "valid@email.com"
            }