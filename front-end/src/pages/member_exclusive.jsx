import React, { Component } from 'react';
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
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name } = response.data;
          this.setState({ userId: id, loggedIn: true, name, loading: false });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading, name } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} />
        <Functionalities loggedIn={loggedIn} loading={loading} name={name} />
        <Footer />
      </div>
    );
  }
}

export default Exclusive;
