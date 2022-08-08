import React, { Component } from 'react';
import Header from '../components/header';
import Footer from '../components/footer';
import BlogPosts from '../components/blogPosts';

class Blog extends Component {
  render() {
    return (
      <div>
        <Header />
        <BlogPosts />
        <Footer />
      </div>
    );
  }
}

export default Blog;
