import React, { Component } from 'react';
import '../styles/curriculum.css';

class Process extends Component {
  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { name, step, process, color } = this.props;

    let pct = '0%';
    if (step === 'Cadastro criado, por favor envie os seus documentos.') {
      pct = '25%';
    } else if (
      step ===
      'Documentos recebidos, por favor assine e nos envie o seu contrato conosco.'
    ) {
      pct = '50%';
    } else if (
      step ===
      'Contrato recebido, por favor realize o pagamento e nos envie o comprovante para iniciarmos o processo.'
    ) {
      pct = '75%';
    } else if (step === 'Processo protocolado.') {
      pct = '100%';
    }
    const progress = { width: pct };
    const colored = { backgroundColor: color };

    return (
      <div>
        {this.backlogo()}
        <h1 className="user-name">{name}:</h1>
        <div className="slider">
          <div className="slidebar" style={progress} />
        </div>
        {process > 0 && (
          <div className="progress-bar">
            <div className="progress-step">
              <div className="step" style={process === 1 ? colored : null} />
              <p className="p-text">Protocolado</p>
            </div>
            <div className="progress-step">
              <div className="step" style={process === 2 ? colored : null} />
              <p className="p-text">Sentença</p>
            </div>
            <div className="progress-step">
              <div className="step" style={process === 3 ? colored : null} />
              <p className="p-text">Tribunais Superiores</p>
            </div>
            <div className="progress-step">
              <div className="step" style={process === 4 ? colored : null} />
              <p className="p-text">Execução</p>
            </div>
          </div>
        )}
        <div className="post">
          <p className="p-text">Seu processo encontra-se na seguinte etapa:</p>
          <p className="p-text">{step}</p>
        </div>
      </div>
    );
  }
}

export default Process;
