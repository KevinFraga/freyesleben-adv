import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/header.css';

class Header extends Component {
  constructor() {
    super();
    this.state = {
      menu: false,
      featured: false,
    };
    this.toggleMenu = this.toggleMenu.bind(this);
    this.toggleFeatured = this.toggleFeatured.bind(this);
    this.logout = this.logout.bind(this);
  }

  logout = () => {
    localStorage.removeItem('token');
  };

  toggleMenu = () => {
    this.setState({ menu: !this.state.menu });
    if (this.state.featured) this.toggleFeatured();
  };

  toggleFeatured = () => this.setState({ featured: !this.state.featured });

  hamburguerMenu() {
    const { menu, featured } = this.state;
    const { userId, loggedIn } = this.props;
    return (
      <div className={menu ? 'open' : 'close'}>
        <ul className="menu-items">
          <Link to={loggedIn ? `/membros/${userId}` : '/login'}>
            <li>Minha Conta</li>
          </Link>
          <Link to="/quem_somos">
            <li>Quem Somos</li>
          </Link>
          <li onClick={this.toggleFeatured}>Ações em Destaque</li>
          <ul className={featured ? 'seen' : 'unseen'}>
            <a href="/causas/#fgts">
              <li onClick={this.toggleMenu}>Revisão de Valores FGTS</li>
            </a>
            <a href="/causas/#emprestimos_AERUS">
              <li onClick={this.toggleMenu}>
                Ação Monitória Empréstimos AERUS
              </li>
            </a>
            <a href="/causas/#inventario_AERUS">
              <li onClick={this.toggleMenu}>
                Ação Inventário: Benefício AERUS
              </li>
            </a>
            <a href="/causas/#rateio">
              <li onClick={this.toggleMenu}>Recebimento de Rateios</li>
            </a>
          </ul>
          <Link to="/parceiros">
            <li>Nossos Parceiros</li>
          </Link>
          <Link to="/depoimentos">
            <li>Depoimentos</li>
          </Link>
          <Link to="/blog">
            <li>Blog</li>
          </Link>
          <Link to="/faleconosco">
            <li>Fale Conosco</li>
          </Link>
          <a href="/" onClick={this.logout}>
            <li>Sair</li>
          </a>
        </ul>
      </div>
    );
  }

  render() {
    const { menu } = this.state;
    const { userId, loggedIn } = this.props;
    return (
      <div>
        <div className="NavBar">
          <div className={menu ? 'open' : 'close'} onClick={this.toggleMenu}>
            <div className="hamburger-lines">
              <span className="line line1" />
              <span className="line line2" />
              <span className="line line3" />
            </div>
          </div>
          <img src="/logo.png" alt="logo" className="logo" />
          <Link to={loggedIn ? `/membros/${userId}` : '/login'}>
            <img src="/login-removebg-preview.png" alt="login" id="login" />
          </Link>
        </div>
        {this.hamburguerMenu()}
      </div>
    );
  }
}

export default Header;
