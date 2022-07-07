import React, { Component } from 'react';
import Header from '../components/header';
import Cases from '../components/cases';

class Success extends Component {
    render() {
        return (
            <div>
                <Header />
                <Cases />
            </div>
        );
    }
}

export default Success;