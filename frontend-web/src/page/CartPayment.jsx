import React, { useState, useEffect } from "react";

import CartPaymentCom from "../components/CartPayment.jsx"; 

import { useNavigate } from "react-router-dom";

import styled from "styled-components";

import { cookie,useCookies } from "react-cookie";


import Menu from "../components/Menu.jsx";




const Container = styled.div``;

const Wrapper = styled.div``;

const CartPayment = () => { 

    const Navigate = useNavigate();

	const [CartNumber, setCartNumber] = useState('');

	const [cookie, setCookie] = useCookies([]);


	if(!cookie.USER_SIGN) Navigate("/login"); 

	return (
		<Container>
			<Menu/>
				<Wrapper>
					<CartPaymentCom/>	
				</Wrapper>				
		</Container>
	);
}



export default CartPayment;