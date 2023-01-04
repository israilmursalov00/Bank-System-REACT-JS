import React, { useState, useEffect } from "react";

import { useCookies } from "react-cookie";

import Cart from "../components/Cart.jsx";

import styled from "styled-components";

import {SyncLoader} from "react-spinners";



const Container = styled.div``;

const Wrapper = styled.div`
	margin:auto;
	padding:20px;
	width:35%;
	border:3px solid #ccc;
	border-radius:8px;
	text-align:center;
	background:#ccc;

`;
 
const InputContainer = styled.div`
	margin-top:20px;
	text-align:center;
`;

const Button = styled.button`
  width:35%;
  height:40px;
  border:1px solid #169daf;
  padding:6px;
  color:white;
  background:#169daf;
  border-radius:15px;
  outline:none;
  ${props => props.loader ? "cursor:auto;" : "cursor:pointer;"};
  ${props => props.loader ? "opacity:.6;" : false};
  margin-left:5px;
`;


const Text = styled.p`
	margin-top:10px;
	margin-bottom:10px;
  	${props => props.error ? "color:red" : false};
  	${props => props.warn ? "color:#be700f" : false};
  	${props => props.success ? "color:green" : false};
`;


const Input = styled.input`
	padding:10px;
	border:2px solid #ccc;
	border-radius:8px;
	outline:none;
`;


const CartPayment = () => {


	const [cookie, setCookie] = useCookies(['_Iolksu_T', '_cIdPlaJ']);

	const [selectCart, setSelect] = useState();

	const [MemberCart, setMemberCart] = useState();

	const [MemberMoney, setMemberMoney] = useState();

	const [Message, setMessage] = useState({});
  	
  	const [Loader, setLoader] = useState(false);


	const [isLoading, setIsLoading] = useState(false);


	const SITE_URL = "http://localhost/payment_system/";


	const sendPayment = async () => {

		setLoader(true);

		await fetch(SITE_URL + "payment_cart", {
			method: "POST",
			mode: "cors",
			cache: "no-cache",
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			redirect: 'follow',
			referrer: 'no-refferrer',
			body: `token=${sessionStorage.getItem("token")}&member_cart_number=${MemberCart}&user_cart_number=${selectCart}&payment_money=${MemberMoney}`
		}).then(res => res.json()).then(message => (
			setMessage(message),
			setLoader(false)
		));
	}

	return (
		<Container>
			<Wrapper>
				<InputContainer>
					<Input
						type="number"
						name="memberCart"
						placeholder="Kartın nömrəsi"
						onChange={(event) => setMemberCart(event.target.value)}
					/>
				</InputContainer>
				<InputContainer>
					<Cart id={cookie._cIdPlaJ} setSelect={setSelect} />
				</InputContainer>
				<InputContainer>
					<Input
						type="number"
						name="payment"
						placeholder="Məbləğ"
						onChange={(event) => setMemberMoney(event.target.value)}
					/>
				</InputContainer>
				<Text error={Message.warn && true} error={Message.error && true} success={Message.success && true}>{Message.warn || Message.error || Message.success}</Text>
 		      <Button onClick={sendPayment} loader={Loader}>{Loader ? <SyncLoader color="white" size={7}/> : "Ödəniş Et"}</Button>
			</Wrapper>
		</Container>
	);
}


export default CartPayment;