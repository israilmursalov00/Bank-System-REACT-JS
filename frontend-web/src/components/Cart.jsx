import React, { useState, useEffect } from "react";
import { useCookies } from "react-cookie";


import {BarLoader} from "react-spinners";


import styled from "styled-components";

const Select = styled.select``;

const Option = styled.option``;


const Cart = ({ id, setSelect }) => {

  const [cookie, setCookie] = useCookies(['_Iolksu_T', '_cIdPlaJ', 'USER_SIGN', 'browser_id']);

	const [UserCart, setUserCart] = useState({});

	const [isLoading, setIsLoading] = useState(false);

	
	const SITE_URL = "http://localhost/payment_system/";

	useEffect(() => {    

		
		const Cart_Api = async () => {

			if(isLoading) return;

			 await fetch(SITE_URL+"get_cart", {
				method:"POST",
				mode:"cors",
				cache:"no-cache",
				credentials:'same-origin',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				redirect:'follow',
				referrer:'no-refferrer',
				body:`token=${sessionStorage.getItem("token")}`
			}).then(res=> res.json()).then(cart => (
				setUserCart(cart.data),
				setIsLoading(true)

			));


		}

		Cart_Api();

	}, [UserCart]);





	if(!isLoading) return <BarLoader color="#36d7b7"/>; 	

	return (
      <>
        <Select onChange={(e) => setSelect(e.target.value)}>
          <Option value="0" selected >Kart Seçin</Option>
            {UserCart?.map((cart) => (
              <Option value={cart.cart_number}>{cart.cart_name} {cart.cart_money+" AZN"}</Option>
          	))}
        </Select>  
        
      </>
	)
}


export default Cart;