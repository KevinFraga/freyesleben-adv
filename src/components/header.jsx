import React, { Component } from "react";
import { Link } from 'react-router-dom'
import "../styles/header.css"

class Header extends Component {
    render() {
        return (
            <div className="NavBar">                
                <Link to="login">Login</Link>
                <Link to="quem_somos">Quem Somos</Link>
                <Link to="inspiracao">Inspiração</Link>
                <Link to="especialidades">Especialidades</Link>
                <Link to="cases_sucesso">Cases de Sucesso</Link>
                <Link to="exclusivo_membros">Exclusivo para Membros</Link>
            </div>
        )
    }
}

export default Header;
