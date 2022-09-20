import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import Emailer from '../components/emailer';

const axios = require('axios').default;

class Contact extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
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
    const { userId, loggedIn, profilepic } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} profilepic={profilepic} />
        <Emailer />
        <Footer />
      </div>
    );
  }
}

export default Contact;
