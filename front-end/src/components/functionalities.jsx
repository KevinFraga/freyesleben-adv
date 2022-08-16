import React, { Component } from 'react';
import { Navigate, Link } from 'react-router-dom';
import '../styles/functionalities.css';

const axios = require('axios').default;

class Functionalities extends Component {
  constructor() {
    super();
    this.state = {
      name: '',
      userId: 0,
      loggedIn: false,
      loading: true,
      role: '',
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name, role } = response.data;
          this.setState({ name, userId: id, loggedIn: true, loading: false, role });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
        });
    } else {
      this.setState({ loggedIn: false, loading: false });
    }
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { name, loggedIn, loading } = this.state;
    return (
      <div>
        {this.backlogo()}
        {!loggedIn && !loading && <Navigate to="/" />}
        <h1 className="user-name">Olá, {name}</h1>
        <div className="func-container">
          <div className="func-row">
            <div className="func-col">
              <span>Consultar Processos</span>
              <span>&rsaquo;</span>
            </div>
            <div className="func-col">
              <Link to="upload">
                <span>Upload de Documentos</span>
                <span>&rsaquo;</span>
              </Link>
            </div>
          </div>
          <div className="func-row">
            <div className="func-col">
              <span>Acessar Contrato</span>
              <span>&rsaquo;</span>
            </div>

            <div className="func-col">
              <Link to="download">
                <span>Download de Documentos e Processos</span>
                <span>&rsaquo;</span>
              </Link>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Functionalities;
