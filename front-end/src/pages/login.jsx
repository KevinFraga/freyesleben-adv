import React, { Component } from 'react';
import LoginForm from '../components/login_form';
import Header from '../components/header'

class Login extends Component {
    render() {
        return (
            <div>
                <Header />
                <LoginForm/>
            </div>
        )
    }
}

export default Login;
