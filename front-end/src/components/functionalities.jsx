import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';

const axios = require('axios').default;

class Functionalities extends Component {
  constructor() {
    super();
    this.state = {
      name: '',
      userId: 0,
      loggedIn: false,
      loading: true,
    };
  }

  componentDidMount() {
    const token = localStorage.getItem('token');

    if (token) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name } = response.data;
          this.setState({ name, userId: id, loggedIn: true, loading: false });
        })
        .catch((error) => {
          alert(error.response.data.message);
          this.setState({ loggedIn: false, loading: false });
        });
    } else {
      this.setState({ loggedIn: false, loading: false });
    }
  }

  render() {
    const { name, loggedIn, loading } = this.state;
    return (
      <div>
        {!loggedIn && !loading && <Navigate to="/" />}
        <h1>Olá, {name}</h1>
        <p>This is an example of a functionality component.</p>
      </div>
    );
  }
}

export default Functionalities;
