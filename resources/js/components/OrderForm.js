import axios from 'axios';
import React, { Component, useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useForm, ErrorMessage } from "react-hook-form";

export default function OrderForm() {
	const { register, handleSubmit, watch, errors } = useForm();

	const onSubmit = data => {
		data['total'] = total;
		console.log(data);

		axios.post('/magic', data).then((response) => console.log(response));
	}


	const price = 49.99;
	const [total, setTotal] = useState(price);

	const updateTotal = e => {
		setTotal(parseInt(e.target.value) * price);
	};

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
