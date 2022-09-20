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
      profilepic: '/new-user.png',
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, profilepic } = response.data;
          this.setState({ userId: id, loggedIn: true, profilepic });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading, profilepic } = this.state;
    return (
      <div>
        {!loggedIn && !loading && <Navigate to="/" />}
        <Header userId={userId} loggedIn={loggedIn} profilepic={profilepic} />
        {!loading && <FeedbackNew userId={userId} />}
        <Footer />
      </div>
    );
  }
}

export default FeedNew;
