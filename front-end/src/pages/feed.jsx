import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Feedback from '../components/feedback';

const axios = require('axios').default;

class Feed extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
      loading: true,
      role: '',
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, role } = response.data;
          this.setState({ userId: id, loggedIn: true, role, loading: false });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, role, loading } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} />
        {!loading && <Feedback userId={userId} role={role} />}
        <Footer />
      </div>
    );
  }
}

export default Feed;
