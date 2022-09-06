import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import '../styles/login.css';

const axios = require('axios').default;

class Emailer extends Component {
  constructor() {
    super();
    this.state = {
      name: '',
      email: '',
      subject: '',
      text: '',
      done: false,
    };
    this.handleChange = this.handleChange.bind(this);
    this.sendEmail = this.sendEmail.bind(this);
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  handleChange({ target }) {
    this.setState({
      [target.name]: target.value,
    });
  }

  sendEmail() {
    const { name, email, subject, text } = this.state;

    const headers = { name, email, subject, text };

    axios.post('http://localhost:3007/post/email', headers).then((response) => {
      alert(response.data.message);
      this.setState({ done: true });
    });
  }

  render() {
    const { name, email, subject, text, done } = this.state;
    return (
      <div>
        {done && <Navigate to="/" />}
        {this.backlogo()}
        <div>
          <p className="title">Fale Conosco</p>
        </div>
        <div className="form new-user">
          <div className="login-form">
            <label htmlFor="name">Nome</label>
            <input
              type="name"
              id="name"
              name="name"
              value={name}
              onChange={this.handleChange}
            />
          </div>
          <div className="login-form">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              value={email}
              onChange={this.handleChange}
            />
          </div>
          {/* </div>
        <div className="form login"> */}
          <div className="login-form">
            <label htmlFor="subject">Assunto</label>
            <input
              type="text"
              id="subject"
              name="subject"
              value={subject}
              onChange={this.handleChange}
            />
          </div>
          <div className="login-form">
            <label htmlFor="text">Texto</label>
            <textarea
              id="text"
              name="text"
              value={text}
              onChange={this.handleChange}
            />
          </div>
          <div className="new-user-button-container">
            <button
              type="button"
              onClick={this.sendEmail}
              className="button new-user-button"
            >
              Enviar
            </button>
          </div>
        </div>
      </div>
    );
  }
}

export default Emailer;
