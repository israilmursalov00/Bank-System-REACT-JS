import React from "react";
import Login from "./page/Login.jsx";
import Register from "./page/Register.jsx";
import Home from "./page/Home.jsx";
import CartPage from "./page/CartPage.jsx";
import CartPayment from "./page/CartPayment.jsx";
import PaymentSend from "./page/PaymentSend.jsx";
import CreateCartPage from "./page/cartCreate.jsx";


import { Routes, Route, Link, NavLink, Navigate} from "react-router-dom";


const App = () => {
  return (
    <>
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route path="/cart_page" element={<CartPage />} />
      <Route path="/cart_payment" element={<CartPayment />} />
      <Route path="/payment_send" element={<PaymentSend />} />
      <Route path="/create_cart" element={<CreateCartPage />} />
    </Routes>
    </>
  );

}



export default App;