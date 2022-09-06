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
    return (
      <div>
        {this.backlogo()}
        <h1 className="user-name">{name}:</h1>
        <div className="post">
          <p className="p-text">Seu processo encontra-se na seguinte etapa:</p>
          <p className="p-text">{step}</p>
        </div>
      </div>
    );
  }
}

export default Process;
