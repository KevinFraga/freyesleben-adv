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
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');

    if (token) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name } = response.data;
          this.setState({ name, userId: id, loggedIn: true, loading: false });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
        });
    } else {
      this.setState({ loggedIn: false, loading: false });
    }
  }

  render() {
    const { name, loggedIn, loading } = this.state;
    return (
      <div>
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
              <span>Assinar Contrato</span>
              <span>&rsaquo;</span>
            </div>

            <div className="func-col">
              <span>Minha Biblioteca</span>
              <span>&rsaquo;</span>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Functionalities;
