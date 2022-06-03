import React, { Component } from "react";
import { Link } from 'react-router-dom'
import "../styles/header.css"

class Header extends Component {
    constructor() {
        super();
        this.state = {
            menu: false,
            itens: ['Minha Conta', 'Quem Somos', 'Áreas de Atuação', 'Ações em Destaque', 'Nossos Parceiros', 'Depoimentos', 'Blog', 'Fale Conosco', 'Contato']
        };
        this.toggleMenu = this.toggleMenu.bind(this);
    }

    toggleMenu = () => this.setState({ menu: !this.state.menu });

    hamburguerMenu() {
        const { itens, menu } = this.state;
        return (
            <div className={menu ? 'open' : 'close'}>
                <ul className='menu-items'>
                    {itens.map((item) => <li key={item}>{item}</li>)}
                </ul>
            </div>
        )
    }

    render() {
        const { menu } = this.state;
        return (
            <div>
                <div className="NavBar">
                    <div className={menu ? 'open' : 'close'} onClick={this.toggleMenu}>
                        <div className="hamburger-lines">
                            <span className="line line1"></span>
                            <span className="line line2"></span>
                            <span className="line line3"></span>
                        </div>
                    </div>
                    <img src="logo.png" alt="logo" id="logo" />
                    <Link to='login'><img src="login-removebg-preview.png" alt="login" id="login" /></Link>
                </div>
                {this.hamburguerMenu()}
            </div>
        )
    }
}

export default Header;
