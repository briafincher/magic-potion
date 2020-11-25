import axios from 'axios';
import React, { Component, useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useForm, ErrorMessage } from "react-hook-form";

// class OrderForm extends Component {
// 	// https://blog.pusher.com/react-laravel-application/
// 	// constructor() {
// 		// super();
// 		// this.state = {
// 			// data: {}
// 		// };
// 	// }

// 	// componentDidMount() {
// 		// axios.get('api/showOrderForm').then(response => {
// 			// this.setState({
// 				// data: response.data
// 			// });
// 		// });
// 	// }

// 	render() {
// 		// const { data } = this.state
		
// 		return(
// 			<div>
// 		        <form action="/magic" method="POST">

// 		        	<label htmlFor="personal-info">Personal Information</label><br /><br />
// 			        	<div id="personal-info">
// 			            	<input type="text" id="firstName" name="firstName" placeholder="First name" />
// 			            	<br /><br />

// 			            	<input type="text" id="lastName" name="lastName" placeholder="Last name" /><br /><br />

// 			            	<input type="email" id="email" name="email" placeholder="Email address" />
// 			            	<br /><br />

// 			            	<input type="text" id="phone" name="phone" placeholder="Phone number" /><br /><br />
// 			        	</div>

// 		        	<label htmlFor="address-info">Address</label><br /><br />
// 		        		<div id="address-info">
// 		            		<input type="text" id="street1" name="address[street1]" placeholder="Address line 1" />
// 		            		<input type="text" id="street2" name="address[street2]" placeholder="Address line 2" /><br /><br />
// 		            		<input type="text" id="city" name="address[city]" placeholder="City" />
// 		            		<input type="text" id="state" name="address[state]" placeholder="State" /><br /><br />
// 		            		<input type="text" id="zip" name="address[zip]" placeholder="Zip" /><br /><br />
// 		            	</div>

// 		        	<label htmlFor="first-name">Payment Method</label><br /><br />
// 		        		<div id="payment-info">
// 		            		<input type="text" id="ccNum" name="payment[ccNum]" placeholder="Card number" />
// 		            		<input type="text" id="exp" name="payment[exp]" placeholder="Expiration date" /><br /><br /><br />
// 		        		</div>

// 		        	<label htmlFor="order-info">Order</label>
// 		 				<div id="order-info">
// 								<label htmlFor="quantity">Quantity:</label>
// 		            		<input type="number" id="quantity" name="quantity" min="1" max="3" />

// 		            		<label htmlFor="total" style={{ padding: '2%' }}>Total:</label>
// 		            		<input type="text" id="total" name="total" disabled /><br /><br />
// 		            	</div>

// 		        	<input type="submit" value="Submit" />
// 		        </form>
// 			</div>
// 		);
// 	}
// }

// export default OrderForm;

export default function OrderForm() {
	const { register, handleSubmit, watch, errors } = useForm();

	// const onSubmit = data => console.log(data);
	const onSubmit = data => {
		data['total'] = total;
		console.log(data);

		axios.post('/magic', data).then((response) => console.log(response));
	}

	useEffect(() => {});

	const price = 49.99;
	const [total, setTotal] = useState(price);

	// useEffect(() => {}, [total]);

	const updateTotal = e => {
		// debugger;
		setTotal(parseInt(e.target.value) * price);
	};

	// let quantity = watch('quantity');
	// const totale = () => quantity * 49.99;

	return (
		<form onSubmit={handleSubmit(onSubmit)}>

			<label htmlFor="personal-info">Personal Information</label><br />
			<div id="personal-info">
				<input name="firstName" placeholder="First name" ref={register({ required: true })} />
				<input name="lastName" placeholder="Last name" ref={register({ required: true })} />
				<input name="email" placeholder="Email address" ref={register({ required: true })} />
				<input name="phone" placeholder="Phone number" ref={register({ required: true })} />
			</div>

			<label htmlFor="address-info">Address</label><br />
			<div id="address-info">
				<input name="address[street1]" placeholder="Address line 1" ref={register({ required: true })} />
				<input name="address[street2]" placeholder="Address line 2" ref={register({ required: true })} />
				<input name="address[city]" placeholder="City" ref={register({ required: true })} />
				<input name="address[state]" placeholder="State" ref={register({ required: true })} />
				<input name="address[zip]" placeholder="Zip" ref={register({ required: true })} />
			</div>

			<label htmlFor="first-name">Payment Method</label><br />
			<div id="payment-info">
				<input name="payment[ccNum]" placeholder="Card number" ref={register({ required: true })} />
				<input name="payment[exp]" placeholder="Expiration date" ref={register({ required: true })} />
			</div>

			<label htmlFor="order-info">Order</label>
			<div id="order-info">
				Quantity:&nbsp;<select name="quantity" ref={register({ required: true })} onChange={(quantity)=>updateTotal(quantity)}>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
				&nbsp;Total:&nbsp;<input name="total" disabled ref={register} value={total} />
			</div>

			<input type="submit" value="Submit" />
		</form>
	);
}
