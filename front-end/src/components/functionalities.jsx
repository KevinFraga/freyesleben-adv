import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/functionalities.css';

class Functionalities extends Component {
  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { name } = this.props;
    return (
      <div>
        {this.backlogo()}
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
