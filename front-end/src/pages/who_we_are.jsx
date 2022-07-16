import React, { Component } from 'react';
import Header from '../components/header';
import Curriculum from '../components/curriculum';
import Motivation from '../components/motivation';
import Footer from '../components/footer';

class WhoWeAre extends Component {
    render() {
        return (
            <div>
                <Header />
                <Curriculum />
                <Motivation />
                <Footer />
            </div>
        )
    }
}

export default WhoWeAre;