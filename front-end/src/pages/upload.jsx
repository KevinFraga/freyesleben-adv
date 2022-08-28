import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Uploader from '../components/uploader';

const axios = require('axios').default;

class Upload extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
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
    const { userId, loggedIn } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} />
        <Uploader userId={userId} />
        <Footer />
      </div>
    );
  }
}

export default Upload;
