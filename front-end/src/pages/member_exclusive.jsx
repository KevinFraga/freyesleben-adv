import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Functionalities from '../components/functionalities';

class Exclusive extends Component {
  render() {
    return (
      <div>
        <Header />
        <Functionalities />
        <Footer />
      </div>
    );
  }
}

export default Exclusive;
