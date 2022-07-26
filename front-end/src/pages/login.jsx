import React, { Component } from 'react';
import LoginForm from '../components/login_form';
import Header from '../components/header'
import Footer from '../components/footer';

class Login extends Component {
    render() {
        return (
            <div>
                <Header />
                <LoginForm/>
                <Footer />
            </div>
        )
    }
}

export default Login;
