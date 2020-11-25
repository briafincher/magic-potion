import axios from 'axios';
import React, { Component } from 'react';
import { Link } from 'react-router-dom';

class OrderForm extends Component {
	// https://blog.pusher.com/react-laravel-application/
	// constructor() {
		// super();
		// this.state = {
			// data: {}
		// };
	// }

	// componentDidMount() {
		// axios.get('api/showOrderForm').then(response => {
			// this.setState({
				// data: response.data
			// });
		// });
	// }

	render() {
		// const { data } = this.state
		
		return(
			<div>
				<h1>Magic Potion <span role="img" aria-label="magic-ball">🔮</span><span role="img" aria-label="stars">✨</span></h1>

	    		<p>Place an order of up to three items with the form below.</p>

	  			<br />

		        <form action="/magic" method="POST">

		        	<label htmlFor="personal-info">Personal Information</label><br /><br />
		        	<div id="personal-info">
		            	<label htmlFor="first-name">First name:</label>
		            	<input type="text" id="firstName" name="firstName" placeholder="First name" />
		            	<br /><br />

		            	<label htmlFor="last-name">Last name:</label>
		            	<input type="text" id="lastName" name="lastName" placeholder="Last name" /><br /><br />

		            	<label htmlFor="email">Email address:</label>
		            	<input type="email" id="email" name="email" placeholder="Email address" />
		            	<br /><br />

		            	<label htmlFor="phone-number">Phone number:</label>
		            	<input type="text" id="phone" name="phone" placeholder="Phone number" /><br /><br />
		        	</div>

		        	<label htmlFor="address-info">Address</label><br /><br />
		        		<div id="address-info">
		            		<input type="text" id="street1" name="address[street1]" placeholder="Address line 1" />
		            		<input type="text" id="street2" name="address[street2]" placeholder="Address line 2" /><br /><br />
		            		<input type="text" id="city" name="address[city]" placeholder="City" />
		            		<input type="text" id="state" name="address[state]" placeholder="State" /><br /><br />
		            		<input type="text" id="zip" name="address[zip]" placeholder="Zip" /><br /><br />
		            	</div>

		        	<label htmlFor="first-name">Payment Method</label><br /><br />
		        		<div id="payment-info">
		            		<input type="text" id="ccNum" name="payment[ccNum]" placeholder="Card number" />
		            		<input type="text" id="exp" name="payment[exp]" placeholder="Expiration date" /><br /><br /><br />
		        		</div>

		        	<label htmlFor="order-info">Order</label>
		 				<div id="order-info">
								<label htmlFor="quantity">Quantity:</label>
		            		<input type="number" id="quantity" name="quantity" min="1" max="3" />

		            		<label htmlFor="total" style={{ padding: '2%' }}>Total:</label>
		            		<input type="text" id="total" name="total" disabled /><br /><br />
		            	</div>

		        	<input type="submit" value="Submit" />
		        </form>
			</div>
		);
	}
}

export default OrderForm;