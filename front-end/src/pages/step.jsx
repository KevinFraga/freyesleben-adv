import React, { Component } from 'react';
import Header from '../components/header';
import Process from '../components/process';
import Footer from '../components/footer';

const axios = require('axios').default;

class Step extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      name: '',
      loggedIn: false,
      loading: true,
      step: '',
      profilepic: '/new-user.png',
      processo: 0,
      color: 'green',
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name, step, profilepic, process, color } = response.data;
          this.setState({ userId: id, name, step, loggedIn: true, loading: false, profilepic, process, color });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading, name, step, profilepic, process, color } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} profilepic={profilepic} />
        {!loading && <Process name={name} step={step} process={process} color={color} />}
        <Footer />
      </div>
    );
  }
};

export default Step;
