import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import Header from '../components/header';
import Footer from '../components/footer';
import FeedbackNew from '../components/feedbackNew';

const axios = require('axios').default;

class FeedNew extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
      loading: true,
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id } = response.data;
          this.setState({ userId: id, loggedIn: true });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading } = this.state;
    return (
      <div>
        {!loggedIn && !loading && <Navigate to="/" />}
        <Header userId={userId} loggedIn={loggedIn} />
        {!loading && <FeedbackNew userId={userId} />}
        <Footer />
      </div>
    );
  }
}

export default FeedNew;
