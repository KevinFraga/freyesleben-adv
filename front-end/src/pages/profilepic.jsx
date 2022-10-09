import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import Header from '../components/header';
import Footer from '../components/footer';
import ProfilepicUploader from '../components/profilepic_uploader';

const axios = require('axios').default;

class Profilepic extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      name: '',
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
          const { id, profilepic, name } = response.data;
          this.setState({ userId: id, loggedIn: true, loading: false, profilepic, name });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, loading, profilepic, name } = this.state;
    return (
      <div>
        {!loggedIn && !loading && <Navigate to="/" />}
        <Header userId={userId} loggedIn={loggedIn} profilepic={profilepic} />
        {!loading && <ProfilepicUploader userId={userId} name={name} />}
        <Footer />
      </div>
    );
  }
}

export default Profilepic;
