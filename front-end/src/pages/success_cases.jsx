import React, { Component } from 'react';
import Header from '../components/header';
import Cases from '../components/cases';
import Footer from '../components/footer';

class Success extends Component {
    render() {
        return (
            <div>
                <Header />
                <Cases />
                <Footer />
            </div>
        );
    }
}

export default Success;