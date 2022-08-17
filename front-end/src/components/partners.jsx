import React, { Component } from 'react';
import '../styles/partner.css';

class Partners extends Component {
  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    return (
      <div>
        {this.backlogo()}
        <div className="titleBox">
          <p className="title">Parcerias de Sucesso</p>
        </div>
        <div className="partner-container">
          <div className="partner">
            <div className="partner-logo-container">
              <div className="partner-logo">
                <p>Sua logo aqui</p>
              </div>
            </div>
            <div className="partner-info-container">
              <p>Divulgamos sua marca aqui.</p>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Partners;
