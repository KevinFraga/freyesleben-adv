import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Downloader from '../components/downloader';

class Download extends Component {
  render() {
    return (
      <div>
        <Header />
        <Downloader />
        <Footer />
      </div>
    );
  }
}

export default Download;
