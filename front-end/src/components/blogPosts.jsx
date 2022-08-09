import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/curriculum.css';

const axios = require('axios').default;

class BlogPosts extends Component {
  constructor() {
    super();
    this.state = {
      posts: [],
    };
  }

  componentDidMount() {
    axios.get('http://localhost:3007/post').then((response) => {
      this.setState({ posts: response.data });
    });
  }

  render() {
    const { posts } = this.state;
    return (
      <div>
        <div className="titleBox">
          <p className="title">BLOG DO ADVOGADO</p>
          <p className="subtitle">O que penso sobre...</p>
          <Link to="novo">Novo Post</Link>
        </div>
        {posts.map((post) => (
          <div className="post">
            <div className="p-img">
              <p className="p-name">Alexandre Guerrieri Freyesleben</p>
              <img src="/Alexandre_sem_fundo.png" alt="alexandre" />
            </div>
            <div className="p-img">
              <p className="p-name">{post.title}</p>
              <p>{post.date}</p>
            </div>
            <div className="p-text">
              <p>{post.text}</p>
            </div>
          </div>
        ))}
      </div>
    );
  }
}

export default BlogPosts;
