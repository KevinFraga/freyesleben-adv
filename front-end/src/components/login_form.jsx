import React, { Component } from "react";
import '../styles/hub.css';

class LoginForm extends Component {
    constructor() {
        super();
        this.state = {
            menu: false,
            loggedIn: false,
            featured: false,
            email: '',
            password: ''
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

    render() {
        return (
            <div>
                <p>ACESSO EXCLUSIVO
                    ÁREA DE CLIENTES CADASTRADOS</p>
                {this.createInput('email', 'Login', 'login')}
                {this.createInput('password', 'Senha', 'login')}
                <p>AINDA NÃO faz parte DA COMUNIDADE?</p>
                <p>CADASTRE-SE AQUI</p>
                <span className="line" />
                {this.createInput('emailnew', 'Email', 'new')}
            </div>
        )
    }
}

export default LoginForm;
