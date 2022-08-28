import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import BlogPosts from '../components/blogPosts';

const axios = require('axios').default;

class Blog extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      loggedIn: false,
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
          this.setState({ userId: id, loggedIn: true, role });
        })
        .catch((error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false });
          alert(error.response.data.message);
        });
    }
  }

  render() {
    const { userId, loggedIn, role } = this.state;
    return (
      <div>
        <Header userId={userId} loggedIn={loggedIn} />
        <BlogPosts role={role} />
        <Footer />
      </div>
    );
  }
}

export default Blog;
