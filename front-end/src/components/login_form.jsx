import React, { Component } from 'react';
import '../styles/login.css';

const axios = require('axios').default;

class LoginForm extends Component {
  constructor() {
    super();
    this.state = {
      email: '',
      password: '',
      new_user_name: '',
      new_user_email: '',
      new_user_password: '',
      new_user_password_confirm: '',
    };
    this.handleChange = this.handleChange.bind(this);
    this.isValidLogin = this.isValidLogin.bind(this);
    this.isValidNewUser = this.isValidNewUser.bind(this);
    this.loginFunction = this.loginFunction.bind(this);
    this.createNewUser = this.createNewUser.bind(this);
  }

  handleChange = ({ target }) =>
    this.setState({
      [target.name]: target.value,
    });

  isValidLogin() {
    const { password, email } = this.state;

    const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9-]+\.[A-Z]{2,4}(\.[A-Z]{2})?$/i;
    const passwordRegex = /^.{6,25}$/;

    const emailTest = emailRegex.test(email);
    const passwordTest = passwordRegex.test(password);

    return emailTest && passwordTest;
  }

  isValidNewUser() {
    const {
      new_user_name,
      new_user_email,
      new_user_password,
      new_user_password_confirm,
    } = this.state;

    const nameRegex = /^[A-Z ]+$/i;
    const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9-]+\.[A-Z]{2,4}(\.[A-Z]{2})?$/i;
    const passwordRegex = /^.{6,25}$/;

    const new_user_name_test = nameRegex.test(new_user_name);
    const new_user_email_test = emailRegex.test(new_user_email);
    const new_user_password_test = passwordRegex.test(new_user_password);
    const new_user_password_confirm_test = passwordRegex.test(
      new_user_password_confirm
    );
    const password_confirm_test =
      new_user_password === new_user_password_confirm;

    return (
      new_user_name_test &&
      new_user_email_test &&
      new_user_password_test &&
      new_user_password_confirm_test &&
      password_confirm_test
    );
  }

  loginFunction() {
    const { email, password } = this.state;

    const headers = { email, password };

    axios.post('http://localhost:3007/login', headers);
  }

  createNewUser() {
    const { new_user_name, new_user_email, new_user_password } = this.state;

    const headers = {
      name: new_user_name,
      email: new_user_email,
      password: new_user_password,
    };

    axios
      .post('http://localhost:3007/user', { ...headers })
      .then((response) => {
        if (response.data.error) {
          console.log(response.data.error);
        }
        console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  createButton(registered) {
    return (
      <div>
        <button
          type="submit"
          disabled={registered ? !this.isValidLogin() : !this.isValidNewUser()}
          onClick={registered ? this.loginFunction : this.createNewUser}
          className={
            registered ? 'button login-button' : 'button new-user-button'
          }
        >
          Entrar
        </button>
      </div>
    );
  }

  createInput(type, title, className, kind) {
    return (
      <div className={className}>
        <label htmlFor={type}>{title}</label>
        <input id={type} name={type} type={kind} onChange={this.handleChange} />
      </div>
    );
  }

  render() {
    return (
      <div>
        <div className="form login">
          <div>
            <p>ACESSO EXCLUSIVO</p>
            <p>ÁREA DE CLIENTES CADASTRADOS</p>
          </div>
          {this.createInput('email', 'Email', 'login-form', 'email')}
          {this.createInput('password', 'Senha', 'login-form', 'password')}
          {this.createButton(true)}
        </div>
        <div className="form new-user">
          <div>
            <p>AINDA NÃO FAZ PARTE DA COMUNIDADE?</p>
            <p>CADASTRE-SE AQUI</p>
          </div>
          <span className="line" />
          {this.createInput(
            'new_user_name',
            'Nome Completo',
            'new-user-form',
            'name'
          )}
          {this.createInput(
            'new_user_email',
            'Email',
            'new-user-form',
            'email'
          )}
          <div className="new-user-password-container">
            <div className="new-user-password">
              {this.createInput(
                'new_user_password',
                'Senha',
                'new-user-form',
                'password'
              )}
              {this.createInput(
                'new_user_password_confirm',
                'Confirmação de Senha',
                'new-user-form',
                'password'
              )}
            </div>
            <div className="new-user-button-container">
              {this.createButton(false)}
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default LoginForm;
