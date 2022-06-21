import React, { Component } from 'react';
import Header from '../components/header';
import Curriculum from '../components/curriculum';
import Motivation from '../components/motivation';

class WhoWeAre extends Component {
    render() {
        return (
            <div>
                <Header />
                <Curriculum />
                <Motivation />
            </div>
        )
    }
}

export default WhoWeAre;