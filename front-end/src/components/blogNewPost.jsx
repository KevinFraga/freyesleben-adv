import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import '../styles/login.css';

const axios = require('axios').default;

class BlogNewPost extends Component {
  constructor() {
    super();
    this.state = {
      title: '',
      text: '',
      done: false,
    };
    this.handleChange = this.handleChange.bind(this);
    this.submitPost = this.submitPost.bind(this);
  }

  handleChange({ target }) {
    this.setState({
      [target.name]: target.value,
    });
  }

  submitPost() {
    const { title, text } = this.state;

    const headers = { title, text };

    axios.post('http://localhost:3007/post/new', headers).then((_response) => {
      this.setState({ done: true });
    });
  }

  render() {
    const { title, text, done } = this.state;
    return (
      <div className="form login">
        {done && <Navigate to="/blog" />}
        <div className="login-form">
          <label htmlFor="title">Título do Post</label>
          <input
            type="text"
            id="title"
            name="title"
            value={title}
            onChange={this.handleChange}
          />
        </div>
        <div className="login-form">
          <label htmlFor="text">Texto</label>
          <textarea
            id="text"
            name="text"
            value={text}
            onChange={this.handleChange}
          />
        </div>
        <div className="new-user-button-container">
          <button
            type="button"
            onClick={this.submitPost}
            className="button new-user-button"
          >
            Postar
          </button>
        </div>
      </div>
    );
  }
}

export default BlogNewPost;
