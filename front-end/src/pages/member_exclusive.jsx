import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import Header from '../components/header';
import Footer from '../components/footer';
import Functionalities from '../components/functionalities';

const axios = require('axios').default;

class Exclusive extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
      loading: true,
      name: '',
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
          const { id, name, profilepic } = response.data;
          this.setState({ userId: id, loggedIn: true, name, loading: false, profilepic });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading, name, profilepic } = this.state;
    return (
      <div>
        {!loggedIn && !loading && <Navigate to="/" />}
        <Header userId={userId} loggedIn={loggedIn} profilepic={profilepic} />
        {!loading && <Functionalities name={name} />}
        <Footer />
      </div>
    );
  }
}

export default Exclusive;
