<h1 align="center">Magic Potion <span role="img" aria-label="magic-ball">🔮</span><span role="img" aria-label="stars">✨</span></h1></p>

<p align="center">
	<a href="https://bf-magic-potion.herokuapp.com/">Live demo</a>
</p>

<!-- ### Quick links:
- [Architecture](https:github.com/briafincher/magic-potion#about-the-app)
- [Local installation](https:github.com/briafincher/magic-potion#about-the-app) -->

## Summary 

Magic Potion is a single-page web application that displays a form for processing user orders. 

<img src="https://imgur.com/CrTQ7S1.png" width="800" />

The form allows users to select a quantity of Magic Potion items to order and displays a total based on the item price. After the user inputs required identifying information including their name, email address, phone number, address and payment method, the form submits a `POST` request to the server API, which creates an order in the database. 

Users are allowed a total of three Magic Potion items per month (e.g. a user may place more than one order in a given month, but the total quantity of items ordered may not exceed 3).

#### Tech Stack
This project is built with Laravel (PHP), React and the `react-hook-form` package.

## About the app

### Data Model

The Magic Potion app is built on four models: `User`, `Address`, `PaymentMethod` and `Order`. 

#### User
A `User` represents a single user who may place an order. `User`s have the following properties:
```
'id': integer
'first_name': string
'last_name': string
'email': string
'phone': string
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that `User`s have a one-to-one relationship with both `PaymentMethod`s and `Address`es. A `User` can have many `Order`s; however, they are limited to 3 orders per month. These collections can be accessed with the `payment_method()`, `address()` and `orders()` methods, respectively.

`User` objects also have access to a method called `orders_per_month()`, which takes in a given `date` array and calculates the quantity of items ordered in that month.

#### Address
An `Address` contains details about a `User`'s address. `Address`es have the following properties:
```
'id': integer
'street_1': string
'street_2': string
'city': string
'state': string
'zip': string
'user_id': string
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that `Address`es have a one-to-one relationship with `User`s. This collection can be accessed with the `user()` method.

All `Order`s associated with an `Address` can be accessed via the `orders()` method.

#### PaymentMethod
A `PaymentMethod` represents credit card details for a `User`. `PaymentMethod`s have the following properties:
```
'id': integer
'card_number': string
'expiration_date': string
'user_id': string
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that `PaymentMethod`s have a one-to-one relationship with `User`s. This collection can be accessed with the `user()` method.

All `Order`s associated with a `PaymentMethod` can be accessed via the `orders()` method.

#### Order
An `Order` represents a request from a `User` to order up to a quantity of three Magic Potion items. `Order`s have the following properties:
```
'id': integer
'quantity': integer
'user_id': integer
'address_id': integer
'payment_method_id': integer
'fulfilled': boolean
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that `Order`s have one-to-one relationships with `User`s, `PaymentMethod`s and `Address`es. These collections can be accessed with the `user()`, `payment_method()` and `address()` methods, respectively.

An `Order` object also has access to a `total()` method, which calculates the dollar amount of the order's total based on the item price of $49.99. 

#### Assumptions
- The current architecture does not support multiple product offerings. This means that every `Order` is implicitly specifying a quantity of Magic Potion items to order, with a set price of $49.99. In the future, we could scale the functionality of our app by providing multi-product support. One potential implementation could include introducing data models such as `PurchaseOrder` (to represent the intent to order multiple items) and `ProductOrder` (to represent the intent to order a single product item, in the context of a `PurchaseOrder`). We would also need to introduce a `products` table and associated `Product` data model, which would include information necessary to build and calculate orders. Each of these improvements would necessitate migrations of our current tables.
- For simplicity, the current architecture assumes that a `User` has a one-to-one relationship with an `Address` and `PaymentMethod`. In the real world, a person might want to place orders to a work address and a separate home address, or they could have two different credit cards that they use. Updating these associations to be one-to-many would allow for greater flexibility.

### Frontend architecture
In lieu of a strictly RESTful API, the Magic Potion application leverages the provided Laravel `web` middleware in order to serve HTML views.

A `GET` API call to the home page renders a Blade view entitled `'app.blade.php'`. A Javascript script is injected into the view, which then builds and renders React components.

The main component of the application is `'App.js'`, which in turn renders `'OrderForm.js'`, the React component that contains our order form and associated logic.

The `OrderForm` component utilizes the `react-hook-form` package to render a form that uses hooks to update the disabled `#total` input, displaying the calculated total to the user based on the item quantity selected. 

The user is able to input information pertaining to contact details, address and payment method, which are each validated by their respective `required` input attribute. React Hook Form provides an `ErrorMessage` component that highlights form fields that did not pass validation upon submit. 

After a user submits the form, an `axios` call is made to the server, which returns the response and reloads the page in order to display a success/error flash message.

### API architecture
The Magic Potion application exposes five RESTful API routes:

- `GET '/api/'`
- `POST '/api/magic'`
- `GET '/api/magic/{uid}'`
- `PATCH '/api/magic`
- `DELETE '/api/magic/{uid}'`

Each of these routes makes a call to a specific method in the `MagicController` that is able to process the request.

#### `GET '/api/'`
This route shows the Magic Potion order form by rendering the `'app'` view. 

The `MagicController` method associated with this route is `showOrderForm()`.

#### `POST '/api/magic'`
This route accepts a JSON request and queries the database for the `User`, `Address` and `PaymentMethod` matching the request details. Otherwise, new object instances are created. 

After retrieving the appropriate database records, the user's monthly order quantities are calculated, and if the total including the requested quantity falls under the current three item threshold, the server creates an `Order`, returns a `201` JSON response with the `User`s `id` and displays a succesful flash message. 

If the quantity of items requested does not satisfy our order limit requirements, the order request is rejected, and the server renders a `422` response and displays the associated failure flash message. 

The `MagicController` method associated with this route is `createOrder()`.

##### Request structure:
```
{
   "firstName": "string", 
   "lastName": "string", 
   "email": "string", 
   "address": {
      "street1": "string", 
      "street2": "string", 
      "city": "string", 
      "state": "string", 
      "zip": "string"
   },
   "phone": "string", 
   "quantity": number, 
   "total": "string", 
   "payment": {
      "ccNum": "string",
      "exp": "string", 
   },
}
```

##### Response structure:
```
{
   "id": uid
}
```

#### `GET '/api/magic/{uid}'`
This route accepts a `uid` as a parameter, which represents an `Order` object's associated `id`.

The server queries the database for the requested `Order` and renders a JSON response with details including `quantity`, `total()`, `fulfilled` status and its associated `User`, `Address` and `PaymentMethod`. 

If the order is not found in the database, a `404`response is returned.

The `MagicController` method associated with this route is `showOrder()`.

##### Response structure:

```
{
   "firstName": "string", 
   "lastName": "string", 
   "email": "string", 
   "address": {
      "street1": "string", 
      "street2": "string", 
      "city": "string", 
      "state": "string", 
      "zip": "string",
   },
   "phone": "string", 
   "payment": {
      "ccNum": "string",
      "exp": "string", 
   },
   "quantity": number, 
   "total": "string", 
   "orderDate": date, 
   "fulfilled": bool,
}
```

#### `PATCH '/api/magic`
This route accepts a JSON request and queries the database for the requested `Order`.

The server queries the database for the requested `Order`, and if the record is found in the database, its `fulfilled` column is updated based on the request data, and a `200` response is returned. 

If no matching `Order` record exists, the server does not perform any database writes, and a `404` response is returned.

The `MagicController` method associated with this route is `updateOrder()`.

##### Request structure:

```
{
   "id": uid, 
   "fulfilled": bool
}
```

#### `DELETE '/api/magic/{uid}'`
This route accepts a `uid` as a parameter, which represents an `Order` object's associated `id`.

The server queries the database for the requested `Order`, and if the record is found in the database, it deletes the record and returns a `200` response. 

If no matching `Order` record exists, the server does not perform any database writes, and a `404` response is returned.

The `MagicController` method associated with this route is `deleteOrder()`.

### Potential future optimizations
- Support for multiple products
- UI improvements (e.g. better validation error highlighting, stricter form inputs, etc.)
- More comprehensive error handling
- User authentication / security improvements
- Type checking, schema annotations and linting for PHP conventions
- Enhanced test coverage

## Running the app
While this app is served live on [Heroku](https://bf-magic-potion.herokuapp.com/), users can also clone the repository for local development. The following instructions assume that you have PHP (and [Composer](https://getcomposer.org/)), MySQL and NPM installed.

Clone the repository:
```
git clone https://github.com/briafincher/magic-potion.git
cd magic-potion
```

Install dependencies:
```
composer install
npm install
```

To take advantage of default configuration, create a MySQL database named `magic`. Otherwise, you can update `'config\database.php'` and/or your local `.env` to point to a different database.

Run migrations:
```
php artisan migrate
```

Load frontend:
```
npm run development
```

Start the app:
```
php artisan serve
```

You can now view the app by visiting http://127.0.0.1:8000/ or localhost:8000.


## Made with help from
- [Laravel](https://laravel.com/) docs
- [React Hook Form](https://react-hook-form.com/) docs
- [Pusher blog](https://blog.pusher.com/react-laravel-application/) for initial React scaffolding
- The ever-helpful [StackOverflow](https://stackoverflow.com/) and [Laracasts](https://laracasts.com/) communities

