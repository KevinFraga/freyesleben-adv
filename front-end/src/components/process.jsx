import React, { Component } from 'react';
import '../styles/curriculum.css';

class Process extends Component {
  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { name, step } = this.props;
    
    let pct = '0%';
    if (step === 'Cadastro criado, favor enviar documentos.') {
      pct = '25%';
    } else if (step === 'Documentos recebidos, favor assinar e enviar o contrato.') {
      pct = '50%'
    }
    const progress = { width: pct };
    
    return (
      <div>
        {this.backlogo()}
        <h1 className="user-name">{name}:</h1>
        <div className="slider">
          <div className="slidebar" style={progress}/>
        </div>
        <div className="post">
          <p className="p-text">Seu processo encontra-se na seguinte etapa:</p>
          <p className="p-text">{step}</p>
        </div>
      </div>
    );
  }
}

export default Process;
