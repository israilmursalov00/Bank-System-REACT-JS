import { useState, useEffect } from 'react';

import { useCookies } from "react-cookie";

import { Routes, Route, Link, NavLink, useNavigate, useLocation } from "react-router-dom";


import styled from "styled-components";

import {SyncLoader} from "react-spinners";


const Container = styled.div`
  
`;

const Wrapper = styled.div`
  padding:20px;
  margin-top:4%;
  margin-left:5%;
  margin-right:5%;
  background-color:#ccc;
  border-radius:10px;
`;

const LoginDiv = styled.div`
  
`;

const ContainerInput = styled.div`
  margin-top:10px;
`;

const HeaderLabel = styled.label``;

const Input = styled.input`
  display:block;
  border:2px solid #ccc;
  outline:none;
  width:35%;
  padding:8px;
  border-radius:15px;
  margin-bottom:10px;

   &:focus {
    border:2px solid #1da7d4;
   }
`;

const Text = styled.p`
  margin-top:10px;
  ${props => props.error ? "color:red" : false};
  ${props => props.warn ? "color:#be700f" : false};
  ${props => props.success ? "color:green" : false};
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
  cursor:pointer;
  ${props => props.loader ? "opacity:.6" : false};
  margin-left:5px;
`;



const Login = () => {


  const [UserData, setUserData] = useState({});

  const [UserInfo, setUserInfo] = useState({});


  const [cookie, setCookie] = useCookies(['_Iolksu_T', '_cIdPlaJ', 'USER_SIGN', 'browser_id']);


  const [fin, setFin] = useState();

  const [Password, setPassword] = useState();

  const location = useLocation();

  const [isLoading, setIsLoading] = useState(false);
  
  const [Loader, setLoader] = useState(false);

  const [ValueNull,setValueNull] = useState();

  const Navigate = useNavigate();

  const SITE_URL = "http://localhost/payment_system/";

  useEffect(() => {

    const Data = async () => {

      if (isLoading) return;



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
      body: `opr=login`
    }).then(res => res.json()).then(data => {
          setUserInfo(data);

          setIsLoading(true);
    });
    }


    Data();

  }, [UserInfo]);



  const Sign = async () => {

    setLoader(true);

   await fetch(SITE_URL + "sign", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow',
      referrer: 'no-refferrer',
      body: `ip=${UserInfo?.ip}&browser=${UserInfo?.browser}&finCode=${fin}&password=${Password}`
    }).then(res => res.json()).then(data => {
        
        setUserData(data);

        setLoader(false);

        if (data.browser_token) {
            document.cookie = `browser_id=${data.browser_token}`;

            document.cookie = `USER_SIGN=true`;

            Navigate("/");

          }
    });


  }


  if (cookie.USER_SIGN) Navigate("/");

  return (
    <Container>
      <Wrapper>
      <LoginDiv>
        <ContainerInput>
          <HeaderLabel>FIN</HeaderLabel>
          <Input type="text" name="finCode" onChange={(event) => setFin(event.target.value)} />
        </ContainerInput>
        <ContainerInput>
          <HeaderLabel>ŞİFRƏ</HeaderLabel>
          <Input 
            type="password" name="password" 
            onChange={(event) => setPassword(event.target.value)} 
          />
        </ContainerInput>
      <Text error={UserData.error && true} warn={UserData.warn && true} success={UserData.success && true}>{UserData.error || UserData.warn || UserData.success || ValueNull}</Text><br />
      <Button onClick={Sign} loader={Loader}>{Loader ? <SyncLoader color="white" size={7}/> : "Giriş"}</Button>
      </LoginDiv>
      </Wrapper>
    </Container>
  );
};

export default Login;