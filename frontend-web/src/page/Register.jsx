import { useState, useEffect } from 'react';
import { cookies, useCookies } from "react-cookie";
import styled from "styled-components";
import {SyncLoader} from "react-spinners";




const Container = styled.div`
  
`;

const Wrapper = styled.div`
  margin-top:5%;
  margin-left:7%;
  margin-right:7%;
  background-color:#ccc;
  border-radius:8px;
  padding:20px;
`;

const InputDiv = styled.div`
  margin-top:10px;
`;

const Input = styled.input`
  margin-top:4px;
  padding:8px;
  outline:none;
  width:35%;
  border-radius:9px;
  border:2px solid #ccc;
  
  &:focus {
    border:2px solid #1da7d4;
   }
  
`;

const Text = styled.label`
  display:block;
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
  margin-top:15px;
  margin-left:5px;
`;







const Register = () => {

  const [cookie, setCookie] = useCookies(['_cIdPlaJ']);

  const [Message, setMessage] = useState({});

  const [UserInfo, setUserInfo] = useState({});

  const [isLoading, setIsLoading] = useState(false);


  const [Username, setUsername] = useState();

  const [Lastname, setLastname] = useState();

  const [Fin, setFin] = useState();

  const [Badher, setBadher] = useState();

  const [Mather, setMather] = useState();

  const [Password, setPassword] = useState();

  const SITE_URL = "http://localhost/payment_system/";

  const [Loader, setLoader] = useState(false);



  useEffect(() => {


    const getUserInfo =  async () => {

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
      body: `opr=register`
    }).then(res => res.json())
     .then(data => {
          setUserInfo(data);
          setIsLoading(true);
    });

    }


    getUserInfo();


  }, [UserInfo]);




  const ClientRegister = async () => {

    setLoader(true);

    await fetch(SITE_URL + "RegisterClient", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow',
      referrer: 'no-refferrer',
      body: `ip=${UserInfo.ip}&browser=${UserInfo.browser}&name=${Username}&lastname=${Lastname}&finCode=${Fin}&badher=${Badher}&mather=${Mather}&password=${Password}&token=${UserInfo.USER_NEW_TOKEN}`
    }).then(res => res.json()).then(data => {
        setLoader(false);
    
        setMessage(data);
    });
  }


  if (cookie.USER_SIGN) {
      window.location.href = '/';
      return;
  }

  return (
    <Container>
      <Wrapper>
        <InputDiv>
          <Text>ADI</Text>
          <Input type="text" onChange={(event) => setUsername(event.target.value)} />
        </InputDiv>
        <InputDiv>
          <Text>SOYADI</Text>
          <Input type="text" onChange={(event) => setLastname(event.target.value)} />
        </InputDiv>
        <InputDiv>
          <Text>FIN</Text>
          <Input type="text" onChange={(event) => setFin(event.target.value)} />
        </InputDiv>
        <InputDiv>
          <Text>ATA ADI</Text>
          <Input type="text" onChange={(event) => setBadher(event.target.value)} />
        </InputDiv>
        <InputDiv>
          <Text>ANA ADI</Text>
          <Input type="text" onChange={(event) => setMather(event.target.value)} />
        </InputDiv>
        <InputDiv>
          <Text>ŞİFRƏ</Text>
          <Input type="password" onChange={(event) => setPassword(event.target.value)} />
        </InputDiv>
      <Text  error={Message.error && true} warn={Message.warn && true} success={Message.success && true}>{Message.error || Message.warn || Message.success}</Text>
      <Button onClick={ClientRegister} loader={Loader}>{Loader ? <SyncLoader color="white" size={7}/> : "Register"}</Button>
      </Wrapper>
    </Container>
  );
};

export default Register;