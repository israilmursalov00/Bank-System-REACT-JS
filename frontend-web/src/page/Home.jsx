import { useState, useEffect } from 'react';


import { useCookies } from "react-cookie";


import { Routes, Route, Link, NavLink, useNavigate, useLocation } from "react-router-dom";

import "../css/home.css";

import { SyncLoader } from "react-spinners";

import styled from "styled-components";


import { BsFillCreditCardFill } from "react-icons/bs";

import Menu from "../components/Menu.jsx";



const Container = styled.div`
`;

const Wrapper = styled.div`
`;




const LoaderWrapper = styled.div`
	margin-top:150px;
	margin-left:49%;
`;


const TextHead = styled.h2``;

const TableDiv = styled.div`
	margin-top:25px;
	padding:10px;
	display:flex;
	justify-content:center;
`;

const Table = styled.div`
	padding:15px;
	border-radius:10px;
	background:#ccc;
	margin-left:10px;
`;


const Text = styled.span`
	font-weight:bold;
`;

const TextP = styled.p`
	margin-top:5px;

`;





const ServiceContainer = styled.div`

	margin-top:50px;

`;

const ServiceWrapper = styled.div`
	margin:auto;
`;

const CreditCard = styled.div`
	
	margin-top:10px;
`;

const Card = styled.div`
	display:flex;
	margin-top:10px;
	border:2px solid #ccc;
	border-radius:10px;
	padding:10px;
	flex:1;
	width:20%;
`;

const Icon = styled.div`
	align-items:center;
	margin-right:10px;
	margin-top:2.5px;
`;

const CardName = styled.div`

`;




const Home = () => {

	const [cookie, setCookie] = useCookies([]);

	const SITE_URL = "http://localhost/payment_system/";

	const [UserData, setUserData] = useState({});

	const Navigate = useNavigate();

	const [isLoading, setIsLoading] = useState(false);

	const [UserCart, setUserCart] = useState({});


	useEffect(() => {

		if (isLoading) return;

		const getToken = async () => {


 await fetch(SITE_URL + "user_info", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow',
      referrer: 'no-refferrer',
      body: `opr=home&browser_token=${cookie.browser_id}`
    }).then(res => res.json()).then(data => {

         sessionStorage.setItem("token", data.USER_TOKEN);
    });

		}
		getToken();


		const UserInfo = async () => {

 await fetch(SITE_URL + "get_user", {
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

    				var user_data = data?.data;

					setUserData(user_data);

					sessionStorage.setItem("username", user_data?.name);

					sessionStorage.setItem("lastname", user_data?.lastname);


         
    });



		}

		UserInfo();



		
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

	}, [UserData, UserCart]);




	if (!cookie.USER_SIGN) Navigate("/login");


	if (!isLoading) {
		return (
			<LoaderWrapper>
				<SyncLoader color="#36d7b7" width="150" height="6"/>
			</LoaderWrapper>
		);
	}




	return (
			<Container>
				<Wrapper>
				<Menu/>

				<TableDiv>
					<Table>
						<Text>FIN və Hesab kimliyiniz</Text>
						<TextP>{UserData?.finCode}</TextP>
					</Table>
					<Table>
						<Text>Bank Hesabında olan Məbləğ</Text>
						<TextP>{UserData?.money}</TextP>
					</Table>
				</TableDiv>

				<ServiceContainer>
					<Text>Kartlar/Hesablar</Text>
					<ServiceWrapper>
						<CreditCard>
							{UserCart?.map(cart => (
								<Card>
									<Icon>
										<BsFillCreditCardFill/>
									</Icon>
									<CardName>{cart.cart_name}</CardName>
								</Card>
							))}
						</CreditCard>
					</ServiceWrapper>
				</ServiceContainer>
				</Wrapper>
			</Container>

	);
};


export default Home;