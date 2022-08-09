import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import BlogNewPost from '../components/blogNewPost';

class BlogNew extends Component {
  render() {
    return (
      <div>
        <Header />
        <BlogNewPost />
        <Footer />
      </div>
    );
  }
}

export default BlogNew;
