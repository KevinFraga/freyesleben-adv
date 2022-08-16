import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import FeedbackNew from '../components/feedbackNew';

class FeedNew extends Component {
  render() {
    return (
      <div>
        <Header />
        <FeedbackNew />
        <Footer />
      </div>
    );
  }
}

export default FeedNew;
