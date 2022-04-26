import React from "react";
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './pages/home';
import Inspiration from "./pages/inspiration";
import Login from "./pages/login";
import Exclusive from "./pages/member_exclusive";
import Specialty from "./pages/specialty";
import Success from "./pages/success_cases";
import WhoWeAre from "./pages/who_we_are";
import './styles/app.css';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={ <Home /> } />
        <Route path="/inspiracao" element={ <Inspiration /> } />
        <Route path="/login" element={ <Login /> } />
        <Route path="/exclusivo_membros" element={ <Exclusive /> } />
        <Route path="/especialidades" element={ <Specialty /> } />
        <Route path="/cases_sucesso" element={ <Success /> } />
        <Route path="/quem_somos" element={ <WhoWeAre /> } />
      </Routes>
    </BrowserRouter>
  );
}

export default App;