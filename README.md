Authentication Service

This is a restful service created for user registration and authentication. It is very simple but yet covers what you need for creating and authentiating users.

Installation:
Clone the reposition and run composer install to install the required dependencies.

Generate a 32 character long random application key and add to the APP_KEY variable in .env.

Note: copy .env.example to .env

run php artisan jwt:secret to genrate secret key for JWTAuth.

**Register**
----
  Registers a user in the service.

* **URL**

  /api/register

* **Method:**

  `POST`
  
*  **URL Params**
 
   `None`

* **Data Params**

   ```
   first_name=[string],
   last_name=[string],
   middle_name=[string](optional),
   email=[email],
    phone=[string],
    address=[string](optional),
    password=[string]
  ```

* **Success Response:**

  * **Code:** 201 <br />
    **Content:** `{ id : 1, first_name : "Tom",last_name:"Jim",middle_name:"Tim",email:"tom@gmail.com",phone:"07011111111",address:"12 lagos road",full_name:"Tom Tim Jim" }`
 
* **Error Response:**

  * **Code:** 422 <br />
    **Content:** `{ email : ["The email field is required."] }`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/register",
      dataType: "json",
      type : "POST",
      data: { first_name: 'Tom',last_name:'Tim',phone:'07011111111',email:'tom@gmai.com',password:'sercet'}
      success : function(r) {
        console.log(r);
      }
    });
  ```

**Login**
----

* **URL**

  /api/login

* **Method:**

  `POST`
  
*  **URL Params**
 
   `None`

* **Data Params**

   ```
   email=[email],
    password=[string]
  ```

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{ token : "eoXhgfshydvsgfdddhdfddfscsgdfdtdvdxcdt", token_type: "bearer",expires_in: 3600 }`
 
* **Error Response:**

  * **Code:** 401 <br />
    **Content:** `{ message: "Invalid Email or Password"}`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/login",
      dataType: "json",
      type : "POST",
      data: {email:'tom@gmai.com',password:'sercet'}
      success : function(r) {
        console.log(r);
      }
    });
  ```


**Fetch User**
----

* **URL**

  /api/users/:id

* **Method:**

  `GET`
  
*  **URL Params**
 Required
   `id=[integer]`

* **Data Params**

  `None`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{id: 3,first_name: "John",last_name: "Nwachukwu",middle_name: null,email: "john@gmail.com",phone: "07030408944",address: "12 aba road",full_name: "John Nwachukwu"
}`
 
* **Error Response:**

  * **Code:** 404 <br />
    **Content:** `No query results for model [App\User] 7`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/users/1",
      dataType: "json",
      type : "GET",
      headers: { Authorization: 'Bearer ' + token },
      success : function(r) {
        console.log(r);
      }
    });
  ```

**Fetch All Users**
----

* **URL**

  /api/users

* **Method:**

  `GET`
  
*  **URL Params**
 
   `None`

* **Data Params**

  `None`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `[{id: 3,first_name: "John",last_name: "Nwachukwu",middle_name: null,email: "john@gmail.com",phone: "07030408944",address: "12 aba road",full_name: "John Nwachukwu"
},{id: 4,first_name: "Mark",last_name: "Nwachukwu",middle_name: null,email: "mark@gmail.com",phone: "07030408947",address: "2 aba road",full_name: "Mark Nwachukwu"
}]`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/users",
      dataType: "json",
      type : "GET",
      headers: { Authorization: 'Bearer ' + token },
      success : function(r) {
        console.log(r);
      }
    });
  ```

**Testing**
----

To test the api, make sure you have sqlite installed, then configure your phpunit.xml as show below:

```
 <php>
        <env name="APP_ENV" value="testing"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
    </php>
```
then run ./vendor/bin/phpunit on the terminal
