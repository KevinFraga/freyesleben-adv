import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import Header from '../components/header';
import Footer from '../components/footer';
import Downloader from '../components/downloader';

const axios = require('axios').default;

class Download extends Component {
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
          this.setState({ userId: id, loggedIn: true, loading: false });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
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
        {!loading && <Downloader userId={userId} />}
        <Footer />
      </div>
    );
  }
}

export default Download;
