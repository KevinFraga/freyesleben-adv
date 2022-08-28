import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import '../styles/login.css';

const axios = require('axios').default;

class FeedbackNew extends Component {
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

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  submitPost() {
    const { title, text } = this.state;
    const { userId } = this.props;

    const headers = { title, text, userId };

    axios
      .post('http://localhost:3007/post/feedback/new', headers)
      .then((_response) => {
        this.setState({ done: true });
      });
  }

  render() {
    const { title, text, done } = this.state;
    return (
      <div>
        {this.backlogo()}
        <div>
          <p className="title">NOVO DEPOIMENTO</p>
        </div>
        <div className="form login">
          {done && <Navigate to="/depoimentos" />}
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
      </div>
    );
  }
}

export default FeedbackNew;
