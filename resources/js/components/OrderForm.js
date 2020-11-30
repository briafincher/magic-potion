import axios from 'axios';
import React, { Component, useState, useEffect } from 'react';
import { useForm } from "react-hook-form";
import { ErrorMessage } from '@hookform/error-message';

export default function OrderForm() {
	const { register, handleSubmit, errors } = useForm();

	const price = 49.99;
	const [total, setTotal] = useState(price);

	const updateTotal = e => {
		setTotal(parseInt(e.target.value) * price);
	};

	const onSubmit = data => {
		data['total'] = total;

		axios.post('/api/magic', data)
			.then((response) => { location.reload() })
			.catch((error) => { location.reload() });
	}
	
	return (
		<form onSubmit={handleSubmit(onSubmit)}>
			<div className="container">
				<div className="h-100 align-items-center justify-content-center">
					<div className="row justify-content-center">
						<h1>Magic Potion <span role="img" aria-label="magic-ball">🔮</span><span role="img" aria-label="stars">✨</span></h1>
					</div>

					<div className="row justify-content-center">
						<p>Place an order of up to three items with the form below.</p>
					</div>
				</div><br />

				<div id="order-info">
					<div className="form-row">
						<div className="form-group col">
							<label htmlFor="quantity">Quantity</label>
							<select className="form-control" id="quantity" name="quantity" ref={register({ required: true })} onChange={(quantity)=>updateTotal(quantity)}>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</div>

						<div className="form-group col flex-nowrap">
							<label htmlFor="total">Total</label>
							<div className="input-group flex-nowrap">
								<div className="input-group-prepend">
								    <span className="input-group-text" id="dollar-sign">$</span>
								 </div>
								<input id="total" name="total" ref={register} value={total} disabled/>
							</div>
						</div>
					</div>
				</div><br />
				
				<label htmlFor="contact-info">Contact information</label><br />
				<div id="personal-info">
					<div className="form-row">
						<div className="form-group col">
							<input className="form-control" id="first-name" name="firstName" placeholder="First name" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="firstName" message="First name is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" id="last-name" name="lastName" placeholder="Last name" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="lastName" message="Last name is required" />
						</div>
					</div>

					<div className="form-row">
						<div className="form-group col">
							<input className="form-control" id="email" name="email" placeholder="Email address" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="email" message="Email address is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" id="phone" name="phone" placeholder="Phone number" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="phone" message="Phone number is required" />
						</div>
					</div>
				</div>

				<label htmlFor="address-info">Address</label><br />
				<div id="address-info">
					<div className="form-row">
						<div className="form-group col">
							<input className="form-control" id="address-street-1" name="address[street1]" placeholder="Address line 1" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="address[street1]" message="Street address is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" name="address[street2]" placeholder="Address line 2" ref={register({ required: false })} />
						</div>
					</div>

					<div className="form-row">
						<div className="form-group col">
							<input className="form-control" id="city" name="address[city]" placeholder="City" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="address[city]" message="City is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" id="state" name="address[state]" placeholder="State" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="address[state]" message="State is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" id="zip" name="address[zip]" placeholder="Zip" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="address[zip]" message="Zip code is required" />
						</div>
					</div>
				</div>

				<label htmlFor="first-name">Payment Method</label><br />
				<div id="payment-info">
					<div className="form-row">
						<div className="form-group col">
							<input className="form-control" id="card-number" name="payment[ccNum]" placeholder="Card number" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="payment[ccNum]" message="Credit card number is required" />
						</div>

						<div className="form-group col">
							<input className="form-control" id="expiration-date" name="payment[exp]" placeholder="Expiration date" ref={register({ required: true })} />
							<ErrorMessage errors={errors} name="payment[exp]" message="Expiration date is required" />
						</div>
					</div>
				</div>

				<input type="submit" value="Submit" />
			</div>
		</form>
	);
}
