import { useState } from "react";


import { useCookies } from "react-cookie";

import styled from "styled-components";

import {SyncLoader} from "react-spinners";

import { useNavigate } from "react-router-dom";

import Menu from "../components/Menu.jsx";


const Container = styled.div``;

const Wrapper = styled.div`
	margin:auto;
	margin-top:50px;
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
  margin-top:15px;
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
	width:200px;
	outline:none;
`;


const Select = styled.select``;

const Option = styled.option``;



const CreateCard = () => {


	const [CardName, setCardName] = useState('');
	
	const [CardValyuta, setCardValyuta] = useState('');

	const [Money,setMoney] = useState('');

	const SITE_URL='http://localhost/payment_system/';

	const Navigate = useNavigate();

    const [cookie, setCookie] = useCookies([]);

    const [Message,setMessage] = useState('');

    const [Loader, setLoader] = useState(false);

	const CreateCard = async () => {

		setLoader(true);

	   await fetch(SITE_URL + "cart", {
			method: "POST",
			mode: "cors",
			cache: "no-cache",
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			redirect: 'follow',
			referrer: 'no-refferrer',
			body:`token=${sessionStorage.getItem("token")}&cart_name=${CardName}&valyuta=${CardValyuta}`
		}).then(res => res.json()).then(message => {
			setMessage(message);
			setLoader(false);
		});
	}

	return (
		<Container>
		<Menu/>
			<Wrapper>
				<InputContainer>
					<Input
						type="text"
						placeholder="Kartın Adı (Mastercard, Visa)"
						onChange={(event) => setCardName(event.target.value)}
					/>
				</InputContainer>
				<InputContainer>
					<Select onChange={(event) => setCardValyuta(event.target.value)}>
						<Option>AZN</Option>
						<Option>EURO</Option>
						<Option>TRY</Option>
					</Select>
				</InputContainer>
				<Text error={Message.warn && true} error={Message.error && true} success={Message.success && true}>{Message.warn || Message.error || Message.success}</Text>
 		      <Button onClick={CreateCard} loader={Loader}>{Loader ? <SyncLoader color="white" size={7}/> : "Kartı Yarat"}</Button>
			</Wrapper>
		</Container>
	);
}


export default CreateCard;