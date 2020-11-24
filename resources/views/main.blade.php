<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Magic Potion</title>

        <!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style></style>

        <script>
        	function calculateTotal() {
        		const cost = 49.99;
        		var quantity = document.getElementById('quantity');
        		return quantity * cost;
        	}
        </script>
    </head>

    <body class="antialiased" style="margin: 10%">
    	<h1>Magic Potion &#128302 &#10024</h1>

    	<p>Place an order of up to three items with the form below.</p>

    	<br>

        <!-- <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"> -->
            <!-- @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->
            <form action="/magic" method="POST">
            	<label for="personal-info">Personal Information</label><br><br>
            	<div id="personal-info">
	            	<!-- <label for="first-name">First name:</label> -->
	            	<input type="text" id="first-name" name="first-name" placeholder="First name">
	            	<!-- <br><br> -->

	            	<!-- <label for="last-name">Last name:</label> -->
	            	<input type="text" id="last-name" name="last-name" placeholder="Last name"><br><br>

	            	<!-- <label for="email">Email address:</label> -->
	            	<input type="email" id="email" name="email" placeholder="Email address">
	            	<!-- <br><br> -->

	            	<!-- <label for="phone-number">Phone number:</label> -->
	            	<input type="text" id="phone-number" name="phone-number" placeholder="Phone number"><br><br>
            	</div>

            	<label for="address-info">Address</label><br><br>
            		<div id="address-info">
	            		<input type="text" id="street-1" name="street-1" placeholder="Address line 1">
	            		<input type="text" id="street-2" name="street-2" placeholder="Address line 2"><br><br>
	            		<input type="text" id="city" name="city" placeholder="City">
	            		<input type="text" id="state" name="state" placeholder="State"><br><br>
	            		<input type="text" id="zip" name="zip" placeholder="Zip"><br><br>
	            	</div>

            	<label for="first-name">Payment Method</label><br><br>
            		<div id="payment-info">
	            		<input type="text" id="card-number" name="card-number" placeholder="Card number">
	            		<input type="text" id="expiration-date" name="expiration-date" placeholder="Expiration date"><br><br><br>
            		</div>

            	<!-- <label for="order-info">Order</label> -->
	 				<div id="order-info">
	 						<label for="quantity">Quantity:</label>;
		            		<input type="number" id="quantity" name="quantity" min="1" max="3">;

		            		<label for="total" style="padding: 2%">Total:</label>;
		            		<input type="text" id="total" name="total" value={{ calculateTotal()}} disabled><br><br>;
	            	</div>

            	<input type="submit" value="Submit">
            </form>
    </body>
</html>

