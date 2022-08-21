import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Emailer from '../components/emailer';

class Contact extends Component {
  render() {
    return (
      <div>
        <Header />
        <Emailer />
        <Footer />
      </div>
    );
  }
}

export default Contact;
