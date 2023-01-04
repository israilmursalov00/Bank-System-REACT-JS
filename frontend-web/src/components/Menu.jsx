import React from "react";

import styled from "styled-components";


import { Link } from "react-router-dom";

import { AiOutlineHome, AiOutlineCreditCard, AiOutlineBank, AiOutlineUser } from 'react-icons/ai';

import { MdPayment } from "react-icons/md";

import AddCardIcon from '@mui/icons-material/AddCard';

const Container = styled.div`
 padding:10px;
 margin:10px;
 background:#ccc;
 border-radius:10px;
`;

const Wrapper = styled.div`
	display:flex;
`;

const Cards = styled.div`
	justify-content:end;
	display:flex;
	flex:3;
`;


const MenuWrapper = styled.div`
	padding:5px;
	text-align:center;
	margin-left:10px;
`;


const Icon = styled.div`
	text-align:center;
`;

const Text = styled.span`
	border-bottom:2px solid;
	font-size:12px;
`;

const TextP = styled.p`
	border-bottom:2px solid;
`;




const UserWrapper = styled.div`
	text-align:center;
`;

const UserName = styled.p``;



const Menu = () => {

    const username = sessionStorage.getItem("username");

	const lastname = sessionStorage.getItem("lastname");

	return (
		<Container>
			<Wrapper>
			<UserWrapper>
				<Icon>
					<AiOutlineUser style={{fontSize:32}}/>
					<UserName>{username} {lastname}</UserName>
				</Icon>
			</UserWrapper>
			<Cards>
				<Link to="/">
				<MenuWrapper>
					<Icon>
						<AiOutlineHome style={{fontSize:29}}/>
					</Icon>
					<Text>Ev</Text>
				</MenuWrapper>
				</Link>
				<Link to="/cart_page">
				<MenuWrapper>
					<Icon>
						<AiOutlineCreditCard style={{fontSize:29}}/>
					</Icon>
					<Text>Kartlar</Text>
				</MenuWrapper>
				</Link>
				<Link to="/cart_payment">
				<MenuWrapper>
					<Icon>
						<MdPayment style={{fontSize:29}}/>
					</Icon>
					<Text>Kartan Karta Ödəniş</Text>
				</MenuWrapper>
				</Link>
				<Link to="/payment_send">
				<MenuWrapper>
					<Icon>
						<AiOutlineBank style={{fontSize:29}}/>
					</Icon>
					<Text>Bank Hesabına ödəniş</Text>
				</MenuWrapper>
				</Link>
				<Link to="/create_cart">
				<MenuWrapper>
					<Icon>
						<AddCardIcon style={{fontSize:29}}/>
					</Icon>
					<Text>Kartın Açılması</Text>
				</MenuWrapper>
				</Link>
				</Cards>
			</Wrapper>
		</Container>
	);
}


export default Menu;