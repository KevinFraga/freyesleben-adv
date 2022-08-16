import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Feedback from '../components/feedback';

class Feed extends Component {
  render() {
    return (
      <div>
        <Header />
        <Feedback />
        <Footer />
      </div>
    );
  }
}

export default Feed;
