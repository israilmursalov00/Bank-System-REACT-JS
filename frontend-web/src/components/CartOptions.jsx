import { useState } from "react";
import styled from "styled-components";

import { BsFillCreditCard2FrontFill } from "react-icons/bs";


const Container = styled.div`

`;


const Wrapper = styled.div`

`;


const CartDiv = styled.div`
	margin-left: 30%;
    margin-right: 45%;
    padding:10px;
    border:2px solid #ccc;
    border-radius:10px;
    margin-top:10px;
`;

const CartName = styled.p`
	font-weight:700;
`;

const CartNumber = styled.span`
	font-size:12px;
	color:rgb(136, 136, 136);
`;

const Icon = styled.div``;

const CartOptions = ({CartNames, CartNumbers}) => {


	return (
		<Container>
			<Wrapper>
				<CartDiv>
					<Icon>
						<BsFillCreditCard2FrontFill style={{fontSize:25}}/>
					</Icon>
					<CartName>{CartNames}</CartName>
					<CartNumber>{CartNumbers}</CartNumber>	
				</CartDiv>
			</Wrapper>		
		</Container>
	);
}


export default CartOptions;