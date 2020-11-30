<h1 align="center">Magic Potion <span role="img" aria-label="magic-ball">🔮</span><span role="img" aria-label="stars">✨</span></h1></p>

<p align="center">
	<a href="https://bf-magic-potion.herokuapp.com/">Live demo</a>
</p>

<!-- ### Quick links:
- [Architecture](https:github.com/briafincher/magic-potion#about-the-app)
- [Local installation](https:github.com/briafincher/magic-potion#about-the-app) -->

## Summary 

Magic Potion is a single-page web application that displays a form for processing user orders. 

<img src="https://imgur.com/uorz0rT.png" width="800" />

The form allows users to select a quantity of Magic Potion items to order and displays a total based on the item price. After inputting required identifying information including their name, email address, phone number, address and payment method, the form submits a POST request to the server API, which creates an order in the database. 

Users are allowed a total of three Magic Potion items per month (e.g. a user may place more than one order in a given month, but the total quantity of items ordered may not exceed 3).

## About the app

### Data Model

The Magic Potion app is built on four models: `User`, `Address`, `PaymentMethod` and `Order`. 

#### User
A User represents a single user who may place an order. Users have the following properties:
```
'id': integer
'first_name': string
'last_name': string
'email': string
'phone': string
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that Users have a one-to-one relationship with both Orders and Addresses. A User can have many Orders, however, they are limited to 3 orders per month.

User objects have access to a method called `orders_per_month()` which take in a given `date` array, and calculates the quantity of items ordered in that month.

#### Address
An Address contains details about a User's address. Addresses have the following properties:
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
Our data model assumes that Addresses have a one-to-one relationship with Users. 

#### PaymentMethod
A PaymentMethod represents credit card details for a User. PaymentMethods have the following properties:
```
'id': integer
'card_number': string
'expiration_date': string
'user_id': string // Foreign key
'created_at': datetime
'updated_at': datetime
```
Our data model assumes that PaymentMethods have a one-to-one relationship with Users.

#### Order
An Order represents a request from a User to order up to a quantity of 3 Magic Potion items. Orders have the following properties:
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
Our data model assumes that Orders have one-to-one relationships with Users, PaymentMethods, and Addresses. 

An Order object also has access to a `total()` method, which calculates the dollar amount of the order's total based on the item price of $49.99. 

#### Assumptions
-
-

### Frontend architecture

### API architecture

### Potential future optimizations

- Support for multiple products
- UI improvements (e.g. better validation error highlighting)
- User authentication / security improvements
- Enhanced test coverage

## Running the app
While this app is served live on [link], users can also clone the repository for local development. The following instructions assume that you have PHP, MySQL and NPM installed.

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

