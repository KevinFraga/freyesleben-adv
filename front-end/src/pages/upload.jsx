import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Uploader from '../components/uploader';

class Upload extends Component {
  render() {
    return (
      <div>
        <Header />
        <Uploader />
        <Footer />
      </div>
    );
  }
}

export default Upload;
