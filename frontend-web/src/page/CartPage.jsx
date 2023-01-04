import React, { useState, useEffect } from "react";

import {useCookies} from "react-cookie";

import CartOptions from "../components/CartOptions.jsx"; 

import "../css/cart.css";

import styled from "styled-components";

import { ClipLoader } from "react-spinners";

import { useNavigate } from "react-router-dom";

import Menu from "../components/Menu.jsx";



const Container = styled.div``;

const Wrapper = styled.div`
`;


const LoaderWrapper = styled.div`
	margin-top:150px;
	margin-left:49%;
`;




const CartPage =  () => {

	const [cookie, setCookie] = useCookies(['_Iolksu_T','_cIdPlaJ']);

	const [isLoading, setIsLoading] = useState(false);

	const [CartDataApi, setCartDataApi] = useState({});

    const Navigate = useNavigate();


	const SITE_URL = "http://localhost/payment_system/";

	const CartData = async () => {

	if(isLoading) return;

   await fetch(SITE_URL + "get_cart", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow',
      referrer: 'no-refferrer',
      body: `token=${sessionStorage.getItem("token")}`
    }).then(res => res.json()).then(data => {
          setCartDataApi(data.data);

          setIsLoading(true);
    });	

	}

    CartData();

    if(!cookie.USER_SIGN) Navigate("/login"); 


	return (
		<Container>
		<Menu/>
			<Wrapper>
				{!isLoading ? (
					<LoaderWrapper>
						<ClipLoader color="#36d7b7" width="150" height='6'/>
					</LoaderWrapper>

				) : CartDataApi?.map((cart) => (
					<CartOptions CartNames={cart.cart_name} CartNumbers={cart.cart_number}/>
				))}
			</Wrapper>
		</Container>
	);
}

export default CartPage;