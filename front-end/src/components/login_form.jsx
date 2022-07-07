import React, { Component } from "react";
import '../styles/hub.css';

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
            new_user_password_confirm: ''
        };
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange = ({ target }) => this.setState({
        [target.name]: target.value,
    });


    createInput(type, title, classtype) {
        return (
            <div className={classtype}>
                <label htmlFor={type}>{title}</label>
                <input
                    id={type}
                    name={type}
                    type={type}
                    value={this.state.name}
                    onChange={this.handleChange}
                />
            </div>
        );
    }

    isValidLogin() {
        const { password, email } = this.state;

        const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9-]+\.[A-Z]{2,4}(\.[A-Z]{2})?$/i;
        const passwordRegex = /^.{6,8}$/;

        const emailTest = emailRegex.test(email);
        const passwordTest = passwordRegex.test(password);

        return emailTest && passwordTest;
    }

    isValidNewUser() {
        const { new_user_name, new_user_email, new_user_password, new_user_password_confirm } = this.state;

        const nameRegex = /^[A-Z]$/i;
        const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9-]+\.[A-Z]{2,4}(\.[A-Z]{2})?$/i;
        const passwordRegex = /^.{6,8}$/;

        const new_user_name_test = nameRegex.test(new_user_name);
        const new_user_email_test = emailRegex.test(new_user_email);
        const new_user_password_test = passwordRegex.test(new_user_password);
        const new_user_password_confirm_test = passwordRegex.test(new_user_password_confirm);
        const password_confirm_test = new_user_password == new_user_password_confirm;

        return new_user_name_test && new_user_email_test && new_user_password_test && new_user_password_confirm_test && password_confirm_test;
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
            password: new_user_password
        };
        
    }

    createButton(registered) {
        return (
            <div>
                <button
                    type="submit"
                    disabled={registered ? this.isValidLogin() : this.isValidNewUser()}
                    onClick={registered ? this.loginFunction : this.createNewUser()}
                ></button>
            </div>
        );
    }

    render() {
        return (
            <div>
                <div>
                    <p>ACESSO EXCLUSIVO</p>
                    <p>ÁREA DE CLIENTES CADASTRADOS</p>
                    {this.createInput('email', 'Login', 'login-form')}
                    {this.createInput('password', 'Senha', 'login-form')}
                    {this.createButton(true)}
                </div>
                <div>
                    <p>AINDA NÃO FAZ PARTE DA COMUNIDADE?</p>
                    <p>CADASTRE-SE AQUI</p>
                    <span className="line" />
                    {this.createInput('new_user_name', 'Nome Completo', 'new-user-form')}
                    {this.createInput('new_user_email', 'Email', 'new-user-form')}
                    <div>
                        <div>
                            {this.createInput('new_user_password', 'Senha', 'new-user-form')}
                            {this.createInput('new_user_password_confirm', 'Confirmação de Senha', 'new-user-form')}
                        </div>
                        {this.createButton(false)}
                    </div>
                </div>
            </div>
        )
    }
}

export default LoginForm;
